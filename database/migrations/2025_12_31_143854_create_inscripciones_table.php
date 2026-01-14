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
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('alumno_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('categoria_id')
                ->constrained()
                ->restrictOnDelete();

            $table->foreignId('plantilla_periodo_id')
                ->constrained('plantilla_periodos')
                ->restrictOnDelete();

            $table->foreignId('horario_id')
                ->constrained()
                ->restrictOnDelete();

            $table->date('fecha_inicio');
            $table->date('fecha_fin');

            $table->unsignedSmallInteger('semanas_reales')->nullable();

            $table->string('estado')->default('vigente'); 
            // vigente | suspendido | finalizado

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripciones');
    }
};
