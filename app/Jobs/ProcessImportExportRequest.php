<?php

namespace App\Jobs;

use App\Notifications\ImportUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class ProcessImportExportRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $email,$password;
    /**
     * Create a new job instance.
     */
    public function __construct($email,$password)
    {
        $this->email=$email;
        $this->password=$password;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Notification::route('mail',$this->email)->notify(new ImportUser($this->email, $this->password));
    }
}
