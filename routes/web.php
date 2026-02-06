<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\FeriaController;
Route::get('/', function () {
    return view('welcome');
});


Route::get('registro', [SolicitudController::class, 'create'])
->name('solicitudes.create');

Route::get('/credencial/{token}', [FeriaController::class, 'show'])->name('feria.acceso');

