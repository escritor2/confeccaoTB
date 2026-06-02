<x-guest-layout>
    <div class="mb-7">
        <p class="text-xs font-black uppercase tracking-[0.24em] text-rose-500">Acesso interno</p>
        <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950">Entrar no painel</h2>
        <p class="mt-2 text-sm leading-6 text-slate-500">Acompanhe pedidos, estoque baixo e notificacoes da confeccao.</p>
    </div>

    <x-auth-session-status class="mb-4 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="Email" class="text-xs font-black uppercase tracking-widest text-slate-600" />
            <x-text-input
                id="email"
                class="mt-2 block h-12 w-full rounded-md border-slate-200 bg-slate-50 px-4 text-slate-900 shadow-none transition focus:border-slate-900 focus:bg-white focus:ring-slate-900"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
                placeholder="voce@empresa.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex items-center justify-between gap-4">
                <x-input-label for="password" value="Senha" class="text-xs font-black uppercase tracking-widest text-slate-600" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-slate-500 underline-offset-4 hover:text-slate-950 hover:underline" href="{{ route('password.request') }}">
                        Esqueci minha senha
                    </a>
                @endif
            </div>

            <x-text-input
                id="password"
                class="mt-2 block h-12 w-full rounded-md border-slate-200 bg-slate-50 px-4 text-slate-900 shadow-none transition focus:border-slate-900 focus:bg-white focus:ring-slate-900"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Digite sua senha"
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="flex items-center gap-3 rounded-md border border-slate-200 bg-slate-50 px-4 py-3">
            <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-slate-950 shadow-sm focus:ring-slate-900" name="remember">
            <span class="text-sm font-medium text-slate-600">Manter sessao ativa neste dispositivo</span>
        </label>

        <button type="submit" class="inline-flex h-12 w-full items-center justify-center rounded-md bg-slate-950 px-5 text-sm font-black uppercase tracking-widest text-white transition hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-slate-950 focus:ring-offset-2">
            Entrar
        </button>
    </form>

    @if (Route::has('register'))
        <div class="mt-6 rounded-md border border-dashed border-slate-300 p-4 text-center">
            <p class="text-sm text-slate-600">
                Ainda nao tem acesso?
                <a href="{{ route('register') }}" class="font-black text-slate-950 underline-offset-4 hover:underline">Criar conta</a>
            </p>
        </div>
    @endif
</x-guest-layout>
