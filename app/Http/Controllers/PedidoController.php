<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use App\Notifications\NovoPedidoNotification;
use App\Services\NotificacaoService;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index() {
        $pedidos = Pedidos::all();
        return view('pedido.index', compact('pedidos'));
    }

    public function create() {
        return view('pedido.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|unique:pedidos',
            'endereco' => 'nullable|string',
        ]);

        $pedido = Pedidos::create($request->all());

        NotificacaoService::enviarParaUsuarios(new NovoPedidoNotification($pedido));

        return redirect()->route('pedidos.index')->with('success', 'Pedido cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $pedido = Pedidos::findOrFail($id);
        return view('pedido.edit', compact('pedido'));
    }

    public function update(Request $request, $id)
    {
        $pedido = Pedidos::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|unique:pedidos,telefone,' . $id,
            'endereco' => 'nullable|string',
        ]);

        $pedido->update($request->all());

        return redirect()->route('pedidos.index')->with('success', 'Pedido atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $pedido = Pedidos::findOrFail($id);
        $pedido->delete();

        return redirect()->route('pedidos.index')->with('success', 'Pedido excluído com sucesso!');
    }
}
