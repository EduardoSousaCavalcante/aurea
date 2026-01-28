<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carousel;

class CarouselController extends Controller
{
    /**
     * Lista todos os carousels.
     */
    public function index()
    {
        $carousels = Carousel::all();
        return view('dev.carousels.index', compact('carousels'));
    }

    /**
     * Exibe o formulário de criação de slide.
     */
    public function create()
    {
        return view('dev.carousels.create');
    }

    /**
     * Salva um novo slide no banco.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:50',
            'descricao' => 'nullable|max:150',
            'imagem' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        // Pega o arquivo e salva na pasta public/images
        $nomeArquivo = $request->file('imagem')->getClientOriginalName();
        $request->file('imagem')->move(public_path('images'), $nomeArquivo);

        // Cria o carousel
        Carousel::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'imagem' => $nomeArquivo,
        ]);

        return redirect()->route('carousels.index');
    }



    /**
     * Exibe o formulário de edição de um slide.
     */
    public function edit($id)
    {
        $carousel = Carousel::findOrFail($id);
        return view('dev.carousels.edit', compact('carousel'));
    }

    /**
     * Atualiza os dados do slide.
     */
    public function update(Request $request, $id)
    {
        $carousel = Carousel::findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:100',
            'descricao' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Atualizar imagem se for enviada
        if ($request->hasFile('img')) {
            $fileName = time() . '.' . $request->img->extension();
            $request->img->move(public_path('images'), $fileName);
            $carousel->img = $fileName;
        }

        $carousel->titulo = $request->titulo;
        $carousel->descricao = $request->descricao;
        $carousel->save();

        return redirect()->route('carousels.index')->with('success', 'Slide atualizado com sucesso!');
    }

    /**
     * Deleta um slide.
     */
    public function destroy($id)
    {
        $carousel = Carousel::findOrFail($id);
        $carousel->delete();

        return redirect()->route('carousels.index')->with('success', 'Slide deletado com sucesso!');
    }
}
