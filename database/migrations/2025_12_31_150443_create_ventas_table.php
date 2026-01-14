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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();

            // Opcional: vincular con alumno o cliente
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->decimal('total', 10, 2);
            $table->string('estado')->default('pendiente'); // pendiente | pagado | cancelado
            $table->string('medio_pago')->nullable(); // efectivo, Yape, Plin, transferencia
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
