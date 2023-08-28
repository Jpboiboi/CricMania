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
        Schema::create('match_detail_scorecards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('match_scorecard_id');
            $table->unsignedBigInteger('bat_by');
            $table->unsignedBigInteger('ball_by');
            $table->unsignedInteger('over');
            $table->unsignedInteger('ball_number');
            $table->unsignedInteger('runs_by_bat')->default(0);
            $table->unsignedInteger('extra_runs')->default(0);
            $table->unsignedInteger('total_runs_scored')->default(0);
            $table->boolean('was_wide')->default(0);
            $table->boolean('was_no_ball')->default(0);
            $table->boolean('was_bye')->default(0);
            $table->boolean('was_leg_bye')->default(0);
            $table->boolean('was_dot')->default(0);
            $table->boolean('was_single')->default(0);
            $table->boolean('was_double')->default(0);
            $table->boolean('was_triple')->default(0);
            $table->boolean('was_four')->default(0);
            $table->boolean('was_five')->default(0);
            $table->boolean('was_six')->default(0);
            $table->boolean('was_free_hit')->default(0);
            $table->boolean('is_legal_delivery')->default(1);
            $table->unsignedInteger('wickets_taken')->nullable();
            $table->unsignedBigInteger('dismissed_batsman')->nullable();
            $table->string('wicket_type')->nullable();
            $table->unsignedBigInteger('out_by')->nullable();
            $table->unsignedBigInteger('caught_by')->nullable();
            $table->unsignedBigInteger('stumped_by')->nullable();
            $table->unsignedBigInteger('playing_team');
            $table->longText('commentary_message')->nullable();
            $table->timestamps();

            $table->foreign('bat_by')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');

            $table->foreign('ball_by')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');

            $table->foreign('dismissed_batsman')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');

            $table->foreign('out_by')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');

            $table->foreign('caught_by')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');

            $table->foreign('stumped_by')
                ->references('id')
                ->on('players')
                ->onDelete('cascade');

            $table->foreign('playing_team')
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
        Schema::dropIfExists('match_detail_scorecards');
    }
};
