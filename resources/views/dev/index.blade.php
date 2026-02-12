<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área de Desenvolvedores</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex align-items-start mb-4">
            <h1 class="mb-1 me-3">Bem-vindo, {{ Auth::user()->name }}!</h1>
            <a href="{{ route('pedidos.create') }}" class="btn btn-success btn-lg">Novo Pedido</a>
        </div>
        <hr class="my-4 border-2 border-secondary">
        <p>Área restrita de desenvolvedores.</p>
        <div class="d-flex flex-wrap justify-content-between w-100">
            <div class="w-100">
                <a href="{{ route('cards.index') }}" class="btn btn-purple btn-lg w-100 w-md-auto mb-2">Manter Cards</a>
                <a href="{{ route('carousels.index') }}" class="btn btn-purple btn-lg w-100 w-md-auto mb-2">Manter Carrossel</a>
                <a href="{{ route('pedidos.index') }}" class="btn btn-purple btn-lg w-100 w-md-auto mb-2">Manter Pedidos</a>
                <a href="{{ route('clientes.index') }}" class="btn btn-purple btn-lg w-100 w-md-auto mb-2">Manter Clientes</a>
            </div>
            <div class="d-flex align-items-center">
                <a href="{{ route('inicio') }}" class="btn btn-secondary me-1">Voltar</a>
        
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Sair</button>
                </form> 
            </div>
        </div>
    </div>
</body>
</html>
