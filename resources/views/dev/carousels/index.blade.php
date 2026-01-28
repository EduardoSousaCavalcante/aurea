<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manter Carousels</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex align-items-center mb-4">
        <h2 class="me-3">Manter Carousels</h2>
        <a href="{{ route('carousels.create') }}" class="btn btn-success">Adicionar Slide</a>
        <a href="{{ route('dev.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>ID</th>
                <th>Imagem</th>
                <th>Título</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($carousels as $carousel)
            <tr>
                <td>{{ $carousel->id }}</td>
                <td class="p-0">
                    <img src="{{ asset('images/' . $carousel->imagem) }}" alt="{{ $carousel->titulo }}" style="max-width: 150px;">
                </td>
                <td>{{ $carousel->titulo }}</td>
                <td>{{ $carousel->descricao }}</td>
                <td>
                    <a href="{{ route('carousels.edit', $carousel->id) }}" class="btn btn-primary btn-sm mb-2">Editar</a>

                    <form action="{{ route('carousels.destroy', $carousel->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Tem certeza que deseja deletar este slide?')">
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
