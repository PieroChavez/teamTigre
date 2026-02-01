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
        // Añade la columna category_id a la tabla 'plans'
        Schema::table('plans', function (Blueprint $table) {
            // foreignId() crea la columna category_id de tipo UNSIGNED BIGINT.
            // constrained() asume la tabla 'categories' y establece la restricción FK.
            // nullable() es importante para evitar errores si ya tienes planes sin categoría asignada.
            $table->foreignId('category_id')->nullable()->constrained()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Esto revierte los cambios si ejecutas 'php artisan migrate:rollback'
        Schema::table('plans', function (Blueprint $table) {
            // 1. Eliminar la restricción de clave foránea
            $table->dropForeign(['category_id']);
            // 2. Eliminar la columna
            $table->dropColumn('category_id');
        });
    }
};