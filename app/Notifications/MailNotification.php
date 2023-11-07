<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MailNotification extends Notification
{
    use Queueable;

    public $email_text;
    public $email_button_text;
    public $email_button_link;

    /**
     * Create a new notification instance.
     */
    public function __construct($subject, $email_text, $email_button_text, $email_button_link)
    {
        $this->subject = $subject;
        $this->email_text = $email_text;
        $this->email_button_text = $email_button_text;
        $this->email_button_link = $email_button_link;

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
            ->greeting('Приветствую!')
            ->subject($this->subject)
            ->line(nl2br($this->email_text))
            ->action($this->email_button_text, url($this->email_button_link))
            ;
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
