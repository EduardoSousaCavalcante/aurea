<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="d-flex align-items-center mb-4">
            <h2 class="me-3">Detalhes do Pedido</h2>
            <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Voltar</a>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Informações do Pedido</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="fw-bold">Chave do Pedido:</label>
                            <p class="badge bg-primary" style="font-size: 1rem;">{{ $pedido->chave_aleatoria }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Cliente:</label>
                            <p>{{ $pedido->cliente->razao_social ?? 'N/A' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Data do Pedido:</label>
                            <p>{{ $pedido->data_pedido->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Criado em:</label>
                            <p>{{ $pedido->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Ações</h5>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('pedidos.edit', $pedido) }}" class="btn btn-warning w-100 mb-2">
                            Editar Pedido
                        </a>
                        <form action="{{ route('pedidos.destroy', $pedido) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100" 
                                    onclick="return confirm('Tem certeza que deseja deletar este pedido?')">
                                Deletar Pedido
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Produtos do Pedido</h5>
            </div>
            <div class="card-body">
                @if ($pedido->produtos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Preço Unitário</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalPedido = 0;
                                @endphp
                                @foreach ($pedido->produtos as $produto)
                                    @php
                                        $subtotal = $produto->pivot->quantidade * $produto->pivot->preco_unitario;
                                        $totalPedido += $subtotal;
                                    @endphp
                                    <tr>
                                        <td>{{ $produto->nome }}</td>
                                        <td class="text-center">{{ $produto->pivot->quantidade }}</td>
                                        <td>R$ {{ number_format($produto->pivot->preco_unitario, 2, ',', '.') }}</td>
                                        <td class="fw-bold">R$ {{ number_format($subtotal, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-light">
                                    <td colspan="3" class="text-end fw-bold">Total do Pedido:</td>
                                    <td class="fw-bold bg-success text-white">R$ {{ number_format($totalPedido, 2, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning">
                        Este pedido não possui produtos registrados.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
