<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Pedido</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> -->
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
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" id="razao-input" class="form-control" placeholder="Razão Social">
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="apelido-input" class="form-control" placeholder="Apelido">
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="codigo-input" class="form-control" placeholder="Código">
                        </div>
                    </div>
                    <div id="client-suggestions" class="mt-2" style="max-height: 200px; overflow-y: auto;"></div>
                    <p id="cliente-selecionado" class="mt-2 fw-bold"></p>
                    <input type="hidden" name="id_cliente" id="id_cliente">
                </div>

                <!-- PRODUTO -->
                <div class="mb-3">
                    <label class="form-label">Produto</label>
                    <select id="produto-select" class="form-control" disabled>
                        <option value="">Selecione um produto</option>
                        @foreach($produtos as $produto)
                            <option value="{{ $produto->id }}" data-estoque="{{ $produto->estoque }}" {{ $produto->estoque <= 0 ? 'disabled' : '' }}>
                                {{ $produto->nome }} ({{ $produto->estoque }} em estoque) - R$ {{ number_format($produto->preco, 2, ',', '.') }}
                            </option>
                        @endforeach
                    </select>

                    <button type="button" class="btn btn-primary mt-2"
                        onclick="adicionarProdutoCarrinho()" id="adicionar-produto-btn" disabled>
                        Adicionar
                    </button>
                </div>

                <!-- CARRINHO -->
                <div class="mb-3">
                    <label class="form-label">Carrinho</label>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0" id="tabela-carrinho">
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
                            <!-- Total removido do tfoot -->
                        </table>
                    </div>
                </div>
                <!-- PAGAMENTO E ENTREGA -->
                <div class="row mt-3">

                    <div class="col-md-6">
                        <label class="form-label">Método de Pagamento</label>
                        <select name="metodo_pagamento" id="metodo_pagamento" class="form-control" required>
                            <option value="">Selecione</option>
                            <option value="pix">PIX</option>
                            <option value="boleto">Boleto</option>
                            <option value="cartao">Cartão</option>
                            <option value="dinheiro">Dinheiro</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Data de Entrega</label>
                        <input type="date" name="data_entrega" class="form-control">
                    </div>

                </div>
                <div class="d-flex flex-row justify-content-between align-items-center w-100 gap-3 mt-3">
                    <button type="submit" class="btn btn-success flex-shrink-0" id="criar-pedido-btn" disabled>
                        Finalizar Pedido
                    </button>
                    <div class="fw-bold fs-5 text-end ms-auto" id="total-area">
                        Total: <span id="total">R$ 0,00</span>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
const produtos = @json($produtos);
const clientes = @json($clientes);

let carrinho = [];
let clienteSelecionado = null;

$(document).ready(function() {

    $('#razao-input, #apelido-input, #codigo-input').on('input', function() {
        filtrarClientes();
    });

    $('#metodo_pagamento').on('change', function() {
        validarFormularioPedido();
    });

});

function filtrarClientes() {

    const razaoTerm = $('#razao-input').val().toLowerCase();
    const apelidoTerm = $('#apelido-input').val().toLowerCase();
    const codigoTerm = $('#codigo-input').val().toLowerCase();

    const filtered = clientes.filter(cliente => {

        const razao = (cliente.razao_social || '').toLowerCase();
        const apelido = (cliente.apelido || '').toLowerCase();
        const codigo = (cliente.codigo || '').toLowerCase();

        return (razao.includes(razaoTerm) || razaoTerm === '') &&
               (apelido.includes(apelidoTerm) || apelidoTerm === '') &&
               (codigo.includes(codigoTerm) || codigoTerm === '');

    });

    const suggestionsDiv = $('#client-suggestions');
    suggestionsDiv.empty();

    if (filtered.length > 0) {

        filtered.forEach(cliente => {

            const div = $('<div class="p-2 border-bottom suggestion-item" style="cursor:pointer;"></div>');

            div.text(`${cliente.razao_social} - ${cliente.apelido || ''} - ${cliente.codigo || ''}`);

            div.on('click', function() {
                selecionarCliente(cliente);
            });

            suggestionsDiv.append(div);

        });

    } else {

        suggestionsDiv.html('<p class="text-muted">Nenhum cliente encontrado.</p>');

    }
}

