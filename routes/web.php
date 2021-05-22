<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;




Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::resource('/notas', 'NotaController')->middleware('auth');

//Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
