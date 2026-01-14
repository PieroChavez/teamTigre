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
        Schema::create('cuentas_inscripcion', function (Blueprint $table) {
            $table->id();

            // Clave foránea a la inscripción a la que pertenece esta cuenta/cuota.
            $table->foreignId('inscripcion_id')
                ->constrained('inscripciones')
                ->cascadeOnDelete();

            // Clave foránea al concepto de pago (Mensualidad, Inscripción, etc.)
            $table->foreignId('concepto_pago_id')
                ->constrained('conceptos_pago') // <-- CORREGIDO: Especificando la tabla
                ->restrictOnDelete();

            $table->decimal('monto_total', 8, 2);
            $table->decimal('descuento', 8, 2)->default(0);
            $table->decimal('monto_final', 8, 2);

            $table->string('estado')->default('pendiente');
            // pendiente | pagado | vencido

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuentas_inscripcion');
    }
};