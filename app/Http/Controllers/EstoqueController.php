<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class EstoqueController extends Controller
{
    public function index()
    {
        $produtos = Produto::orderBy('nome')->get();

        return view('dev.estoque.index', compact('produtos'));
    }

    public function update(Request $request)
    {
        if ($request->estoque) {

            foreach ($request->estoque as $id => $valor) {

                $produto = Produto::find($id);

                if ($produto) {
                    $produto->estoque = $valor;
                    $produto->save();
                }
            }

        }

        return redirect()
            ->route('estoque.index')
            ->with('success', 'Estoque atualizado com sucesso.');
    }
}