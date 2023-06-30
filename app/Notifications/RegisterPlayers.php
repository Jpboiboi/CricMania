<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisterPlayers extends Notification
{
    use Queueable;
    private $teamId,$tournamentId;
    /**
     * Create a new notification instance.
     */
    public function __construct($teamId,$tournamentId)
    {
        $this->teamId=$teamId;
        $this->tournamentId=$tournamentId;
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
                    ->line('Your are added as captain by cricmania. Please add rest of the team players by clicking below!')
                    ->action('Notification Action', url("tournaments/$this->tournamentId/teams/$this->teamId/add-players"))
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
