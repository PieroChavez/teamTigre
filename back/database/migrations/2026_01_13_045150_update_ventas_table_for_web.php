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
        Schema::table('ventas', function (Blueprint $table) {
            // Campos para el cliente que no es usuario registrado
            $table->string('cliente_nombre')->nullable()->after('id');
            $table->string('telefono')->nullable()->after('cliente_nombre');
            
            // El user_id ahora debe poder ser NULL (por si compra un invitado)
            $table->unsignedBigInteger('user_id')->nullable()->change();
            
            // Identificador para saber si la venta fue en el local o por la web
            if (!Schema::hasColumn('ventas', 'tipo_venta')) {
                $table->string('tipo_venta')->default('Presencial')->after('total');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            //
        });
    }
};
