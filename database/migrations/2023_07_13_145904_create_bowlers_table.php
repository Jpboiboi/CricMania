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
        Schema::create('bowlers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_match_id');
            $table->unsignedBigInteger('player_id');
            $table->decimal('no_of_overs_played', 4, 1, true)->default(0);
            $table->unsignedInteger('no_of_balls_bowled')->default(0);
            $table->unsignedInteger('no_of_maiden_overs')->default(0);
            $table->unsignedInteger('runs_conceeded')->default(0);
            $table->unsignedInteger('no_of_wides')->default(0);
            $table->unsignedInteger('no_of_no_balls')->default(0);
            $table->unsignedInteger('no_of_byes')->default(0);
            $table->unsignedInteger('no_of_leg_byes')->default(0);
            $table->unsignedInteger('no_of_wickets_taken')->default(0);
            $table->unsignedInteger('no_of_lbws')->default(0);
            $table->unsignedInteger('no_of_catch_outs')->default(0);
            $table->unsignedInteger('no_of_run_outs')->default(0);
            $table->unsignedInteger('no_of_bowleds')->default(0);
            $table->unsignedInteger('no_of_hit_wickets')->default(0);
            $table->unsignedInteger('no_of_stumpings')->default(0);
            $table->unsignedInteger('no_of_hattricks')->default(0);
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
        Schema::dropIfExists('bowlers');
    }
};
