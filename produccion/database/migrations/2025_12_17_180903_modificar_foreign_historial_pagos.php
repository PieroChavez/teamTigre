<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('historial_pagos', function (Blueprint $table) {
            // Primero eliminamos la foreign key existente
            $table->dropForeign(['pago_id']);

            // Luego la volvemos a crear sin cascade
            $table->foreign('pago_id')->references('id')->on('pagos')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('historial_pagos', function (Blueprint $table) {
            $table->dropForeign(['pago_id']);
            $table->foreign('pago_id')->references('id')->on('pagos')->onDelete('cascade');
        });
    }
};
