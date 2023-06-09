<?php

namespace Database\Seeders;

use App\Models\TournamentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TournamentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tournament_types = ['season', 'tennis'];
        foreach($tournament_types as $tournament_type) {
            TournamentType::create([
                'name' => $tournament_type,
            ]);
        }
    }
}
