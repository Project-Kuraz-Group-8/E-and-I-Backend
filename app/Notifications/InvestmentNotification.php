<?php

namespace App\Notifications;

use App\Models\InvestmentInterest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvestmentNotification extends Notification
{
    use Queueable;
    protected $investor;
    protected $startup_id;
    protected $amount;

    /**
     * Create a new notification instance.
     */
    public function __construct($investor, $startup_id, $amount)
    {
        $this->investor = $investor;
        $this->startup_id = $startup_id;
        $this->amount = $amount;
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
                    ->line('An investor has shown interest in your project!')
                    ->line("Investor: $this->investor->user->name wants to invest $this->amount ETB.")
                    ->action('View Investment', url('/dashboard/notifications'))
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
            'investor' => $this->investor,
            'investor_id' => $this->investor->id,
            'investor_name' => $this->investor->user->name,
            'startup_id' => $this->startup_id,
            'amount' => $this->amount,
            'message' => $this->investor->user->name . ' wants to invest ' . $this->amount . ' ETB.'
        ];
        
      
    }
}
