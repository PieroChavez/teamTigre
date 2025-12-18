<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->string('estado')->default('activo')->after('concepto'); // nuevo campo estado
            $table->softDeletes()->after('estado'); // agrega deleted_at para SoftDeletes
        });
    }

    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->dropColumn('estado');
            $table->dropSoftDeletes();
        });
    }
};
