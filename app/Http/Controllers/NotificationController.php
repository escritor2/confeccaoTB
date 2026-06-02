<?php

namespace App\Http\Controllers;

use App\Notifications\EmailTesteEnviadoNotification;
use App\Support\MailConfiguration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $notifications = $request->user()
            ->notifications()
            ->paginate(20);
        $mailStatus = MailConfiguration::status();

        return view('notifications.index', compact('notifications', 'mailStatus'));
    }

    public function markAsRead(Request $request, string $id): RedirectResponse
    {
        $notification = $request->user()->notifications()->where('id', $id)->firstOrFail();
        $notification->markAsRead();

        $url = $notification->data['url'] ?? route('notifications.index');

        return redirect($url);
    }

    public function markAllAsRead(Request $request): RedirectResponse
    {
        $request->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Todas as notificacoes foram marcadas como lidas.');
    }

    public function sendTestEmail(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['nullable', 'email'],
        ]);

        $status = MailConfiguration::status();

        if (! $status['ready']) {
            return back()
                ->withInput()
                ->with('error', 'O e-mail real ainda nao esta pronto: '.implode(' ', $status['issues']));
        }

        $destination = $data['email'] ?: $request->user()->email;

        try {
            Mail::raw(
                'Este e-mail confirma que o envio SMTP do sistema '.config('app.name').' esta funcionando.',
                fn ($message) => $message
                    ->to($destination)
                    ->subject('Teste de e-mail - '.config('app.name'))
            );

            $request->user()->notify(new EmailTesteEnviadoNotification($destination));
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', MailConfiguration::describeFailure($e));
        }

        return back()->with('success', 'E-mail real enviado para '.$destination.'. Confira a caixa de entrada e a notificacao registrada abaixo.');
    }
}
