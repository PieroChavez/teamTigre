<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumnos', function (Blueprint $table) {
            // Añade la columna 'status' con un valor por defecto
            $table->string('status')->default('activo')->after('foto');
        });
    }

    public function down(): void
    {
        Schema::table('alumnos', function (Blueprint $table) {
            // Elimina la columna 'status' si hacemos rollback
            $table->dropColumn('status');
        });
    }
};