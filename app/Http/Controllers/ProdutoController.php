<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Notifications\OperacaoSistemaNotification;
use App\Services\NotificacaoService;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index() {
        $produtos = Produto::all();
        return view('produto.index', compact('produtos'));
    }

    public function create() {
        return view('produto.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
        ]);

        $produto = Produto::create($request->all());

        NotificacaoService::enviarParaUsuarios(new OperacaoSistemaNotification(
            'Novo produto cadastrado',
            'Produto '.$produto->nome.' foi adicionado ao catálogo.',
            route('produtos.index'),
            'novo_produto'
        ));

        return redirect()->route('produtos.index')->with('success', 'Produto cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $produto = Produto::findOrFail($id);
        return view('produto.edit', compact('produto'));
    }

    public function update(Request $request, $id)
    {
        $produto = Produto::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
        ]);

        $produto->update($request->all());

        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);
        $produto->delete();

        return redirect()->route('produtos.index')->with('success', 'Produto excluído com sucesso!');
    }
}
