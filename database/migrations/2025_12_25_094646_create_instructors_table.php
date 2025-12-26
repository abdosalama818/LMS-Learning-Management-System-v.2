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
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('status', ['active','inactive'])->default('active');
            $table->longText('bio')->nullable();
            $table->longText('address')->nullable();
            $table->integer('day')->nullable();
            $table->string('month')->nullable();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->integer('year')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->longText('experience')->nullable();
            $table->enum('gender', ['male', 'female'])->default('male');


            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructors');
    }
};
