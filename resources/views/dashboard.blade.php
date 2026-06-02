<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard do Sistema') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (($counts['notificacoes_nao_lidas'] ?? 0) > 0 || ($counts['estoque_baixo'] ?? 0) > 0)
                <div class="mb-6 space-y-3">
                    @if (($counts['notificacoes_nao_lidas'] ?? 0) > 0)
                        <div class="bg-indigo-50 border border-indigo-200 text-indigo-800 px-4 py-3 rounded-lg flex flex-wrap items-center justify-between gap-2">
                            <span>Você tem <strong>{{ $counts['notificacoes_nao_lidas'] }}</strong> notificação(ões) não lida(s).</span>
                            <a href="{{ route('notifications.index') }}" class="font-semibold underline">Ver notificações</a>
                        </div>
                    @endif
                    @if (($counts['estoque_baixo'] ?? 0) > 0)
                        <div class="bg-amber-50 border border-amber-200 text-amber-900 px-4 py-3 rounded-lg flex flex-wrap items-center justify-between gap-2">
                            <span><strong>{{ $counts['estoque_baixo'] }}</strong> item(ns) com estoque abaixo do mínimo.</span>
                            <a href="{{ route('estoque.index') }}" class="font-semibold underline">Ver estoque</a>
                        </div>
                    @endif
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Card Clientes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-indigo-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-700">Clientes</h3>
                            <span class="p-2 bg-indigo-100 rounded-full text-indigo-600">
                                👥
                            </span>
                        </div>
                        <p class="text-3xl font-extrabold text-gray-900">{{ $counts['clientes'] }}</p>
                        <div class="mt-4 flex space-x-2">
                            <a href="{{ route('clientes.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-900">Ver todos</a>
                            <span class="text-gray-300">|</span>
                            <a href="{{ route('clientes.create') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900">Adicionar</a>
                        </div>
                    </div>
                </div>

                <!-- Card Pedidos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-700">Pedidos</h3>
                            <span class="p-2 bg-green-100 rounded-full text-green-600">
                                📦
                            </span>
                        </div>
                        <p class="text-3xl font-extrabold text-gray-900">{{ $counts['pedidos'] }}</p>
                        <div class="mt-4 flex space-x-2">
                            <a href="{{ route('pedidos.index') }}" class="text-sm font-semibold text-green-600 hover:text-green-900">Ver todos</a>
                            <span class="text-gray-300">|</span>
                            <a href="{{ route('pedidos.create') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900">Novo Pedido</a>
                        </div>
                    </div>
                </div>

                <!-- Card Estoque -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-yellow-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-700">Estoque</h3>
                            <span class="p-2 bg-yellow-100 rounded-full text-yellow-600">
                                🏢
                            </span>
                        </div>
                        <p class="text-3xl font-extrabold text-gray-900">{{ $counts['estoque'] }}</p>
                        <div class="mt-4 flex space-x-2">
                            <a href="{{ route('estoque.index') }}" class="text-sm font-semibold text-yellow-600 hover:text-yellow-900">Ver estoque</a>
                            <span class="text-gray-300">|</span>
                            <a href="{{ route('estoque.create') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900">Adicionar item</a>
                        </div>
                    </div>
                </div>

                <!-- Card Produtos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-purple-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-700">Produtos</h3>
                            <span class="p-2 bg-purple-100 rounded-full text-purple-600">
                                👕
                            </span>
                        </div>
                        <p class="text-3xl font-extrabold text-gray-900">{{ $counts['produto'] }}</p>
                        <div class="mt-4 flex space-x-2">
                            <a href="{{ route('produtos.index') }}" class="text-sm font-semibold text-purple-600 hover:text-purple-900">Ver catálogo</a>
                            <span class="text-gray-300">|</span>
                            <a href="{{ route('produtos.create') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900">Novo cadastro</a>
                        </div>
                    </div>
                </div>

                <!-- Card Fornecedores -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-red-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-700">Fornecedores</h3>
                            <span class="p-2 bg-red-100 rounded-full text-red-600">
                                🚚
                            </span>
                        </div>
                        <p class="text-3xl font-extrabold text-gray-900">{{ $counts['fornecedores'] }}</p>
                        <div class="mt-4 flex space-x-2">
                            <a href="{{ route('fornecedores.index') }}" class="text-sm font-semibold text-red-600 hover:text-red-900">Ver todos</a>
                            <span class="text-gray-300">|</span>
                            <a href="{{ route('fornecedores.create') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900">Adicionar</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
