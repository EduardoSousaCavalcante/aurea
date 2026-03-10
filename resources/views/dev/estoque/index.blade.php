<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Controle de Estoque</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5 mb-5">

<div class="d-flex align-items-center mb-4">
<h2 class="me-3">Controle de Estoque</h2>

<a href="{{ route('dev.index') }}" class="btn btn-secondary">
Voltar
</a>
</div>

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<div class="card shadow-sm">

<div class="card-body">

<form action="{{ route('estoque.update') }}" method="POST">

@csrf

<div class="table-responsive">

<table class="table table-bordered align-middle mb-0">

<thead class="table-light">

<tr>
<th>ID</th>
<th>Produto</th>
<th>Preço</th>
<th style="width:180px;">Estoque</th>
</tr>

</thead>

<tbody>

@foreach($produtos as $produto)

<tr>

<td>{{ $produto->id }}</td>

<td>
<strong>{{ $produto->nome }}</strong>
</td>

<td class="text-nowrap">
R$ {{ number_format($produto->preco,2,',','.') }}
</td>

<td>

<input
type="number"
class="form-control"
name="estoque[{{ $produto->id }}]"
value="{{ $produto->estoque }}"
min="0"
>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

<div class="mt-3">

<button class="btn btn-success">
Salvar Alterações
</button>

</div>

</form>

</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>