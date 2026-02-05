<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Solicitud extends Model
{
    use HasFactory;

    // cargar relaciones de 1
    protected $with = ['departamento', 'municipio', 'estado'];

    protected $fillable = [
        'sobre_mi',        
        'nombres',
        'apellidos',
        'email',
        'telefono',
        'dpi',
        'sexo',
        'fechanac',
        'departamento_id',
        'municipio_id',
        'zona',
        'estado_id',
        'hash',
    ];

    public function documentos(){
        return $this->hasMany(Documento::class);
    }

    
    public function departamento(){
        return $this->belongsTo(Departamento::class);
    }

    public function municipio(){
        return $this->belongsTo(Municipio::class);
    }

    public function estado(){
        return $this->belongsTo(Estado::class);
    }




}
