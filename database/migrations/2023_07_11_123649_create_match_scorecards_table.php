<?php

use App\Models\MatchScorecard;
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
        Schema::create('match_scorecards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_match_id');
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('strike_batsman_id');
            $table->unsignedBigInteger('non_strike_batsman_id');
            $table->unsignedBigInteger('bowler_id');
            $table->unsignedInteger('ball_number')->default(0);
            $table->unsignedInteger('over')->default(0);
            $table->unsignedInteger('runs_by_bat')->default(0);
            $table->unsignedInteger('extra_runs')->default(0);
            $table->unsignedInteger('total_runs_scored')->default(0);
            $table->unsignedInteger('wickets_taken')->default(0);
            $table->enum('inning', MatchScorecard::INNINGS);
            $table->timestamp('is_completed')->nullable();
            $table->timestamps();

            $table->foreign('tournament_match_id')
                ->references('id')
                ->on('tournament_matches')
                ->onDelete('cascade');

            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('cascade');

            $table->foreign('strike_batsman_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');

            $table->foreign('non_strike_batsman_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');

            $table->foreign('bowler_id')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');

            $table->unique(['tournament_match_id', 'team_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_scorecards');
    }
};
