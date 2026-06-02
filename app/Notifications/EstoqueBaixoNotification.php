<?php

namespace App\Notifications;

use App\Models\estoque;
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

        if (config('mail.default') !== 'smtp' || 
            (config('mail.mailers.smtp.username') && config('mail.mailers.smtp.password'))) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        $limite = $this->item->limiteMinimo();

        return (new MailMessage)
            ->subject('Alerta: estoque baixo — '.$this->item->nome)
            ->greeting('Olá, '.$notifiable->name.'!')
            ->line('O item **'.$this->item->nome.'** está com quantidade abaixo do mínimo.')
            ->line('Quantidade atual: **'.$this->item->quantidade.'** (mínimo: **'.$limite.'**).')
            ->action('Ver estoque', url(route('estoque.index')))
            ->line('Reponha o estoque o quanto antes para evitar ruptura.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'tipo' => 'estoque_baixo',
            'titulo' => 'Estoque baixo',
            'mensagem' => sprintf(
                '%s: %d un. (mínimo %d)',
                $this->item->nome,
                $this->item->quantidade,
                $this->item->limiteMinimo()
            ),
            'url' => route('estoque.index'),
            'estoque_id' => $this->item->id,
        ];
    }
}
