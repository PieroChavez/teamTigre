<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            // Asegúrate de usar 'tipos_pago' si ese es el nombre de tu tabla de tipos de pago
            $table->foreignId('tipo_pago_id')->after('cuota_pago_id')->constrained('tipos_pago');
        });
    }

    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            // Eliminar la clave foránea y la columna si haces rollback
            $table->dropForeign(['tipo_pago_id']);
            $table->dropColumn('tipo_pago_id');
        });
    }
};