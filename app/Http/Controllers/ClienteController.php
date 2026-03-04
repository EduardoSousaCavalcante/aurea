<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ClienteController extends Controller
{
    public function pdfCliente(Cliente $cliente)
    {
        $cliente->load('pedidos');

        $pdf = Pdf::loadView('cliente-pdf', compact('cliente'));

        return $pdf->stream('cliente_'.$cliente->id.'.pdf');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('dev.clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dev.clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cnpj' => 'required|string',
            'razao_social' => 'required|string',
            'ie' => 'required|string',
            'endereco' => 'required|string',
            'cep' => 'required|string',
            'apelido' => 'required|string',
        ]);

        Cliente::create($validated);

        return redirect()->route('clientes.index')->with('success', 'Cliente criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        return view('dev.clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view('dev.clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'cnpj' => 'required|string',
            'razao_social' => 'required|string',
            'ie' => 'required|string',
            'endereco' => 'required|string',
            'cep' => 'required|string',
            'apelido' => 'required|string',
        ]);

        $cliente->update($validated);

        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente deletado com sucesso!');
    }
}
