<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('template');
});

Route::view('/panel','panel.index')->name('panel');

Route::resource('presentaciones', App\Http\Controllers\PresentacioneController::class);
Route::resource('categorias', App\Http\Controllers\CategoriaController::class);
Route::resource('marcas', App\Http\Controllers\MarcaController::class);

Route::get('/login', function () {
    return view('auth.login');
});


Route::get('/401', function () {
    return view('pages.401');
});



Route::get('/404', function () {
    return view('pages.404');
});



Route::get('/500', function () {
    return view('pages.500');
});
