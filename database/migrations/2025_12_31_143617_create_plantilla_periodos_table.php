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
        Schema::create('plantilla_periodos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Ej: Mensual, Trimestral
            $table->unsignedTinyInteger('duracion_meses');
            $table->unsignedSmallInteger('duracion_semanas');
            $table->decimal('precio_base', 8, 2);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantilla_periodos');
    }
};
