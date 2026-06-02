<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Notificacoes') }}
            </h2>
            @if (auth()->user()->unreadNotifications()->count() > 0)
                <form method="POST" action="{{ route('notifications.mark-all-read') }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="text-sm font-semibold text-indigo-600 hover:text-indigo-900">
                        Marcar todas como lidas
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl space-y-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="rounded-md border border-green-300 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="rounded-md border border-red-300 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="rounded-md border border-red-300 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="space-y-5 p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-wide text-gray-500">Envio de e-mail real</p>
                            <h3 class="mt-1 text-lg font-semibold text-gray-900">
                                {{ $mailStatus['ready'] ? 'Configuracao SMTP preenchida' : 'SMTP pendente de configuracao' }}
                            </h3>
                            @if ($mailStatus['ready'])
                                <p class="mt-2 text-sm text-gray-500">
                                    Envie um teste para confirmar a autenticacao com o provedor. No Gmail, use senha de app em MAIL_PASSWORD.
                                </p>
                            @endif
                            <div class="mt-3 grid gap-2 text-sm text-gray-600 sm:grid-cols-2">
                                <p><span class="font-medium text-gray-700">Remetente:</span> {{ $mailStatus['from'] ?: 'nao configurado' }}</p>
                                <p><span class="font-medium text-gray-700">Servidor:</span> {{ $mailStatus['host'] ?: 'nao configurado' }}</p>
                                <p><span class="font-medium text-gray-700">Porta:</span> {{ $mailStatus['port'] ?: 'nao configurada' }}</p>
                                <p><span class="font-medium text-gray-700">Criptografia:</span> {{ $mailStatus['encryption'] ?: 'nao configurada' }}</p>
                                <p><span class="font-medium text-gray-700">Usuario SMTP:</span> {{ $mailStatus['username'] ?: 'nao configurado' }}</p>
                                <p><span class="font-medium text-gray-700">Senha SMTP:</span> {{ $mailStatus['password_set'] ? 'informada' : 'nao informada' }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium {{ $mailStatus['ready'] ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $mailStatus['ready'] ? 'Preenchido' : 'Incompleto' }}
                        </span>
                    </div>

                    @if (! $mailStatus['ready'])
                        <div class="rounded-md border border-yellow-300 bg-yellow-50 p-4 text-sm text-yellow-900">
                            <p class="font-semibold">Para o e-mail chegar na caixa da pessoa, corrija:</p>
                            <ul class="mt-2 list-disc space-y-1 ps-5">
                                @foreach ($mailStatus['issues'] as $issue)
                                    <li>{{ $issue }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('notifications.email-test') }}" class="flex flex-col gap-3 sm:flex-row">
                        @csrf
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', auth()->user()->email) }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="email@exemplo.com"
                            required
                        >
                        <button type="submit" class="inline-flex justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 disabled:cursor-not-allowed disabled:opacity-60" @disabled(! $mailStatus['ready'])>
                            Enviar teste real
                        </button>
                    </form>
                </div>
            </div>

            @forelse ($notifications as $notification)
                @php
                    $data = $notification->data;
                    $isUnread = $notification->read_at === null;
                    $tipo = $data['tipo'] ?? 'notificacao';
                    $badgeClasses = match ($tipo) {
                        'email_enviado' => 'bg-green-100 text-green-800',
                        'estoque_baixo' => 'bg-red-100 text-red-800',
                        'novo_pedido' => 'bg-indigo-100 text-indigo-800',
                        default => 'bg-gray-100 text-gray-700',
                    };
                @endphp
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg {{ $isUnread ? 'border-l-4 border-indigo-500' : '' }}">
                    <div class="flex flex-col gap-4 p-6 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $badgeClasses }}">
                                    {{ str_replace('_', ' ', $tipo) }}
                                </span>
                                <p class="text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            <h3 class="mt-2 text-lg font-semibold text-gray-900">
                                {{ $data['titulo'] ?? 'Notificacao' }}
                            </h3>
                            <p class="mt-2 text-gray-700">{{ $data['mensagem'] ?? '' }}</p>
                        </div>
                        @if ($isUnread)
                            <form method="POST" action="{{ route('notifications.mark-read', $notification->id) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="whitespace-nowrap text-sm font-semibold text-indigo-600 hover:text-indigo-900">
                                    Marcar como lida
                                </button>
                            </form>
                        @else
                            <span class="text-xs uppercase tracking-wide text-gray-400">Lida</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white p-8 text-center text-gray-500 shadow-sm sm:rounded-lg">
                    Nenhuma notificacao por enquanto.
                </div>
            @endforelse

            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
