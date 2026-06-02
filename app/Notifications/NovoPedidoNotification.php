<?php

namespace App\Notifications;

use App\Models\Pedidos;
use App\Support\MailConfiguration;
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

        if (MailConfiguration::isReadyForRealDelivery()) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        $name = $notifiable->name ?? null;

        return (new MailMessage)
            ->subject('Novo pedido cadastrado - '.$this->pedido->nome)
            ->greeting($name ? 'Ola, '.$name.'!' : 'Ola!')
            ->line('Um novo pedido foi registrado no sistema.')
            ->line('Cliente: '.$this->pedido->nome)
            ->line('Telefone: '.$this->pedido->telefone)
            ->when($this->pedido->endereco, fn (MailMessage $mail) => $mail->line('Endereco: '.$this->pedido->endereco))
            ->action('Ver pedidos', route('pedidos.index'))
            ->line('Acesse o painel para acompanhar os detalhes.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'tipo' => 'novo_pedido',
            'titulo' => 'Novo pedido',
            'mensagem' => $this->pedido->nome.' - '.$this->pedido->telefone,
            'url' => route('pedidos.index'),
            'pedido_id' => $this->pedido->id,
        ];
    }
}
