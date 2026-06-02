<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Notifications\OperacaoSistemaNotification;
use App\Services\NotificacaoService;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function index() {
        $fornecedores = Fornecedor::all();
        return view('fornecedor.index', compact('fornecedores'));
    }

    public function create() {
        return view('fornecedor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|unique:fornecedor',
            'endereco' => 'nullable|string',
        ]);

        $fornecedor = Fornecedor::create($request->all());

        NotificacaoService::enviarParaUsuarios(new OperacaoSistemaNotification(
            'Novo fornecedor cadastrado',
            'Fornecedor '.$fornecedor->nome.' foi adicionado.',
            route('fornecedores.index'),
            'novo_fornecedor'
        ));

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        return view('fornecedor.edit', compact('fornecedor'));
    }

    public function update(Request $request, $id)
    {
        $fornecedor = Fornecedor::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|unique:fornecedor,telefone,' . $id,
            'endereco' => 'nullable|string',
        ]);

        $fornecedor->update($request->all());

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        $fornecedor->delete();

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor excluído com sucesso!');
    }
}
