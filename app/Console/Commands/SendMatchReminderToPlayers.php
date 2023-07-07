<?php

namespace App\Console\Commands;

use App\Models\Tournament;
use App\Models\TournamentMatch;
use App\Notifications\SendMatchReminder;
use Carbon\Carbon;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendMatchReminderToPlayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-mail-to-players';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a match reminder to players';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $teams = $tournament->tournament_teams;
        $matches = TournamentMatch::all();

        // $matchDate = Carbon::createFromFormat('Y-m-d H:i:s', $matches[0]->match_date)->format("Y-m-d");
        // $currentDate = Carbon::now()->addDays(6)->format('Y-m-d');
        // if($currentDate === $matchDate) {
        //     $team1Players = $matches[0]->team1->players[0]->user->email;

        //     Log::info($team1Players);
        // }

        foreach ($matches as $match) {
            $matchDate = Carbon::createFromFormat('Y-m-d H:i:s', $match->match_date)->format("Y-m-d");
            $currentDate = Carbon::now()->addDays(1)->format('Y-m-d');

            if($currentDate === $matchDate) {
                $team1Players = $match->team1->players;
                $team2Players = $match->team2->players;

                foreach ($team1Players as $player) {
                    $email = $player->user->email;
                    Notification::route('mail', $email)->notify(new SendMatchReminder());
                }

                foreach ($team2Players as $player) {
                    $email = $player->user->email;
                    Notification::route('mail', $email)->notify(new SendMatchReminder());
                }

                Log::info($team1Players);
            }
        }

    }
}
