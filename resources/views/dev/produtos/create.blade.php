<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="d-flex align-items-center mb-4">
        <h2 class="me-3">Novo Produto</h2>
        <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Voltar</a>
    </div>


    <!-- Listagem de produtos com botão de adicionar ao carrinho -->
    <div class="mb-4">
        <h5>Produtos</h5>
        <div class="row" id="produtos-lista">
            @foreach(\App\Models\Produto::orderBy('nome')->get() as $produto)
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    @if($produto->imagem)
                        <img src="/images/{{ $produto->imagem }}" class="card-img-top" alt="{{ $produto->nome }}" style="height:150px;object-fit:cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $produto->nome }}</h5>
                        <p class="card-text">{{ $produto->descricao }}</p>
                        <p class="mb-1"><strong>Qtd/Caixa:</strong> {{ $produto->quantidade_por_caixa }}</p>
                        <p class="mb-1"><strong>Preço:</strong> R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
                        <div class="input-group mb-2">
                            <input type="number" class="form-control form-control-sm" min="1" value="1" id="qtd-{{ $produto->id }}">
                            <button type="button" class="btn btn-primary btn-sm" onclick="adicionarAoCarrinho({{ $produto->id }}, '{{ addslashes($produto->nome) }}', {{ $produto->preco }})">Adicionar</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Carrinho -->
    <div class="mb-4">
        <h5>Carrinho</h5>
        <ul class="list-group" id="carrinho-lista"></ul>
        <div class="mt-2"><strong>Total: R$ <span id="carrinho-total">0,00</span></strong></div>
    </div>

    <!-- Formulário de cadastro removido. Apenas seleção de produtos existentes. -->
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</script>
buscaInput.addEventListener('input', function() {
<script>
let carrinho = [];

function adicionarAoCarrinho(id, nome, preco) {
    const qtdInput = document.getElementById('qtd-' + id);
    const quantidade = parseInt(qtdInput.value);
    if (!quantidade || quantidade < 1) return;
    const existente = carrinho.find(item => item.id === id);
    if (existente) {
        existente.quantidade += quantidade;
    } else {
        carrinho.push({ id, nome, preco, quantidade });
    }
    renderCarrinho();
}

function removerDoCarrinho(idx) {
    carrinho.splice(idx, 1);
    renderCarrinho();
}

function renderCarrinho() {
    const lista = document.getElementById('carrinho-lista');
    lista.innerHTML = '';
    let total = 0;
    carrinho.forEach((item, idx) => {
        total += item.preco * item.quantidade;
        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.innerHTML = `${item.nome} <span class="badge bg-secondary">${item.quantidade} x R$ ${item.preco.toFixed(2).replace('.', ',')}</span> <button class="btn btn-danger btn-sm" onclick="removerDoCarrinho(${idx})">Remover</button>`;
        lista.appendChild(li);
    });
    document.getElementById('carrinho-total').innerText = total.toFixed(2).replace('.', ',');
}
</script>
</body>
</html>
