<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="d-flex align-items-center mb-4">
            <h2 class="me-3">Editar Pedido</h2>
            <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Voltar</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('pedidos.update', $pedido) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Chave do Pedido</label>
                        <input type="text" class="form-control" value="{{ $pedido->chave_aleatoria }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="id_cliente" class="form-label">Cliente</label>
                        <select name="id_cliente" id="id_cliente" class="form-control @error('id_cliente') is-invalid @enderror">
                            <option value="">Selecione um cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ ($pedido->id_cliente == $cliente->id) ? 'selected' : '' }}>
                                    {{ $cliente->razao_social }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_cliente')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Produtos</label>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produto</th>
                                        <th>Preço Unitário</th>
                                        <th>Quantidade</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($produtos as $produto)
                                        <tr>
                                            <td>{{ $produto->nome }}</td>
                                            <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                                            <td>
                                                <input type="number" name="produtos[{{ $produto->id }}]" 
                                                       class="form-control quantidade-input" 
                                                       value="{{ $produtosPedido[$produto->id] ?? 0 }}" 
                                                       min="0" data-preco="{{ $produto->preco }}">
                                            </td>
                                            <td class="subtotal">R$ 0,00</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-light">
                                        <td colspan="3" class="text-end fw-bold">Total:</td>
                                        <td class="fw-bold" id="total">R$ 0,00</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Atualizar Pedido</button>
                        <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const inputs = document.querySelectorAll('.quantidade-input');
        
        function calcularTotais() {
            let totalGeral = 0;
            
            document.querySelectorAll('tbody tr').forEach(row => {
                const input = row.querySelector('.quantidade-input');
                const preco = parseFloat(input.dataset.preco);
                const quantidade = parseInt(input.value) || 0;
                const subtotal = preco * quantidade;
                
                row.querySelector('.subtotal').textContent = 'R$ ' + subtotal.toFixed(2).replace('.', ',');
                
                totalGeral += subtotal;
            });
            
            document.getElementById('total').textContent = 'R$ ' + totalGeral.toFixed(2).replace('.', ',');
        }
        
        // Calcular totais ao carregar a página
        calcularTotais();
        
        inputs.forEach(input => {
            input.addEventListener('change', calcularTotais);
            input.addEventListener('input', calcularTotais);
        });
    </script>
</body>
</html>
