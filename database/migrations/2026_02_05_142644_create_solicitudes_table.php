<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->string('sobre_mi', 1000)->nullable();
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->string('email', 50);
            $table->string('telefono', 20);
            $table->string('dpi', 15);
            $table->char('sexo', 1);
            $table->date('fechanac');
            $table->foreignId('municipio_id')->constrained('municipios')->restrictOnDelete();
            $table->string('zona', 3)->nullable();
            $table->foreignId('estado_id')->constrained('estados')->restrictOnDelete();
            $table->string('ruta', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
