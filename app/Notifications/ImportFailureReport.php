<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ImportFailureReport extends Notification
{
    use Queueable;

    private $path;
    /**
     * Create a new notification instance.
     */
    public function __construct($path)
    {
        $this->path = $path;
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
                    ->line('Your import was partially successful!')
                    ->line('Failure report is given below')
                    ->attach("D:\\Dipesh\\Study Link Projects\\cric-mania\\storage\\app\\public\\import-failures\\failure-report.xlsx")
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
