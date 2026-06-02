<?php

namespace App\Http\Controllers;

use App\Models\estoque;
use App\Support\EstoqueAlerta;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function index() {
        $estoques = estoque::all();
        return view('estoque.index', compact('estoques'));
    }

    public function create() {
        return view('estoque.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'quantidade' => 'required|integer|min:0',
            'quantidade_minima' => 'nullable|integer|min:0',
        ]);

        $item = estoque::create($request->only('nome', 'quantidade', 'quantidade_minima'));

        EstoqueAlerta::verificar($item);

        return redirect()->route('estoque.index')->with('success', 'Item cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $estoque = estoque::findOrFail($id);
        return view('estoque.edit', compact('estoque'));
    }

    public function update(Request $request, $id)
    {
        $estoque = estoque::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'quantidade' => 'required|integer|min:0',
            'quantidade_minima' => 'nullable|integer|min:0',
        ]);

        $estoque->update($request->only('nome', 'quantidade', 'quantidade_minima'));

        EstoqueAlerta::verificar($estoque->fresh());

        return redirect()->route('estoque.index')->with('success', 'Item atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $item = estoque::findOrFail($id);
        $item->delete();

        return redirect()->route('estoque.index')->with('success', 'Item excluído com sucesso!');
    }
}
