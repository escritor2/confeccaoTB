<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as NotificationFacade;

class NotificacaoService
{
    public static function enviarParaUsuarios(Notification $notification): void
    {
        User::query()->each(fn (User $user) => $user->notify($notification));

        $adminEmail = config('notificacoes.email_admin');
        if ($adminEmail) {
            NotificationFacade::route('mail', $adminEmail)->notify($notification);
        }
    }
}
