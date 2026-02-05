<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SolicitudAcceso extends Model
    {
            use HasFactory;
            protected $fillable = [
                'solicitud_id',
                'token',
                'expires_at',
                'last_used_at'
            ];

            protected $casts = [
                'expires_at' => 'datetime',
                'last_used_at' => 'datetime',
            ];

           // relacion con solicitud 
           public function solicitud()
           {
            return $this->belongsTo(Solicitud::class);
           }

    }
