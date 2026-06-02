<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as NotificationFacade;

class NotificacaoService
{
    public static function enviarParaUsuarios(Notification $notification): void
    {
        User::query()->each(function (User $user) use ($notification) {
            try {
                $user->notify($notification);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning("Erro ao notificar usuário {$user->id}: " . $e->getMessage());
            }
        });

        $adminEmail = config('notificacoes.email_admin');
        if ($adminEmail) {
            try {
                NotificationFacade::route('mail', $adminEmail)->notify($notification);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning("Erro ao notificar e-mail admin: " . $e->getMessage());
            }
        }
    }
}
