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
        <h1 class="mb-4">Bem-vindo, {{ Auth::user()->name }}!</h1>
        <p>Área restrita de desenvolvedores.</p>
        <a href="{{ route('inicio') }}" class="btn btn-secondary">Voltar</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">Sair</button>
        </form> 
        <a href="{{ route('cards.index') }}" class="btn btn-purple btn-lg">Manter Cards</a>
        <a href="{{ route('carousels.index') }}" class="btn btn-purple btn-lg">Manter Carrossel</a>

    </div>
</body>
</html>
