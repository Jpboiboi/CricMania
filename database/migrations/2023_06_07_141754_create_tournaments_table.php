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
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedBigInteger('organizer_id');
            $table->unsignedBigInteger('tournament_type_id');
            $table->integer('no_of_teams');
            $table->integer('max_players');
            $table->integer('no_of_overs');
            $table->timestamp('start_date');
            $table->timestamps();

            $table->foreign('organizer_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('tournament_type_id')
                ->references('id')
                ->on('tournament_types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
