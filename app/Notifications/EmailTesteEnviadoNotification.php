<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class EmailTesteEnviadoNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $destination
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'tipo' => 'email_enviado',
            'titulo' => 'E-mail de teste enviado',
            'mensagem' => 'O sistema enviou um e-mail real para '.$this->destination.'.',
            'url' => route('notifications.index'),
            'email' => $this->destination,
        ];
    }
}
