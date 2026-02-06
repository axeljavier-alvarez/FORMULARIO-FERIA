<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud;

class FeriaController extends Controller
{
    public function show($token)
    {
        $solicitud = Solicitud::whereHas('accesos', function($q) use($token){
            $q->where('token', hash('sha256', $token));
        })->firstOrFail();

        return view('feria.bienvenida', compact('solicitud'));
    }
}
