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
        Schema::table('enrollments', function (Blueprint $table) {
            // Añadir la columna plan_id como llave foránea a la tabla 'plans'.
            // Es nullable() temporalmente para permitir que los registros existentes (que no tienen plan)
            // se mantengan sin que la migración falle.
            $table->foreignId('plan_id')
                  ->nullable() 
                  ->after('category_id') 
                  ->constrained()
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            // Eliminar la restricción foreign key primero
            $table->dropForeign(['plan_id']);
            // Eliminar la columna
            $table->dropColumn('plan_id');
        });
    }
};