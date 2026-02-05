<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolicitudController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('registro', [SolicitudController::class, 'create'])
->name('solicitudes.create');