<?php

namespace App\Notifications;

use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserSuspensionNotification extends Notification
{
    use Queueable;

    public $fromDate, $toDate, $violatedRule;

    /**
     * Create a new notification instance.
     */
    public function __construct($fromDate, $toDate, $violatedRule)
    {
        $this->fromDate = (new DateTime($fromDate))->format('F j, Y, g:i A');
        $this->toDate = (new DateTime($toDate))->format('F j, Y, g:i A');
        $this->violatedRule = $violatedRule;
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
            ->subject('Account Suspension Notification')
            ->line('Dear ' . $notifiable->first_name . ' ' . $notifiable->surname . ',')
            ->line('We regret to inform you that your account has been suspended from our application. For '. $this->violatedRule)
            ->line('From: ' . $this->fromDate)
            ->line('To: ' . $this->toDate)
            ->line('If you believe this suspension is in error or if you have any questions, please contact our support team.');
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
