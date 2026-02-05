<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estado;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            'Pendiente',
            'Vinculado',
            'En proceso',
            'No aplica'
        ];

        foreach($estados as $nombre){
            Estado::firstOrCreate(['nombre' => $nombre]);
        }
    }
}
