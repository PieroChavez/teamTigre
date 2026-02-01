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
        Schema::create('boletos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->constrained('eventos')->cascadeOnDelete();

            // Opcional vincular a usuario/alumno
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->integer('cantidad')->default(1);
            $table->decimal('precio_unitario', 8, 2);
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
        Schema::dropIfExists('boletos');
    }
};
