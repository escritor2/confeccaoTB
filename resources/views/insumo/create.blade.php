<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadastrar Novo Insumo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                
                <form action="{{ route('insumo.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Nome do Insumo *</label>
                            <input type="text" name="nome" value="{{ old('nome') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                            @error('nome') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Unidade de Medida *</label>
                            <select name="unidade" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                                <option value="un" {{ old('unidade') == 'un' ? 'selected' : '' }}>Unidade (un)</option>
                                <option value="m" {{ old('unidade') == 'm' ? 'selected' : '' }}>Metro (m)</option>
                                <option value="m2" {{ old('unidade') == 'm2' ? 'selected' : '' }}>Metro quadrado (m²)</option>
                                <option value="kg" {{ old('unidade') == 'kg' ? 'selected' : '' }}>Quilograma (kg)</option>
                                <option value="g" {{ old('unidade') == 'g' ? 'selected' : '' }}>Grama (g)</option>
                                <option value="l" {{ old('unidade') == 'l' ? 'selected' : '' }}>Litro (l)</option>
                                <option value="ml" {{ old('unidade') == 'ml' ? 'selected' : '' }}>Mililitro (ml)</option>
                                <option value="pç" {{ old('unidade') == 'pç' ? 'selected' : '' }}>Peça (pç)</option>
                                <option value="pct" {{ old('unidade') == 'pct' ? 'selected' : '' }}>Pacote (pct)</option>
                                <option value="cx" {{ old('unidade') == 'cx' ? 'selected' : '' }}>Caixa (cx)</option>
                                <option value="rolo" {{ old('unidade') == 'rolo' ? 'selected' : '' }}>Rolo</option>
                            </select>
                            @error('unidade') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Quantidade *</label>
                            <input type="number" name="quantidade" value="{{ old('quantidade', 0) }}" min="0" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                            @error('quantidade') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Quantidade mínima (alerta)</label>
                            <input type="number" name="quantidade_minima" value="{{ old('quantidade_minima', 10) }}" min="0" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                            <p class="text-xs text-gray-500 mt-1">Quando a quantidade atingir este valor, você receberá alerta de estoque baixo.</p>
                            @error('quantidade_minima') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700">Custo Unitário (R$)</label>
                            <input type="text" name="custo_unitario" value="{{ old('custo_unitario') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" placeholder="0,00">
                            <p class="text-xs text-gray-500 mt-1">Preço de custo por unidade (opcional).</p>
                            @error('custo_unitario') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Observações</label>
                        <textarea name="observacoes" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" placeholder="Informações adicionais sobre o insumo...">{{ old('observacoes') }}</textarea>
                        @error('observacoes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('insumo.index') }}" class="mr-4 text-sm text-gray-600 hover:text-gray-900">Cancelar</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Salvar Insumo
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
