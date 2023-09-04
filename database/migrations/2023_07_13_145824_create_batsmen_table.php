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
        Schema::create('batsmen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_match_id');
            $table->unsignedBigInteger('player_id');
            $table->unsignedInteger('no_of_balls_faced')->default(0);
            $table->unsignedInteger('runs_scored')->default(0);
            $table->unsignedInteger('no_of_singles')->default(0);
            $table->unsignedInteger('no_of_doubles')->default(0);
            $table->unsignedInteger('no_of_triples')->default(0);
            $table->unsignedInteger('no_of_fours')->default(0);
            $table->unsignedInteger('no_of_fives')->default(0);
            $table->unsignedInteger('no_of_sixes')->default(0);
            $table->unsignedInteger('no_of_dots')->default(0);
            $table->string('how_out')->nullable();
            $table->unsignedBigInteger('out_by')->nullable();
            $table->boolean('has_scored_fifty')->default(0);
            $table->boolean('has_scored_hundred')->default(0);
            $table->timestamps();

            $table->foreign('tournament_match_id')
                ->references('id')
                ->on('tournament_matches')
                ->onDelete('cascade');

            $table->foreign('player_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');

            $table->unique(['tournament_match_id', 'player_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batsmen');
    }
};
