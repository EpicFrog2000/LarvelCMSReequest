<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminLoginController;

Route::get('/', function () {
    return view('home');
})->name('home');


Route::get('/admin/login', [adminLoginController::class, 'showForm'])->name('adminlogin.form');

Route::post('/admin/login', [adminLoginController::class, 'submitForm'])->name('adminlogin.submit');