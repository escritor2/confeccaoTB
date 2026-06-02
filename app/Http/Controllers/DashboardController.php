<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;
use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\estoque;
use App\Models\Pedidos;

class DashboardController extends Controller
{
    public function index()
    {
        $counts = [
            'clientes' => Clientes::count(),
            'fornecedores' => Fornecedor::count(),
            'produto' => Produto::count(),
            'estoque' => estoque::count(),
            'pedidos' => Pedidos::count(),
            'estoque_baixo' => estoque::all()->filter(fn (estoque $item) => $item->estaAbaixoDoMinimo())->count(),
            'notificacoes_nao_lidas' => auth()->user()->unreadNotifications()->count(),
        ];

        return view('dashboard', compact('counts'));
    }
}
