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
        Schema::create('cuotas_pago', function (Blueprint $table) {
            $table->id();

            // CLAVE CORREGIDA: Apunta explícitamente a la tabla 'cuentas_inscripcion'
            $table->foreignId('cuenta_inscripcion_id')
                ->constrained('cuentas_inscripcion') // ✅ CORRECCIÓN APLICADA
                ->cascadeOnDelete();

            // Aseguramos que apunte a la tabla 'tipos_pago' para claridad
            $table->foreignId('tipo_pago_id')
                ->constrained('tipos_pago')
                ->restrictOnDelete();

            $table->decimal('monto', 8, 2);

            $table->date('fecha_programada')->nullable();
            $table->date('fecha_pago')->nullable();

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
        Schema::dropIfExists('cuotas_pago');
    }
};