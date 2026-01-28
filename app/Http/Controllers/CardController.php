<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;

class CardController extends Controller
{
    // Mostrar todos os cards
    public function index()
    {
        $cards = Card::orderBy('created_at', 'desc')->get(); // Agora do mais novo para o mais antigo
        return view('dev.cards.index', compact('cards'));
    }


    // Mostrar formulário para criar
    public function create()
    {
        return view('dev.cards.create');
    }

    // Salvar novo card
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:50',
            'descricao' => 'required|max:150',
            'img' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'link' => 'nullable|max:255',
        ]);

        $imageName = null;

        // Salvar a imagem na pasta public/images
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
        }

        Card::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'img' => $imageName,
            'link' => $request->link ?? '#',
            'curtidas' => 0,
            'views' => 0,
        ]);

        return redirect()->route('cards.index')->with('success', 'Card criado com sucesso!');
    }

    // Mostrar formulário para editar
    public function edit(Card $card)
    {
        return view('dev.cards.edit', compact('card'));
    }

    // Atualizar card
    public function update(Request $request, Card $card)
    {
        $request->validate([
            'titulo' => 'required|max:50',
            'descricao' => 'required|max:150',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'link' => 'nullable|max:255',
        ]);

        $card->titulo = $request->titulo;
        $card->descricao = $request->descricao;
        $card->link = $request->link ?? '#';

        // Se veio uma nova imagem, salva
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $card->img = $imageName;
        }

        $card->save();

        return redirect()->route('cards.index')->with('success', 'Card atualizado com sucesso!');
    }

    // Deletar card
    public function destroy(Card $card)
    {
        $card->delete();
        return redirect()->route('cards.index')->with('success', 'Card deletado com sucesso!');
    }
}
