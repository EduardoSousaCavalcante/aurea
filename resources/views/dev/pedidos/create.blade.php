<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Pedido</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="bg-light">

<div class="container mt-5 mb-5">
    <div class="d-flex align-items-center mb-4">
        <h2 class="me-3">Criar Pedido</h2>
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

            <form action="{{ route('pedidos.store') }}" method="POST">
                @csrf

                <!-- CLIENTE -->
                <div class="mb-3">
                    <label class="form-label">Cliente</label>
                    <select name="id_cliente" class="form-control">
                        <option value="">Selecione um cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}">
                                {{ $cliente->razao_social }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- PRODUTO -->
                <div class="mb-3">
                    <label class="form-label">Produto</label>
                    <select id="produto-select" class="form-control">
                        <option value="">Selecione um produto</option>
                        @foreach($produtos as $produto)
                            <option value="{{ $produto->id }}">
                                {{ $produto->nome }} - R$ {{ number_format($produto->preco, 2, ',', '.') }}
                            </option>
                        @endforeach
                    </select>

                    <button type="button" class="btn btn-primary mt-2"
                        onclick="adicionarProdutoCarrinho()">
                        Adicionar
                    </button>
                </div>

                <!-- CARRINHO -->
                <div class="mb-3">
                    <label class="form-label">Carrinho</label>

                    <table class="table table-bordered" id="tabela-carrinho">
                        <thead class="table-light">
                            <tr>
                                <th>Produto</th>
                                <th>Preço</th>
                                <th>Quantidade</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody></tbody>

                        <tfoot>
                            <tr class="table-light">
                                <td colspan="3" class="text-end fw-bold">Total:</td>
                                <td class="fw-bold" id="total">R$ 0,00</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <button type="submit" class="btn btn-success">
                    Criar Pedido
                </button>

            </form>
        </div>
    </div>
</div>

<script>
const produtos = @json($produtos);
let carrinho = [];

function adicionarProdutoCarrinho() {

    const select = document.getElementById('produto-select');
    const id = parseInt(select.value);

    if (!id) return;

    const produtoOriginal = produtos.find(p => parseInt(p.id) === id);
    if (!produtoOriginal) return;

    // Evita duplicar produto
    if (carrinho.find(p => p.id === id)) {
        alert('Produto já está no carrinho!');
        return;
    }

    // Clona o produto e garante tipos corretos
    const produto = {
        id: parseInt(produtoOriginal.id),
        nome: produtoOriginal.nome,
        descricao: produtoOriginal.descricao || '',
        quantidade_por_caixa: produtoOriginal.quantidade_por_caixa || '-',
        imagem: produtoOriginal.imagem || null,
        preco: parseFloat(produtoOriginal.preco),
        quantidade: 1
    };

    carrinho.push(produto);

    atualizarCarrinho();

    select.value = '';
}

function alterarQuantidade(id, delta) {

    id = parseInt(id);

    const item = carrinho.find(p => p.id === id);
    if (!item) return;

    item.quantidade += delta;

    if (item.quantidade < 1) {
        item.quantidade = 1;
    }

    atualizarCarrinho();
}

function removerProdutoCarrinho(id) {

    id = parseInt(id);

    carrinho = carrinho.filter(p => p.id !== id);

    atualizarCarrinho();
}

function atualizarCarrinho() {

    const tbody = document.querySelector('#tabela-carrinho tbody');
    tbody.innerHTML = '';

    let total = 0;

    carrinho.forEach(produto => {

        const subtotal = produto.preco * produto.quantidade;
        total += subtotal;

        const tr = document.createElement('tr');

        tr.innerHTML = `
            <td>
                <input type="hidden"
                       name="produtos[${produto.id}]"
                       value="${produto.quantidade}">

                <div class="d-flex align-items-center">

                    ${produto.imagem 
                        ? `<img src="/images/${produto.imagem}" 
                               style="width:50px;height:50px;
                               object-fit:cover;
                               margin-right:10px;
                               border-radius:6px;">`
                        : ''}

                    <div>
                        <strong>${produto.nome}</strong>

                        <div class="small text-muted">
                            ${produto.descricao}
                        </div>

                        <div class="small">
                            Qtd/Caixa: ${produto.quantidade_por_caixa}
                        </div>
                    </div>

                </div>
            </td>

            <td>
                R$ ${produto.preco.toFixed(2).replace('.', ',')}
            </td>

            <td>
                <div class="input-group" style="max-width: 130px;">
                    <button type="button"
                            class="btn btn-outline-secondary btn-sm"
                            onclick="alterarQuantidade(${produto.id}, -1)">
                        -
                    </button>

                    <input type="number"
                           class="form-control form-control-sm text-center"
                           value="${produto.quantidade}"
                           readonly>

                    <button type="button"
                            class="btn btn-outline-secondary btn-sm"
                            onclick="alterarQuantidade(${produto.id}, 1)">
                        +
                    </button>
                </div>
            </td>

            <td>
                R$ ${subtotal.toFixed(2).replace('.', ',')}
            </td>

            <td>
                <button type="button"
                        class="btn btn-danger btn-sm"
                        onclick="removerProdutoCarrinho(${produto.id})">
                    Remover
                </button>
            </td>
        `;

        tbody.appendChild(tr);
    });

    document.getElementById('total').textContent =
        'R$ ' + total.toFixed(2).replace('.', ',');
}
</script>


</body>
</html>