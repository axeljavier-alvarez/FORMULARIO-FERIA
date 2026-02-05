<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estado extends Model
{
    use HasFactory; 
            public $timestamps = false;
    protected $fillable = ['nombre'];


    public function solicitudes(){
            return $this->hasMany(Solicitud::class);
        }

    
}
