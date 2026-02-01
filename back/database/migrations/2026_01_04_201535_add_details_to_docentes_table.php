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
        Schema::table('docentes', function (Blueprint $table) {
            // Añadir las columnas que faltaban
            $table->string('dni', 20)->unique()->after('user_id'); // dni es requerido y debe ser único
            $table->string('telefono', 20)->nullable()->after('dni');
            $table->string('estado', 20)->default('activo')->after('experiencia'); // Añadir el estado (activo/inactivo)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('docentes', function (Blueprint $table) {
            // Eliminar las columnas en caso de rollback
            $table->dropColumn(['dni', 'telefono', 'estado']);
        });
    }
};