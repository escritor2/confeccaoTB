<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use Illuminate\Http\Request;

class InsumoController extends Controller
{
    public function index() {
        $insumos = Insumo::all();
        return view('insumo.index', compact('insumos'));
    }

    public function create() {
        return view('insumo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'unidade' => 'required|string|max:50',
            'quantidade' => 'required|integer|min:0',
            'quantidade_minima' => 'nullable|integer|min:0',
            'custo_unitario' => 'nullable|numeric|min:0',
            'observacoes' => 'nullable|string|max:1000',
        ]);

        Insumo::create($request->only('nome', 'unidade', 'quantidade', 'quantidade_minima', 'custo_unitario', 'observacoes'));

        return redirect()->route('insumo.index')->with('success', 'Insumo cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $insumo = Insumo::findOrFail($id);
        return view('insumo.edit', compact('insumo'));
    }

    public function update(Request $request, $id)
    {
        $insumo = Insumo::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'unidade' => 'required|string|max:50',
            'quantidade' => 'required|integer|min:0',
            'quantidade_minima' => 'nullable|integer|min:0',
            'custo_unitario' => 'nullable|numeric|min:0',
            'observacoes' => 'nullable|string|max:1000',
        ]);

        $insumo->update($request->only('nome', 'unidade', 'quantidade', 'quantidade_minima', 'custo_unitario', 'observacoes'));

        return redirect()->route('insumo.index')->with('success', 'Insumo atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $insumo = Insumo::findOrFail($id);
        $insumo->delete();

        return redirect()->route('insumo.index')->with('success', 'Insumo excluído com sucesso!');
    }
}
