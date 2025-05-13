<?php
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\wyswigController;
use App\Http\Controllers\adminLoginController;
use Illuminate\Http\Request;
use App\Http\Controllers\Helper;

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
        $newFolderPath = $directory . DIRECTORY_SEPARATOR . $newName;
        $counter = 1;

        while (is_dir($newFolderPath)) {
            $newFolderPath = $directory . DIRECTORY_SEPARATOR . $newName . '_' . $counter;
            $counter++;
        }

        rename($localPath, $newFolderPath);
    } elseif (is_file($localPath)) {
        $extension = pathinfo($localPath, PATHINFO_EXTENSION);
        $baseName = pathinfo($newName, PATHINFO_FILENAME);

        $dotExtension = $extension !== '' ? '.' . $extension : '';
        $newFilePath = $directory . DIRECTORY_SEPARATOR . $baseName . $dotExtension;

        $counter = 1;
        while (file_exists($newFilePath)) {
            $newFilePath = $directory . DIRECTORY_SEPARATOR . $baseName . '_' . $counter . $dotExtension;
            $counter++;
        }

        rename($localPath, $newFilePath);
    }

    return response()->json([
        'response' => 'OK'
    ], 200);

})->name('changeName');

Route::post('/deleteFileOrFolder', function (Request $request) {
    if (!session('_auth')) {
        abort(403);
    }
    
    $path = $request->input('path');
    
    if (!$path) {
        return response()->json([
            'response' => 'Missing path'
        ], 400);
    }

    $path = str_replace('\\', '/', $path);
    $relativePath = str_replace(url('/'), '', $path);
    $localPath = public_path($relativePath);



    if (is_dir($localPath)) {
        Helper::deleteDirectory($localPath);
    } elseif (is_file($localPath)) {
        unlink($localPath);
    } else {
        return response()->json([
            'response' => 'BadPath: '.$localPath
        ], 500);
    }
    return response()->json([
        'response' => 'OK'
    ], 200);

})->name('deleteFileOrFolder');

Route::post('/uploadFiles', function (Request $request) {
    if (!session('_auth')) {
        abort(403);
    }
    
    $relativePath = $request->input('path');
    $baseMediaPath = public_path('media');
    $fullPath = public_path($relativePath);
    if (!str_starts_with(realpath($fullPath), realpath($baseMediaPath))) {
        return response()->json([
            'response' => 'Nieprawidłowa ścieżka: ' . $relativePath
        ], 400);
    }

    if (!is_dir($fullPath)) {
        return response()->json([
            'response' => 'Folder nie istnieje: ' . $relativePath
        ], 400);
    }

    $request->validate([
        'files.*' => 'required|file|max:10240',
    ]);

    foreach ($request->file('files') as $file) {
        if ($file->isValid()) {
            $originalName = $file->getClientOriginalName();
            $filePath = $fullPath . DIRECTORY_SEPARATOR . $originalName;
            $fileName = pathinfo($originalName, PATHINFO_FILENAME);
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            $counter = 1;

            while (file_exists($filePath)) {
                $newName = $fileName . '_' . $counter . '.' . $extension;
                $filePath = $fullPath . DIRECTORY_SEPARATOR . $newName;
                $counter++;
            }

            $file->move($fullPath, basename($filePath));
        }
    }

    return response()->json([
        'response' => 'OK'
    ], 200);

})->name('uploadFiles');


Route::post('/createNewFolder', function (Request $request) {
    if (!session('_auth')) {
        abort(403);
    }
    
    $relativePath = $request->input('path');
    $fullPath = public_path($relativePath);
    $baseFolderName = 'NewFolder';
    $newFolderPath = $fullPath . DIRECTORY_SEPARATOR . $baseFolderName;
    $counter = 1;

    if (!is_dir($fullPath)) {
        return response()->json([
            'response' => 'Folder does not exist: ' . $relativePath
        ], 400);
    }

    while (is_dir($newFolderPath)) {
        $newFolderPath = $fullPath . DIRECTORY_SEPARATOR . $baseFolderName . '_' . $counter;
        $counter++;
    }

    mkdir($newFolderPath, 0755, true);

    return response()->json([
        'response' => 'OK',
        'folderName' => basename($newFolderPath)
    ], 200);

})->name('createNewFolder');

Route::post('/saveWyswig', function (Request $request) {
    if (!session('_auth')) {
        abort(403);
    }

    $BIGelement_changes = $request->input('BIGelement_changes');
    $elements_changes = $request->input('elements_changes');
    $variable_changes = $request->input('variable_changes');

    try{
        DB::beginTransaction();
        if($BIGelement_changes){
            $elements = $BIGelement_changes['deleted'];
            $response = \App\Models\element_structures::RemoveElements($elements);

            if(!$response['success']){
                DB::rollBack();
                return $response;
            }
            
        }

        DB::commit();
        return response()->json(['success' => true], 200);
    }catch(\Exception $e){
        DB::rollBack();
        return response()->json(['success' => false, 'error' => $e->getMessage()], 500);

    }

})->name('saveWyswig');





// DEPR ?
Route::get('/wyswig-element/{dev_name}', [wyswigController::class, 'getWyswigElement'])->name('getwyswigelement');

Route::get('/getWyswigTemplate/{dev_name}', [wyswigController::class, 'getWyswigTemplate'])->name('getwyswigtemplate');