function selecionarCliente(cliente) {

    clienteSelecionado = cliente;

    $('#cliente-selecionado').text(`Cliente selecionado: ${cliente.razao_social} - ${cliente.apelido || ''} - ${cliente.codigo || ''}`);

    $('#id_cliente').val(cliente.id);

    $('#produto-select').prop('disabled', false);
    $('#adicionar-produto-btn').prop('disabled', false);

    $('#client-suggestions').empty();

    validarFormularioPedido();
}

function adicionarProdutoCarrinho() {

    if (!clienteSelecionado) {
        alert('Selecione um cliente primeiro.');
        return;
    }

    const select = document.getElementById('produto-select');
    const id = parseInt(select.value);

    if (!id) return;

    const produtoOriginal = produtos.find(p => parseInt(p.id) === id);

    if (!produtoOriginal) return;

    if (carrinho.find(p => p.id === id)) {
        alert('Produto já está no carrinho!');
        return;
    }

    const produto = {
        id: parseInt(produtoOriginal.id),
        nome: produtoOriginal.nome,
        descricao: produtoOriginal.descricao || '',
        quantidade_por_caixa: produtoOriginal.quantidade_por_caixa || '-',
        imagem: produtoOriginal.imagem || null,
        preco: parseFloat(produtoOriginal.preco),
        estoque: parseInt(produtoOriginal.estoque) || 0,
        quantidade: 1
    };

    if (produto.estoque <= 0) {
        alert('Produto sem estoque disponível.');
        return;
    }

    carrinho.push(produto);

    atualizarCarrinho();

    select.value = '';
}

function alterarQuantidade(id, delta) {

    id = parseInt(id);

    const item = carrinho.find(p => p.id === id);

    if (!item) return;

    item.quantidade += delta;

    if (item.quantidade < 1) item.quantidade = 1;

    if (item.quantidade > item.estoque) {
        item.quantidade = item.estoque;
        alert('Quantidade limitada pelo estoque disponível.');
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
            <input type="hidden" name="produtos[${produto.id}]" value="${produto.quantidade}">
            <div class="d-flex align-items-center flex-wrap gap-2">
                ${produto.imagem ? `<img src="/images/${produto.imagem}" class="rounded" style="width:40px;height:40px;object-fit:cover;">` : ''}
                <div>
                    <strong>${produto.nome}</strong>
                    <div class="small">Qtd/Caixa: ${produto.quantidade_por_caixa}</div>
                </div>
            </div>
        </td>

        <td class="text-nowrap">
            R$ ${produto.preco.toFixed(2).replace('.', ',')}
        </td>

        <td>
            <div class="input-group input-group-sm flex-nowrap" style="max-width:120px;">
                <button type="button" class="btn btn-outline-secondary btn-sm"
                onclick="alterarQuantidade(${produto.id}, -1)">-</button>

                <input type="number" class="form-control form-control-sm text-center"
                value="${produto.quantidade}" readonly>

                <button type="button" class="btn btn-outline-secondary btn-sm"
                onclick="alterarQuantidade(${produto.id}, 1)">+</button>
            </div>
        </td>

        <td class="text-nowrap">
            R$ ${subtotal.toFixed(2).replace('.', ',')}
        </td>

        <td>
            <button type="button" class="btn btn-danger btn-sm"
            onclick="removerProdutoCarrinho(${produto.id})">
            Remover
            </button>
        </td>
        `;

        tbody.appendChild(tr);

    });

    document.getElementById('total').textContent =
        'R$ ' + total.toFixed(2).replace('.', ',');

    validarFormularioPedido();
}

function validarFormularioPedido() {

    const pagamento = document.getElementById('metodo_pagamento').value;

    if (!clienteSelecionado) {
        document.getElementById('criar-pedido-btn').disabled = true;
        return;
    }

    if (carrinho.length === 0) {
        document.getElementById('criar-pedido-btn').disabled = true;
        return;
    }

    if (pagamento === "") {
        document.getElementById('criar-pedido-btn').disabled = true;
        return;
    }

    document.getElementById('criar-pedido-btn').disabled = false;
}
</script>


</body>
</html>