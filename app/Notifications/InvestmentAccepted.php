<?php

namespace App\Notifications;

use App\Models\Startup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvestmentAccepted extends Notification
{
    use Queueable;
    public $entrepreneur;
    public $startup_id;
    public $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($entrepreneur, $startup_id, $message)
    {
        $this->entrepreneur = $entrepreneur;
        $this->startup_id = $startup_id;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $startup = Startup::where('id', '=', $this->startup_id)->first();
        return [
            'message' => "{$this->entrepreneur->name} has accepted your investment offer for startup title {$startup->title}.",
            'entrepreneur_id' => $this->entrepreneur->id,
            'startup_id' => $this->startup_id,
        ];
    }
}
