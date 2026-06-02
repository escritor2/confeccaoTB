<?php

namespace App\Services;

use App\Models\User;
use App\Support\MailConfiguration;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification as NotificationFacade;

class NotificacaoService
{
    public static function enviarParaUsuarios(Notification $notification): void
    {
        User::query()->each(function (User $user) use ($notification) {
            try {
                $user->notify($notification);
            } catch (\Throwable $e) {
                Log::warning("Erro ao notificar usuario {$user->id}: ".$e->getMessage());
            }
        });

        $adminEmail = config('notificacoes.email_admin');

        if ($adminEmail && MailConfiguration::isReadyForRealDelivery()) {
            try {
                NotificationFacade::route('mail', $adminEmail)->notify($notification);
            } catch (\Throwable $e) {
                Log::warning('Erro ao notificar e-mail admin: '.$e->getMessage());
            }
        }
    }
}
