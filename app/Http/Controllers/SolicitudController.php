<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Solicitud;

class SolicitudController extends Controller
{
    public function create()
    {
        return view('solicitudes.index');
    }
}
