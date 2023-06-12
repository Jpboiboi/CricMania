<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\PlayerStat;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        $this->call([
            TournamentTypesSeeder::class
        ]);
        
        // \App\Models\Player::factory(10)->create();
        // \App\Models\PlayerStat::factory(10)->create();
        \App\Models\Player::factory(20)->create()->each(function($player){
                $player->playerstat()->create(
                    PlayerStat::factory()
                    ->make()
                    ->toArray()

                );
        });

    }
}
