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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('code')->unique();
            $table->string('offer_type');
            $table->float('price', 8, 5);
            $table->float('reward_price', 10, 5);
            $table->string('reward_type',1)->default('P');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('active')->default(true);
            $table->integer('qty')->default(0);
            $table->integer('qty_sold')->default(0);
            $table->string('image');
            $table->integer('sort_index')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
