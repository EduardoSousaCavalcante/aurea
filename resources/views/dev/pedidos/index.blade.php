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
        <h2 class="me-3">Manter Pedidos</h2>
        <a href="{{ route('pedidos.create') }}" class="btn btn-success">Adicionar Pedido</a>
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
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
