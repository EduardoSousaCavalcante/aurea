<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manter Cards</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex align-items-center mb-4">
        <h2 class="me-3">Manter Cards</h2>
        <a href="{{ route('cards.create') }}" class="btn btn-success">Adicionar Card</a>
        <a href="{{ route('dev.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>ID</th>
                <th>Imagem</th>
                <th>Título</th>
                <th>Descrição</th>
                <th>Curtidas</th>
                <th>Views</th>
                <th>Link</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cards as $card)
            <tr>
                <td>{{ $card->id }}</td>
                <td class="p-0"><img src="{{ asset('images/' . $card->img) }}" alt="{{ $card->titulo }}"></td>
                <td>{{ $card->titulo }}</td>
                <td>{{ $card->descricao }}</td>
                <td>{{ $card->curtidas }}</td>
                <td>{{ $card->views }}</td>
                <td><a href="{{ $card->link }}" target="_blank">Ver Link</a></td>
                <td>
                    <a href="{{ route('cards.edit', $card->id) }}" class="btn btn-primary btn-sm mb-2">Editar</a>

                    <form action="{{ route('cards.destroy', $card->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Tem certeza que deseja deletar este card?')">
                            Deletar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
