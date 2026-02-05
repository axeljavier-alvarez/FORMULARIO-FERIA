<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Documento extends Model
{
    use HasFactory;
    protected $fillable = [
        'ruta',
        'solicitud_id'
        ];

    public function solicitud(){
        return $this->belongsTo(Solicitud::class);
    }

    
}
