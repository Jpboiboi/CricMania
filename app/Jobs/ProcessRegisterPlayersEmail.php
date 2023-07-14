<?php

namespace App\Jobs;

use App\Notifications\RegisterPlayers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class ProcessRegisterPlayersEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $teamId,$tournamentId,$token,$captainsEmail;
    /**
     * Create a new job instance.
     */
    public function __construct($teamId,$tournamentId,$token,$captainsEmail)
    {
        $this->teamId=$teamId;
        $this->tournamentId=$tournamentId;
        $this->token=$token;
        $this->captainsEmail=$captainsEmail;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Notification::route('mail',$this->captainsEmail)->notify(new RegisterPlayers($this->teamId,$this->tournamentId,$this->token));
    }
}
