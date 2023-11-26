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
        Schema::create('withdrawls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_method_id')->constrained()->onDelete('cascade');
            $table->string('account',64);
            $table->float('amount', 12, 5)->unsigned();
            $table->string('status')->default('pending');
            $table->string('tx_id')->nullable();
            $table->string('tx_link')->nullable();
            $table->string('description')->nullable();
            $table->string('coin')->default('usdttrc20');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawls');
    }
};
