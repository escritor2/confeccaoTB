<?php

namespace App\Notifications;

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

        if (config('mail.default') !== 'smtp' || 
            (config('mail.mailers.smtp.username') && config('mail.mailers.smtp.password'))) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->titulo.' — '.config('app.name'))
            ->greeting('Olá, '.$notifiable->name.'!')
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
