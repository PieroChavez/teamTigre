<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historial_pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pago_id')->constrained('pagos')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->string('accion'); // creado, editado, anulado
            $table->text('detalle')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial_pagos');
    }
};
