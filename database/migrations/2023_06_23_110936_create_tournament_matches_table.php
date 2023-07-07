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
        Schema::create('tournament_matches', function (Blueprint $table) {
            $table->id();
            $table->timestamp('match_date');
            $table->unsignedInteger('no_of_overs');
            $table->timestamp('match_state')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('team1_id');
            $table->unsignedBigInteger('team2_id');
            $table->unsignedBigInteger('captain1_id')->nullable();
            $table->unsignedBigInteger('captain2_id')->nullable();
            $table->unsignedBigInteger('tournament_id');
            $table->unsignedBigInteger('toss')->nullable();
            $table->unsignedBigInteger('result')->nullable();

            $table->foreign('team1_id')
            ->references('id')
            ->on('teams')
            ->onDelete('cascade');

            $table->foreign('team2_id')
            ->references('id')
            ->on('teams')
            ->onDelete('cascade');

            $table->foreign('captain1_id')
            ->references('id')
            ->on('player_team')
            ->onDelete('cascade');

            $table->foreign('captain2_id')
            ->references('id')
            ->on('player_team')
            ->onDelete('cascade');

            $table->foreign('tournament_id')
            ->references('id')
            ->on('tournaments')
            ->onDelete('cascade');

            $table->foreign('toss')
            ->references('id')
            ->on('teams')
            ->onDelete('cascade');

            $table->foreign('result')
            ->references('id')
            ->on('teams')
            ->onDelete('cascade');
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_matches');
    }
};
