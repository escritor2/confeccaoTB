<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-rose-500">Central administrativa</p>
                <h2 class="text-2xl font-black text-slate-900">Painel TS Confeccoes</h2>
            </div>
            <p class="text-sm font-medium text-slate-500">Visao rapida da operacao de hoje</p>
        </div>
    </x-slot>

    @php
        $unreadNotifications = $counts['notificacoes_nao_lidas'] ?? 0;
        $lowStock = $counts['estoque_baixo'] ?? 0;
        $totalCatalog = ($counts['produto'] ?? 0) + ($counts['estoque'] ?? 0);
        $attentionScore = $unreadNotifications + $lowStock;

        $metrics = [
            [
                'title' => 'Clientes',
                'value' => $counts['clientes'] ?? 0,
                'description' => 'Base de contatos para pedidos e entregas.',
                'href' => route('clientes.index'),
                'create' => route('clientes.create'),
                'action' => 'Novo cliente',
                'accent' => 'bg-rose-500',
                'soft' => 'bg-rose-50 text-rose-700 ring-rose-100',
                'icon' => 'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z',
            ],
            [
                'title' => 'Pedidos',
                'value' => $counts['pedidos'] ?? 0,
                'description' => 'Fluxo comercial registrado no sistema.',
                'href' => route('pedidos.index'),
                'create' => route('pedidos.create'),
                'action' => 'Novo pedido',
                'accent' => 'bg-emerald-500',
                'soft' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
                'icon' => 'M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V14.25m-17.25 0h11.25m-11.25 0V6.375c0-.621.504-1.125 1.125-1.125h8.25c.621 0 1.125.504 1.125 1.125v7.875m0 0h1.5l2.25-3.75h3.375c.621 0 1.125.504 1.125 1.125v2.625',
            ],
            [
                'title' => 'Estoque',
                'value' => $counts['estoque'] ?? 0,
                'description' => 'Itens acompanhados por quantidade minima.',
                'href' => route('estoque.index'),
                'create' => route('estoque.create'),
                'action' => 'Novo item',
                'accent' => 'bg-amber-500',
                'soft' => 'bg-amber-50 text-amber-700 ring-amber-100',
                'icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z',
            ],
            [
                'title' => 'Produtos',
                'value' => $counts['produto'] ?? 0,
                'description' => 'Catalogo de pecas e modelos disponiveis.',
                'href' => route('produtos.index'),
                'create' => route('produtos.create'),
                'action' => 'Novo produto',
                'accent' => 'bg-sky-500',
                'soft' => 'bg-sky-50 text-sky-700 ring-sky-100',
                'icon' => 'M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L12 6.75l5.571 3m0 0L21.75 12l-4.179 2.25m0-4.5v4.5m0 0L12 17.25l-5.571-3m11.142 0v4.5L12 21.75l-5.571-3v-4.5',
            ],
            [
                'title' => 'Fornecedores',
                'value' => $counts['fornecedores'] ?? 0,
                'description' => 'Parceiros para reposicao e producao.',
                'href' => route('fornecedores.index'),
                'create' => route('fornecedores.create'),
                'action' => 'Novo fornecedor',
                'accent' => 'bg-violet-500',
                'soft' => 'bg-violet-50 text-violet-700 ring-violet-100',
                'icon' => 'M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m15.75 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V6.75a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6.75v7.5m12.75-3h3.75l2.25 3.75',
            ],
        ];

        $quickActions = [
            ['label' => 'Registrar pedido', 'href' => route('pedidos.create'), 'tone' => 'bg-slate-950 text-white hover:bg-slate-800'],
            ['label' => 'Atualizar estoque', 'href' => route('estoque.index'), 'tone' => 'bg-white text-slate-800 ring-1 ring-slate-200 hover:bg-slate-50'],
            ['label' => 'Ver notificacoes', 'href' => route('notifications.index'), 'tone' => 'bg-white text-slate-800 ring-1 ring-slate-200 hover:bg-slate-50'],
        ];
    @endphp

    <div class="min-h-[calc(100vh-9rem)] bg-[#f7f3ee]">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <section class="overflow-hidden rounded-lg bg-slate-950 text-white shadow-sm">
                <div class="relative grid gap-8 p-6 sm:p-8 lg:grid-cols-[1.35fr_0.65fr] lg:p-10">
                    <div class="absolute inset-0 opacity-20 [background-image:linear-gradient(90deg,rgba(255,255,255,.12)_1px,transparent_1px),linear-gradient(rgba(255,255,255,.12)_1px,transparent_1px)] [background-size:28px_28px]"></div>
                    <div class="relative">
                        <p class="text-sm font-bold uppercase tracking-[0.28em] text-amber-300">Atelier em movimento</p>
                        <h1 class="mt-3 max-w-3xl text-3xl font-black leading-tight sm:text-4xl">
                            Controle clientes, pedidos e estoque com uma leitura mais clara da operacao.
                        </h1>
                        <p class="mt-4 max-w-2xl text-sm leading-6 text-slate-300 sm:text-base">
                            Os numeros principais ficam juntos, alertas sobem para o topo e as acoes mais usadas ficam a um clique.
                        </p>
                        <div class="mt-6 flex flex-wrap gap-3">
                            @foreach ($quickActions as $action)
                                <a href="{{ $action['href'] }}" class="inline-flex min-h-11 items-center rounded-md px-4 text-sm font-bold transition {{ $action['tone'] }}">
                                    {{ $action['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="relative grid grid-cols-2 gap-3">
                        <div class="rounded-md border border-white/10 bg-white/10 p-4 backdrop-blur">
                            <p class="text-xs font-bold uppercase tracking-widest text-slate-300">Catalogo</p>
                            <p class="mt-2 text-3xl font-black">{{ $totalCatalog }}</p>
                            <p class="mt-1 text-xs text-slate-300">produtos + itens</p>
                        </div>
                        <div class="rounded-md border border-white/10 bg-white/10 p-4 backdrop-blur">
                            <p class="text-xs font-bold uppercase tracking-widest text-slate-300">Atencao</p>
                            <p class="mt-2 text-3xl font-black {{ $attentionScore > 0 ? 'text-amber-300' : '' }}">{{ $attentionScore }}</p>
                            <p class="mt-1 text-xs text-slate-300">pendencias abertas</p>
                        </div>
                        <div class="col-span-2 rounded-md border border-white/10 bg-white/10 p-4 backdrop-blur">
                            <p class="text-xs font-bold uppercase tracking-widest text-slate-300">Resumo</p>
                            <div class="mt-3 flex items-end justify-between gap-3">
                                <div>
                                    <p class="text-3xl font-black">{{ $counts['pedidos'] ?? 0 }}</p>
                                    <p class="text-xs text-slate-300">pedidos cadastrados</p>
                                </div>
                                <div class="h-14 w-24 rounded bg-[repeating-linear-gradient(90deg,#f59e0b_0_8px,#ffffff_8px_10px,#10b981_10px_18px,#ffffff_18px_20px,#38bdf8_20px_28px)] opacity-90"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            @if ($unreadNotifications > 0 || $lowStock > 0)
                <section class="mt-6 grid gap-3 lg:grid-cols-2">
                    @if ($unreadNotifications > 0)
                        <a href="{{ route('notifications.index') }}" class="group flex items-center justify-between gap-4 rounded-lg border border-sky-200 bg-sky-50 p-4 text-sky-950 shadow-sm transition hover:border-sky-300 hover:bg-sky-100">
                            <div>
                                <p class="text-sm font-black">{{ $unreadNotifications }} notificacao(oes) nao lida(s)</p>
                                <p class="mt-1 text-sm text-sky-700">Confira eventos recentes do sistema.</p>
                            </div>
                            <span class="text-sm font-black group-hover:translate-x-1 transition">Abrir</span>
                        </a>
                    @endif

                    @if ($lowStock > 0)
                        <a href="{{ route('estoque.index') }}" class="group flex items-center justify-between gap-4 rounded-lg border border-amber-200 bg-amber-50 p-4 text-amber-950 shadow-sm transition hover:border-amber-300 hover:bg-amber-100">
                            <div>
                                <p class="text-sm font-black">{{ $lowStock }} item(ns) abaixo do minimo</p>
                                <p class="mt-1 text-sm text-amber-800">Priorize reposicao antes de novos pedidos.</p>
                            </div>
                            <span class="text-sm font-black group-hover:translate-x-1 transition">Abrir</span>
                        </a>
                    @endif
                </section>
            @endif

            <section class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">
                @foreach ($metrics as $metric)
                    <article class="group overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="h-1.5 {{ $metric['accent'] }}"></div>
                        <div class="p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-black text-slate-900">{{ $metric['title'] }}</p>
                                    <p class="mt-1 min-h-10 text-xs leading-5 text-slate-500">{{ $metric['description'] }}</p>
                                </div>
                                <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-md ring-1 {{ $metric['soft'] }}">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $metric['icon'] }}" />
                                    </svg>
                                </span>
                            </div>
                            <p class="mt-5 text-4xl font-black tracking-tight text-slate-950">{{ $metric['value'] }}</p>
                            <div class="mt-5 flex items-center justify-between gap-3 border-t border-slate-100 pt-4">
                                <a href="{{ $metric['href'] }}" class="text-sm font-bold text-slate-700 hover:text-slate-950">Ver lista</a>
                                <a href="{{ $metric['create'] }}" class="rounded-md bg-slate-100 px-3 py-2 text-xs font-black text-slate-800 transition hover:bg-slate-900 hover:text-white">
                                    {{ $metric['action'] }}
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </section>
        </div>
    </div>
</x-app-layout>
