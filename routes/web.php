<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\FeriaController;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('welcome');
});


Route::get('registro', [SolicitudController::class, 'create'])
->name('solicitudes.create');

Route::get('/credencial/{token}', [FeriaController::class, 'show'])->name('feria.acceso');


Route::get('/captcha', function () {

    $text = strtoupper(Str::random(5)); // texto captcha
    session(['captcha_text' => $text]);

    $width = 150;
    $height = 50;

    $image = imagecreate($width, $height);

    $bg = imagecolorallocate($image, 245, 245, 245);
    $textColor = imagecolorallocate($image, 60, 60, 60);
    $lineColor = imagecolorallocate($image, 180, 180, 180);

    // líneas de ruido
    for ($i = 0; $i < 5; $i++) {
        imageline($image, rand(0,$width), rand(0,$height), rand(0,$width), rand(0,$height), $lineColor);
    }

    imagestring($image, 5, 35, 15, $text, $textColor);

    ob_start();
    imagepng($image);
    $imageData = ob_get_clean();

    imagedestroy($image);

    return response($imageData)->header('Content-Type', 'image/png');
});
