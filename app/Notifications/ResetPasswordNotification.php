<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue; // zedet hedhi 

class ResetPasswordNotification extends BaseResetPassword 
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Reset Password Request')
            ->greeting('Hello ' . $notifiable->first_name . ',')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', url(config('app.frontend_url') . '/reset-password?token=' . $this->token))
            ->line('If you did not request a password reset, no further action is required.');
    }
}
