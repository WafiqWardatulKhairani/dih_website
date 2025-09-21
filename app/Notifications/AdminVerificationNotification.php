<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;

class AdminVerificationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('User Baru Menunggu Verifikasi - ' . config('app.name'))
            ->greeting('Halo Admin!')
            ->line('Seorang user baru telah mendaftar dan menunggu verifikasi.')
            ->line('**Detail User:**')
            ->line('- Nama: ' . $this->user->name)
            ->line('- Email: ' . $this->user->email)
            ->line('- Institusi: ' . $this->user->institution_name)
            ->line('- Role: ' . $this->user->role)
            ->action('Verifikasi User', url('/admin/users'))
            ->line('Silakan login ke dashboard admin untuk melakukan verifikasi.')
            ->salutation('Terima kasih, ' . config('app.name'));
    }
}