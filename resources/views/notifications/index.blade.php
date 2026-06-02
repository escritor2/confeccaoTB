<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Notificações') }}
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
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @forelse ($notifications as $notification)
                @php
                    $data = $notification->data;
                    $isUnread = $notification->read_at === null;
                @endphp
                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden {{ $isUnread ? 'border-l-4 border-indigo-500' : '' }}">
                    <div class="p-6 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div>
                            <p class="text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                            <h3 class="text-lg font-semibold text-gray-900 mt-1">
                                {{ $data['titulo'] ?? 'Notificação' }}
                            </h3>
                            <p class="text-gray-700 mt-2">{{ $data['mensagem'] ?? '' }}</p>
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
                            <span class="text-xs text-gray-400 uppercase tracking-wide">Lida</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white p-8 shadow-sm sm:rounded-lg text-center text-gray-500">
                    Nenhuma notificação por enquanto.
                </div>
            @endforelse

            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
