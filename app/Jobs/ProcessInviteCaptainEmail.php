<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\InviteCaptain;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class ProcessInviteCaptainEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $user,$tournamentId,$teamId;
    /**
     * Create a new job instance.
     */
    public function __construct(User $user,$tournamentId,$teamId)
    {
        $this->user=$user;
        $this->tournamentId=$tournamentId;
        $this->teamId=$teamId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Notification::route('mail',$this->user->email)->notify(new InviteCaptain($this->user->invite_token,$this->tournamentId,$this->teamId));

    }
}
