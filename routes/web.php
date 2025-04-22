<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminLoginController;
use App\Models\element_structures;
use Illuminate\Http\Request;


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
            //$line = json_encode($modified_value, JSON_UNESCAPED_UNICODE) . PHP_EOL;
            //Storage::append('changes_log.txt', $line);
            $new_value = $modified_value['value'];
            $id = $modified_value['id'];
            App\Models\element_structures::UpdateElement($new_value, $id);
        }
    }

    if (isset($Changes['removed']) && is_array($Changes['removed'])) {
        foreach ($Changes['removed'] as $removed_value) {
            $id = $removed_value['id'];
            App\Models\element_structures::RemoveElement($id);
        }
    }





    return response()->json([
        'response' => 'OK',
        'changes' => $Changes
    ], 200); // Kod statusu 200 OK
});
