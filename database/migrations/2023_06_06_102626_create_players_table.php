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
            $table->string('slug')->nullable();
            $table->date('dob')->nullable();
            $table->string('state')->nullable();
            $table->unsignedInteger('fav_playing_spot')->nullable();
            $table->string('specialization')->nullable();
            $table->string('balling_hand')->nullable();
            $table->string('batting_hand')->nullable();
            $table->string('balling_type')->nullable();
            $table->unsignedInteger('jersey_number')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
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
