<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends BaseVerifyEmail implements ShouldQueue
{
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Verify your email address')
            ->greeting('Hello ' . $notifiable->first_name . ',')
            ->line('Please click the button below to verify your email address.')
            ->action('Verify My Email', $this->verificationUrl($notifiable))
            ->line('If you did not create an account, no action is required.');
    }
}
