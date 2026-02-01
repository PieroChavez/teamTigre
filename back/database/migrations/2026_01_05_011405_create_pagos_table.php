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
        Schema::create('pagos', function (Blueprint $table) {
        $table->id();

        $table->foreignId('cuota_pago_id')
            ->constrained('cuota_pagos')
            ->cascadeOnDelete();

        $table->decimal('monto', 8, 2);
        $table->string('metodo'); // efectivo | yape | plin
        $table->timestamp('fecha_pago')->useCurrent();

        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
