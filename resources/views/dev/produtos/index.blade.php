<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manter Produtos</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="bg-light">

<div class="container mt-5">

<div class="d-flex align-items-center mb-4">
<h2 class="me-3">Manter Produtos</h2>

<a href="{{ route('produtos.create') }}" class="btn btn-success">
Adicionar Produto
</a>

<a href="{{ route('dev.index') }}" class="btn btn-secondary">
Voltar
</a>

</div>

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<table class="table table-bordered bg-white">

<thead>

<tr>
<th>ID</th>
<th>SKU</th>
<th>Nome</th>
<th>Descrição</th>
<th>Qtd/Caixa</th>
<th>Estoque</th>
<th>Preço</th>
<th>Ações</th>
</tr>

</thead>

<tbody>

@foreach($produtos as $produto)

<tr>

<td>{{ $produto->id }}</td>

<td>
<strong>{{ $produto->sku }}</strong>
</td>

<td>{{ $produto->nome }}</td>

<td>{{ $produto->descricao }}</td>

<td>{{ $produto->quantidade_por_caixa }}</td>

<td>{{ $produto->estoque }}</td>

<td>
R$ {{ number_format($produto->preco, 2, ',', '.') }}
</td>

<td>

<a href="{{ route('produtos.edit', $produto->id) }}" class="btn btn-primary btn-sm mb-2">
Editar
</a>

<form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" style="display:inline-block;">

@csrf
@method('DELETE')

<button type="submit" class="btn btn-danger btn-sm"
onclick="return confirm('Tem certeza?')">
Excluir
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