<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manter Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    <div class="d-flex align-items-center mb-4">
        <h2 class="me-3">Manter Pedidos</h2>
        <a href="{{ route('pedidos.create') }}" class="btn btn-success">Adicionar Pedido</a>
        <a href="{{ route('dev.index') }}" class="btn btn-secondary">Voltar</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($pedidos->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white">
                <thead class="table-light">
                    <tr>
                        <th>Chave</th>
                        <th>Cliente</th>
                        <th>Data do Pedido</th>
                        <th>Produtos</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos as $pedido)
                        <tr>
                            <td>
                                <span class="badge bg-primary" title="Código único do pedido">{{ $pedido->chave_aleatoria }}</span>
                            </td>
                            <td>{{ $pedido->cliente->razao_social ?? 'N/A' }}</td>
                            <td>{{ $pedido->data_pedido->format('d/m/Y H:i') }}</td>
                            <td>
                                @if ($pedido->produtos->count() > 0)
                                    {{ $pedido->produtos->count() }} produto(s)
                                @else
                                    <span class="text-muted">Nenhum produto</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pedidos.show', $pedido) }}" class="btn btn-sm btn-info">
                                    Ver
                                </a>
                                <a href="{{ route('pedidos.edit', $pedido) }}" class="btn btn-sm btn-warning">
                                    Editar
                                </a>
                                <a href="{{ route('pedidos.pdf', $pedido) }}" 
                                    class="btn btn-sm btn-secondary" target="_blank">
                                        Baixar PDF
                                    </a>
                                <form action="{{ route('pedidos.destroy', $pedido) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja deletar este pedido?')">
                                        Deletar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            Nenhum pedido cadastrado. <a href="{{ route('pedidos.create') }}" class="alert-link">Criar um novo pedido</a>.
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
