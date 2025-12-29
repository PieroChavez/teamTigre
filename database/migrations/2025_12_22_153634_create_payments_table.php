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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('enrollment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained();

            $table->decimal('amount', 10, 2);
            $table->enum('method', ['cash', 'yape', 'transfer']);
            $table->enum('status', ['pending', 'paid', 'expired'])->default('pending');

            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
