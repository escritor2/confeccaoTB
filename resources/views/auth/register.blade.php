<x-guest-layout>
    <div class="mb-7">
        <p class="text-xs font-black uppercase tracking-[0.24em] text-rose-500">Novo operador</p>
        <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950">Criar acesso</h2>
        <p class="mt-2 text-sm leading-6 text-slate-500">Cadastre um usuario para administrar clientes, pedidos e estoque.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" value="Nome" class="text-xs font-black uppercase tracking-widest text-slate-600" />
            <x-text-input
                id="name"
                class="mt-2 block h-12 w-full rounded-md border-slate-200 bg-slate-50 px-4 text-slate-900 shadow-none transition focus:border-slate-900 focus:bg-white focus:ring-slate-900"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
                placeholder="Nome do usuario"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="Email" class="text-xs font-black uppercase tracking-widest text-slate-600" />
            <x-text-input
                id="email"
                class="mt-2 block h-12 w-full rounded-md border-slate-200 bg-slate-50 px-4 text-slate-900 shadow-none transition focus:border-slate-900 focus:bg-white focus:ring-slate-900"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
                placeholder="voce@empresa.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="password" value="Senha" class="text-xs font-black uppercase tracking-widest text-slate-600" />
                <x-text-input
                    id="password"
                    class="mt-2 block h-12 w-full rounded-md border-slate-200 bg-slate-50 px-4 text-slate-900 shadow-none transition focus:border-slate-900 focus:bg-white focus:ring-slate-900"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="Minimo 8 caracteres"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" value="Confirmar" class="text-xs font-black uppercase tracking-widest text-slate-600" />
                <x-text-input
                    id="password_confirmation"
                    class="mt-2 block h-12 w-full rounded-md border-slate-200 bg-slate-50 px-4 text-slate-900 shadow-none transition focus:border-slate-900 focus:bg-white focus:ring-slate-900"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Repita a senha"
                />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <button type="submit" class="inline-flex h-12 w-full items-center justify-center rounded-md bg-slate-950 px-5 text-sm font-black uppercase tracking-widest text-white transition hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-slate-950 focus:ring-offset-2">
            Criar conta
        </button>
    </form>

    <div class="mt-6 rounded-md border border-dashed border-slate-300 p-4 text-center">
        <p class="text-sm text-slate-600">
            Ja possui acesso?
            <a href="{{ route('login') }}" class="font-black text-slate-950 underline-offset-4 hover:underline">Entrar agora</a>
        </p>
    </div>
</x-guest-layout>
