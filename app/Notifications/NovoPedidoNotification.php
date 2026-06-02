<?php

namespace App\Notifications;

use App\Models\Pedidos;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NovoPedidoNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Pedidos $pedido
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
            ->subject('Novo pedido cadastrado — '.$this->pedido->nome)
            ->greeting('Olá, '.$notifiable->name.'!')
            ->line('Um novo pedido foi registrado no sistema.')
            ->line('**Cliente:** '.$this->pedido->nome)
            ->line('**Telefone:** '.$this->pedido->telefone)
            ->when($this->pedido->endereco, fn (MailMessage $mail) => $mail->line('**Endereço:** '.$this->pedido->endereco))
            ->action('Ver pedidos', url(route('pedidos.index')))
            ->line('Acesse o painel para acompanhar os detalhes.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'tipo' => 'novo_pedido',
            'titulo' => 'Novo pedido',
            'mensagem' => $this->pedido->nome.' — '.$this->pedido->telefone,
            'url' => route('pedidos.index'),
            'pedido_id' => $this->pedido->id,
        ];
    }
}
