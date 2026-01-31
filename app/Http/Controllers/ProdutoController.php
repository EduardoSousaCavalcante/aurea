<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    // Listar produtos
    public function index()
    {
        $produtos = Produto::orderBy('created_at', 'desc')->get();
        return view('dev.produtos.index', compact('produtos'));
    }

    // Formulário de criação
    public function create()
    {
        return view('dev.produtos.create');
    }

    // Salvar produto
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|max:100',
            'preco' => 'required|numeric|min:0',
            'imagem' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $nomeImagem = null;

        if ($request->hasFile('imagem')) {
            $imagem = $request->file('imagem');
            $nomeImagem = time().'_'.$imagem->getClientOriginalName();
            $imagem->move(public_path('images'), $nomeImagem);
        }

        Produto::create([
            'nome' => $request->nome,
            'preco' => $request->preco,
            'imagem' => $nomeImagem,
        ]);

        return redirect()->route('produtos.index')
            ->with('success', 'Produto criado com sucesso!');
    }

    // Formulário de edição
    public function edit(Produto $produto)
    {
        return view('dev.produtos.edit', compact('produto'));
    }

    // Atualizar produto
    public function update(Request $request, Produto $produto)
    {
        $request->validate([
            'nome' => 'required|max:100',
            'preco' => 'required|numeric|min:0',
            'imagem' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $produto->nome = $request->nome;
        $produto->preco = $request->preco;

        if ($request->hasFile('imagem')) {
            $imagem = $request->file('imagem');
            $nomeImagem = time().'_'.$imagem->getClientOriginalName();
            $imagem->move(public_path('images'), $nomeImagem);
            $produto->imagem = $nomeImagem;
        }

        $produto->save();

        return redirect()->route('produtos.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    // Deletar produto
    public function destroy(Produto $produto)
    {
        $produto->delete();

        return redirect()->route('produtos.index')
            ->with('success', 'Produto deletado com sucesso!');
    }
}
