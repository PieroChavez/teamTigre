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
        Schema::table('coach_profiles', function (Blueprint $table) {
            // Agrega la nueva columna 'birth_date' como tipo date, y permítele ser nula temporalmente
            $table->date('birth_date')->nullable()->after('phone'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coach_profiles', function (Blueprint $table) {
            // Define cómo revertir el cambio
            $table->dropColumn('birth_date');
        });
    }
};