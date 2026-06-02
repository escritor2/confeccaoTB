<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TS Confeccoes') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <main class="auth-weave min-h-screen bg-[#f7f3ee]">
            <div class="mx-auto grid min-h-screen w-full max-w-7xl grid-cols-1 lg:grid-cols-[0.95fr_1.05fr]">
                <section class="hidden min-h-screen flex-col justify-between overflow-hidden bg-slate-950 p-10 text-white lg:flex">
                    <div class="relative z-10">
                        <a href="/" class="inline-flex items-center gap-3">
                            <span class="grid h-12 w-12 place-items-center rounded-md bg-white text-lg font-black text-slate-950">TS</span>
                            <span>
                                <span class="block text-sm font-black uppercase tracking-[0.28em] text-amber-300">Confeccoes</span>
                                <span class="block text-sm text-slate-300">Gestao de atelier</span>
                            </span>
                        </a>
                    </div>

                    <div class="relative z-10 max-w-xl">
                        <p class="text-sm font-bold uppercase tracking-[0.3em] text-rose-300">Administracao sem ruido</p>
                        <h1 class="mt-4 text-5xl font-black leading-tight">
                            Um painel com cara de producao real, nao de template.
                        </h1>
                        <p class="mt-5 text-base leading-7 text-slate-300">
                            Clientes, pedidos, fornecedores e estoque em uma rotina mais visual para quem precisa decidir rapido.
                        </p>
                    </div>

                    <div class="relative z-10 grid grid-cols-3 gap-3">
                        <div class="rounded-md border border-white/10 bg-white/10 p-4">
                            <p class="text-2xl font-black">01</p>
                            <p class="mt-2 text-xs font-bold uppercase tracking-widest text-slate-300">Pedidos</p>
                        </div>
                        <div class="rounded-md border border-white/10 bg-white/10 p-4">
                            <p class="text-2xl font-black">02</p>
                            <p class="mt-2 text-xs font-bold uppercase tracking-widest text-slate-300">Estoque</p>
                        </div>
                        <div class="rounded-md border border-white/10 bg-white/10 p-4">
                            <p class="text-2xl font-black">03</p>
                            <p class="mt-2 text-xs font-bold uppercase tracking-widest text-slate-300">Alertas</p>
                        </div>
                    </div>
                </section>

                <section class="flex min-h-screen items-center justify-center px-4 py-8 sm:px-6 lg:px-10">
                    <div class="w-full max-w-md">
                        <div class="mb-8 flex items-center justify-between lg:hidden">
                            <a href="/" class="inline-flex items-center gap-3">
                                <span class="grid h-11 w-11 place-items-center rounded-md bg-slate-950 text-base font-black text-white">TS</span>
                                <span class="text-sm font-black uppercase tracking-[0.2em] text-slate-900">Confeccoes</span>
                            </a>
                        </div>

                        <div class="rounded-lg border border-slate-200 bg-white/95 p-6 shadow-xl shadow-slate-900/5 sm:p-8">
                            {{ $slot }}
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </body>
</html>
