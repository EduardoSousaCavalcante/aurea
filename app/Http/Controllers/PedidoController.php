<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\Cliente;
use App\Models\PedidoProduto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PDF;

class PedidoController extends Controller
{
    public function pdfCliente(Cliente $cliente)
    {
        $cliente->load('pedidos');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'cliente-pdf',
            compact('cliente')
        );

        return $pdf->stream('cliente_'.$cliente->id.'.pdf');
    }

    public function pdfPedido(Pedido $pedido)
    {
        $pedido->load(['cliente', 'produtos']);

        $pdf = Pdf::loadView('pdf.pedido', compact('pedido'));

        return $pdf->stream('pedido_'.$pedido->chave_aleatoria.'.pdf');
    }

    // teste PDF
    public function testePdf()
    {
        $nome = "Eduardo";

        $pdf = Pdf::loadView('teste-pdf', compact('nome'));

        return $pdf->stream();
    }   

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
        // somente produtos que ainda possuem estoque para evitar seleção de itens esgotados
        $produtos = Produto::where('estoque', '>', 0)->orderBy('nome')->get();

        return view('dev.pedidos.create', compact('clientes', 'produtos'));
    }

    // Salvar pedido
    public function store(Request $request)
{
    $request->validate([
        'id_cliente' => 'required|exists:clientes,id',
        'produtos' => 'required|array|min:1',
        'produtos.*' => 'integer|min:1',
        'data_entrega' => 'nullable|date',
        'metodo_pagamento' => 'required|string',
    ]);

    DB::beginTransaction();

    try {

        $chave = \Str::upper(\Str::random(12));

        $pedido = Pedido::create([
            'id_cliente' => $request->id_cliente,
            'chave_aleatoria' => $chave,
            'data_pedido' => now(),
            'data_entrega' => $request->data_entrega,
            'metodo_pagamento' => $request->metodo_pagamento,
        ]);

        foreach ($request->produtos as $idProduto => $quantidade) {

            if ($quantidade > 0) {

                $produto = Produto::findOrFail($idProduto);

                if ($produto->estoque < $quantidade) {

                    DB::rollBack();

                    return back()
                        ->with('error', "Estoque insuficiente para {$produto->nome}")
                        ->withInput();
                }
                $produto->estoque -= $quantidade;
                $produto->save();

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
            ->with('success', 'Pedido criado com sucesso! Chave: ' . $chave);

    } catch (\Exception $e) {

        DB::rollBack();
        dd($e->getMessage());
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
            'data_entrega' => 'required|date',
            'metodo_pagamento' => 'required|string'
        ]);

        DB::beginTransaction();

        try {

            $pedido->update([
                'id_cliente' => $request->id_cliente,
            ]);

            // restaurar estoque dos produtos antigos antes de apagar
            $oldItems = PedidoProduto::where('id_pedido', $pedido->id)->get();
            foreach ($oldItems as $item) {
                $p = Produto::find($item->id_produto);
                if ($p) {
                    $p->estoque += $item->quantidade;
                    $p->save();
                }
            }

            // Remove produtos antigos
            PedidoProduto::where('id_pedido', $pedido->id)->delete();

            // Insere novamente e decrementa estoque
            foreach ($request->produtos as $idProduto => $quantidade) {
                if ($quantidade > 0) {
                    $produto = Produto::findOrFail($idProduto);

                    if ($produto->estoque < $quantidade) {
                        DB::rollBack();
                        return back()->with('error', "Estoque insuficiente para o produto {$produto->nome}")->withInput();
                    }

                    $produto->estoque -= $quantidade;
                    $produto->save();

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

            // restaurar estoque antes de excluir
            $items = PedidoProduto::where('id_pedido', $pedido->id)->get();
            foreach ($items as $item) {
                $p = Produto::find($item->id_produto);
                if ($p) {
                    $p->estoque += $item->quantidade;
                    $p->save();
                }
            }

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
