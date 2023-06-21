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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('photo_path')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('slug');
            $table->string('email')->unique();
            $table->date('dob')->nullable();
            $table->string('state')->nullable();
            $table->unsignedInteger('fav_playing_spot')->nullable();
            $table->string('specialization')->nullable();
            $table->string('balling_hand')->nullable();
            $table->string('batting_hand')->nullable();
            $table->string('balling_type')->nullable();
            $table->unsignedInteger('jersey_number')->nullable();
            $table->timestamp('email_verified_at');
            $table->string('token')->unique();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
