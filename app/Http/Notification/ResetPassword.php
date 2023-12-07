<?php

declare(strict_types = 1);

namespace App\Http\Notification;

use App\Mail\ResetPasswordMail;
use Illuminate\Auth\Notifications\ResetPassword as BaseNotification;

class ResetPassword extends BaseNotification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param string $token
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param mixed $notifiable
     *
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return new ResetPasswordMail($this->resetUrl($notifiable), $notifiable);
    }

    /**
     * Get the reset URL for the given notifiable.
     *
     * @param mixed $notifiable
     *
     * @return string
     */
    protected function resetUrl($notifiable)
    {
        return url('/wachtwoord-vergeten', [
            'token' => $this->token,
            'email' => $notifiable->email,
        ], false);
    }
}
