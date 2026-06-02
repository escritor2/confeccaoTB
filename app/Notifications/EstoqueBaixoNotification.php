<?php

namespace App\Notifications;

use App\Models\estoque;
use App\Support\MailConfiguration;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EstoqueBaixoNotification extends Notification
{
    use Queueable;

    public function __construct(
        public estoque $item
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
        $limite = $this->item->limiteMinimo();
        $name = $notifiable->name ?? null;

        return (new MailMessage)
            ->subject('Alerta: estoque baixo - '.$this->item->nome)
            ->greeting($name ? 'Ola, '.$name.'!' : 'Ola!')
            ->line('O item '.$this->item->nome.' esta com quantidade abaixo do minimo.')
            ->line('Quantidade atual: '.$this->item->quantidade.' (minimo: '.$limite.').')
            ->action('Ver estoque', route('estoque.index'))
            ->line('Reponha o estoque o quanto antes para evitar ruptura.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'tipo' => 'estoque_baixo',
            'titulo' => 'Estoque baixo',
            'mensagem' => sprintf(
                '%s: %d un. (minimo %d)',
                $this->item->nome,
                $this->item->quantidade,
                $this->item->limiteMinimo()
            ),
            'url' => route('estoque.index'),
            'estoque_id' => $this->item->id,
        ];
    }
}
