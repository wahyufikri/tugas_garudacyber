<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Assignment;

class NewAssignmentNotification extends Notification
{
    use Queueable;

    protected $assignment;

    public function __construct(Assignment $assignment)
    {
        $this->assignment = $assignment;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Assignment Baru Ditambahkan')
            ->greeting('Halo ' . $notifiable->name)
            ->line('Assignment baru telah ditambahkan.')
            ->line('Judul: ' . $this->assignment->title)
            ->line('Deadline: ' . $this->assignment->deadline)
            ->action('Lihat Assignment', url('/'))
            ->line('Terima kasih.');
    }
}
