<?php

namespace App\Notifications;

use App\Support\MailConfiguration;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OperacaoSistemaNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $titulo,
        public string $mensagem,
        public string $url,
        public string $tipo = 'operacao'
    ) {}

    public function via(object $notifiable): array
    {
        $channels = ['database'];

        if (MailConfiguration::isReadyForRealDelivery()) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        $name = $notifiable->name ?? null;

        return (new MailMessage)
            ->subject($this->titulo.' - '.config('app.name'))
            ->greeting($name ? 'Ola, '.$name.'!' : 'Ola!')
            ->line($this->mensagem)
            ->action('Abrir no sistema', url($this->url));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'tipo' => $this->tipo,
            'titulo' => $this->titulo,
            'mensagem' => $this->mensagem,
            'url' => $this->url,
        ];
    }
}
