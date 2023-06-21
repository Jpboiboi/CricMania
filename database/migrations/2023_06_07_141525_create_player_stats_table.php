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
        Schema::create('player_stats', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->integer('no_of_runs_scored')->default(0);
            $table->integer('no_of_matches')->default(0);
            $table->integer('no_of_innings')->default(0);
            $table->integer('no_of_balls_faced')->default(0);
            $table->integer('no_of_singles')->default(0);
            $table->integer('no_of_doubles')->default(0);
            $table->integer('no_of_triples')->default(0);
            $table->integer('no_of_sixes')->default(0);
            $table->integer('no_of_fours')->default(0);
            $table->integer('no_of_fifties')->default(0);
            $table->integer('no_of_hundreds')->default(0);
            $table->integer('no_of_lbw')->default(0);
            $table->integer('no_of_stumpings')->default(0);
            $table->integer('no_of_catch_outs')->default(0);
            $table->integer('no_of_run_outs')->default(0);
            $table->integer('no_of_bowled')->default(0);
            $table->integer('no_of_wickets_taken')->default(0);
            $table->integer('no_of_balls_bowled')->default(0);
            $table->integer('no_of_runs_conceeded')->default(0);
            $table->integer('hattricks')->default(0);
            $table->integer('wides')->default(0);
            $table->integer('no_balls')->default(0);
            $table->integer('no_of_maidens')->default(0);
            $table->integer('four_wicket_hauls')->default(0);
            $table->integer('five_wicket_hauls')->default(0);
            $table->integer('no_of_catches')->default(0) ;
            $table->timestamps();

            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('tournament_type_id')->nullable();

            $table->foreign('player_id')
                  ->references('id')
                  ->on('players')
                  ->onDelete('cascade');

             $table->foreign('tournament_type_id')
                    ->references('id')
                    ->on('tournament_types')
                    ->onDelete('cascade');
            $table->unique(['id','tournament_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_stats');
    }
};
