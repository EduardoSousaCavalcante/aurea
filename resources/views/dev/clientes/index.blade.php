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
        <h2 class="me-3">Manter Clientes</h2>
        <a href="{{ route('clientes.create') }}" class="btn btn-success">Adicionar Cliente</a>
        <a href="{{ route('dev.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>CNPJ</th>
                <th>Razão Social</th>
                <th>IE</th>
                <th>Endereço</th>
                <th>CEP</th>
                <th>Apelido</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->cnpj }}</td>
                    <td>{{ $cliente->razao_social }}</td>
                    <td>{{ $cliente->ie }}</td>
                    <td>{{ $cliente->endereco }}</td>
                    <td>{{ $cliente->cep }}</td>
                    <td>{{ $cliente->apelido }}</td>
                    <td>
                        <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">Deletar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Nenhum cliente cadastrado</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
