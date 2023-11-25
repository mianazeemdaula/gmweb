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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('phone',20)->unique();
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('locale')->default('en');
            $table->string('timezone')->default('UTC');
            $table->string('image')->default('default.png');
            $table->string('tag',10)->unique();
            $table->string('status',10)->default('active');
            $table->string('role',10)->default('user');
            $table->string('nic',20)->nullable();
            $table->unsignedBigInteger('referral')->nullable();
            $table->unsignedBigInteger('level_id')->default(1);
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('referral')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
