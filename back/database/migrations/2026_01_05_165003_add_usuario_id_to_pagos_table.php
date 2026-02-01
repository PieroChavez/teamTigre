<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            // Se define como una clave foránea que referencia a la tabla 'users'
            // El campo 'usuario_id' representa al cajero o usuario que registró el pago.
            $table->foreignId('usuario_id')
                  ->nullable() // Podría ser nullable si se registra automáticamente por el sistema
                  ->after('referencia')
                  ->constrained('users'); // Asume que la tabla de usuarios se llama 'users'
        });
    }

    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('usuario_id');
        });
    }
};