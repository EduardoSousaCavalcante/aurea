<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\Cliente;
use App\Models\PedidoProduto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PedidoController extends Controller
{
    // Listar pedidos
    public function index()
    {
        $pedidos = Pedido::with(['cliente', 'produtos'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dev.pedidos.index', compact('pedidos'));
    }

    // Mostrar formulário de criação
    public function create()
    {
        $clientes = Cliente::orderBy('razao_social')->get();
        $produtos = Produto::orderBy('nome')->get();

        return view('dev.pedidos.create', compact('clientes', 'produtos'));
    }

    // Salvar pedido
    public function store(Request $request)
{
    $request->validate([
        'id_cliente' => 'required|exists:clientes,id',
        'produtos' => 'required|array|min:1',
        'produtos.*' => 'integer|min:1',
    ]);

    DB::beginTransaction();

    try {
        // 1️⃣ Gera a chave aleatória
        $chave = \Str::upper(\Str::random(12));

        // 2️⃣ Cria pedido
        $pedido = Pedido::create([
            'id_cliente' => $request->id_cliente,
            'chave_aleatoria' => $chave,
            'data_pedido' => now(),
        ]);

        // 3️⃣ Cria os produtos no pedido
        foreach ($request->produtos as $idProduto => $quantidade) {
            if ($quantidade > 0) {
                $produto = Produto::findOrFail($idProduto);

                PedidoProduto::create([
                    'id_pedido' => $pedido->id,
                    'id_produto' => $produto->id,
                    'quantidade' => $quantidade,
                    'preco_unitario' => $produto->preco,
                ]);
            }
        }

        DB::commit();

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido criado com sucesso! Chave: ' . $chave);

    } catch (\Exception $e) {
        DB::rollBack();
        dd($e->getMessage()); // mostra erro real se falhar
    }
}


    // Mostrar detalhes
    public function show(Pedido $pedido)
    {
        $pedido->load(['cliente', 'produtos']);
        return view('dev.pedidos.show', compact('pedido'));
    }

    // Editar
    public function edit(Pedido $pedido)
    {
        $clientes = Cliente::orderBy('razao_social')->get();
        $produtos = Produto::orderBy('nome')->get();

        $produtosPedido = PedidoProduto::where('id_pedido', $pedido->id)
            ->pluck('quantidade', 'id_produto')
            ->toArray();

        return view('dev.pedidos.edit', compact(
            'pedido',
            'clientes',
            'produtos',
            'produtosPedido'
        ));
    }

    // Atualizar
    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'id_cliente' => 'required|exists:clientes,id',
            'produtos' => 'required|array|min:1',
            'produtos.*' => 'integer|min:0',
        ]);

        DB::beginTransaction();

        try {

            $pedido->update([
                'id_cliente' => $request->id_cliente,
            ]);

            // Remove produtos antigos
            PedidoProduto::where('id_pedido', $pedido->id)->delete();

            // Insere novamente
            foreach ($request->produtos as $idProduto => $quantidade) {

                if ($quantidade > 0) {

                    $produto = Produto::findOrFail($idProduto);

                    PedidoProduto::create([
                        'id_pedido' => $pedido->id,
                        'id_produto' => $produto->id,
                        'quantidade' => $quantidade,
                        'preco_unitario' => $produto->preco,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('pedidos.index')
                ->with('success', 'Pedido atualizado com sucesso!');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Erro ao atualizar pedido.');
        }
    }

    // Deletar
    public function destroy(Pedido $pedido)
    {
        DB::beginTransaction();

        try {

            PedidoProduto::where('id_pedido', $pedido->id)->delete();
            $pedido->delete();

            DB::commit();

            return redirect()
                ->route('pedidos.index')
                ->with('success', 'Pedido deletado com sucesso!');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Erro ao deletar pedido.');
        }
    }
}
