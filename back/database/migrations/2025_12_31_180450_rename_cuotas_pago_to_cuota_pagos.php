<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('cuotas_pago', 'cuota_pagos');
    }

    public function down(): void
    {
        Schema::rename('cuota_pagos', 'cuotas_pago');
    }
};
