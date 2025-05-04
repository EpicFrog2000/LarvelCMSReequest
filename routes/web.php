<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminLoginController;
use App\Http\Controllers\wyswigController;
use App\Models\element_structures;
use Illuminate\Http\Request;
use App\Http\Controllers\Helper;

Route::get('/', function () {
    return view('home');
})->name('home');


Route::get('/admin/login', [adminLoginController::class, 'showForm'])->name('adminlogin.form');

Route::post('/admin/login', [adminLoginController::class, 'submitForm'])->name('adminlogin.submit');

Route::post('/seeChanges', function (Request $request) {
    $Changes = $request->input('Changes');
    if (!session('_auth')){
        return response()->json([
            'response' => 'SPIERDALAJ',
            'changes' => $Changes
        ], 403);
    }
    
    if (isset($Changes['modified']) && is_array($Changes['modified'])) {
        foreach ($Changes['modified'] as $modified_value) {
            App\Models\element_structures::UpdateElement($modified_value['jsonvariables'], $modified_value['id']);
        }
    }

    if (isset($Changes['removed']) && is_array($Changes['removed'])) {
        foreach ($Changes['removed'] as $removed_value) {
            App\Models\element_structures::RemoveElement($removed_value['id']);
        }
    }

    if (isset($Changes['added']) && is_array($Changes['added'])) {
        foreach ($Changes['added'] as $added_value) {
            // $line = json_encode($added_value, JSON_UNESCAPED_UNICODE) . PHP_EOL;
            // Storage::append('changes_log.txt', 'added: '.$line);
            // TODO DOKONCZ AGAIN XD
            //App\Models\element_structures::AddElement($added_value['jsonvariables'], $added_value['dev_name'], $added_value['view_name']);
        }
    }

    return response()->json([
        'response' => 'OK',
        'changes' => $Changes
    ], 200); // Kod statusu 200 OK
});


Route::get('/wyswig-element/{dev_name}', [wyswigController::class, 'getWyswigElement'])->name('getwyswigelement');

Route::get('/getWyswigTemplate/{dev_name}', [wyswigController::class, 'getWyswigTemplate'])->name('getwyswigtemplate');

Route::get('/getWyswigModules', function () {
    if (!session('_auth')) {
        return response()->json([
            'response' => 'Unauthorized'
        ], 403);
    }
    return app(wyswigController::class)->getWyswigModules();
});


Route::get('/getFilesAndFolders/{path}', function ($path) {
    if (!session('_auth')) {
        return response()->json([
            'response' => 'Unauthorized'
        ], 403);
    }
    $decodedPath = urldecode($path);
    return app(wyswigController::class)->getFilesAndFolders($decodedPath);
})->where('path', '.*');

Route::post('/changeName', function (Request $request) {
    if (!session('_auth')) {
        abort(403);
    }
    
    $path = $request->input('path');
    $newName = $request->input('newName');
    
    if (!$path || !$newName) {
        return response()->json([
            'response' => 'Missing path or newName'
        ], 400);
    }

    if (str_contains($newName, '/') || str_contains($newName, '\\')) {
        return response()->json([
            'response' => 'Invalid new name'
        ], 400);
    }

    $path = str_replace('\\', '/', $path);
    $relativePath = str_replace(url('/'), '', $path);
    $localPath = public_path($relativePath);
    $directory = dirname($localPath);

    
    if (is_dir($localPath)) {
        rename($localPath, $directory.DIRECTORY_SEPARATOR.$newName);
    } elseif (is_file($localPath)) {
        rename($localPath, $directory.DIRECTORY_SEPARATOR.$newName.pathinfo($localPath, PATHINFO_EXTENSION));
        
    } else {
        return response()->json([
            'response' => 'BadPath: '.$path
        ], 500);
    }
    return response()->json([
        'response' => 'OK'
    ], 200);

})->name('changeName');