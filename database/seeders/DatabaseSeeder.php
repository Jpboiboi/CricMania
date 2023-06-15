<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Tournament;
use App\Models\PlayerStat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'name' => 'Harsh',
            'email' => 'harsh@gmail.com',
            'password' => Hash::make('abcd1234'),
            // 'role' => 'admin',
        ]);
            //     'name' => 'Test User',
            //     'email' => 'test@example.com',
            // ]);

        $this->call([
            TournamentTypesSeeder::class
        ]);
        Tournament::factory()->create();


        // \App\Models\Player::factory(10)->create();
        // \App\Models\PlayerStat::factory(10)->create();
        \App\Models\Player::factory(20)->create()->each(function($player){
                $player->playerstats()->create(
                    PlayerStat::factory()
                    ->make()
                    ->toArray()

                );
        });

    }
}
