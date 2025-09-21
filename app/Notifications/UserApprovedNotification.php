<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Akun Anda Telah Diverifikasi - ' . config('app.name'))
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line('Akun Anda telah diverifikasi oleh admin.')
            ->line('Anda sekarang dapat login ke aplikasi dan menggunakan semua fitur yang tersedia.')
            ->action('Login Sekarang', url('/login'))
            ->line('Jika Anda mengalami kesulitan login, silakan hubungi administrator.')
            ->salutation('Terima kasih telah bergabung dengan ' . config('app.name'));
    }
}