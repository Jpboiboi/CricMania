<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InviteCaptain extends Notification
{
    use Queueable;
    private $token,$tournamentId,$teamId;
    /**
     * Create a new notification instance.
     */
    public function __construct($token,$tournamentId,$teamId)
    {
        $this->token=$token;
        $this->tournamentId=$tournamentId;
        $this->teamId=$teamId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('You are added as a captain by CricMania,please fill further details to register yourself and then you can add your team players.')
                    ->action('Click here to register', url("tournaments/$this->tournamentId/teams/$this->teamId/invite-captain?t=$this->token"))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
