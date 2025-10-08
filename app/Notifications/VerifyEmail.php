<?php

namespace App\Notifications;

use Firebase\JWT\JWT;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail($notifiable)
    // {
    //     $payload = [
    //         'user_id' => $notifiable->id,
    //         'email' => $notifiable->email,
    //         'exp' => time() + (60 * 60)
    //     ];

    //     $token = JWT::encode($payload, config('app.jwt_secret'), 'HS256');

    //     $url = url("/verify-email/{$token}");

    //     return (new MailMessage)
    //         ->subject('Verify Email Address')
    //         ->line('Please click the button below to verify your email address.')
    //         ->action('Verify Email Address', $url)
    //         ->line('If you did not create an account, no further action is required.');
    // }

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
