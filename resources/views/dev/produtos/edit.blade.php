<div class="container">
    <h1>Editar Produto</h1>
    <form action="{{ route('produtos.update', $produto) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" value="{{ $produto->nome }}" required>
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea name="descricao" id="descricao" class="form-control" required>{{ $produto->descricao }}</textarea>
        </div>
        <div class="mb-3">
            <label for="quantidade_por_caixa" class="form-label">Quantidade por Caixa</label>
            <input type="number" name="quantidade_por_caixa" id="quantidade_por_caixa" class="form-control" value="{{ $produto->quantidade_por_caixa }}" required min="1">
        </div>
        <div class="mb-3">
            <label for="preco" class="form-label">Preço</label>
            <input type="number" name="preco" id="preco" class="form-control" value="{{ $produto->preco }}" required step="0.01" min="0">
        </div>
        <div class="mb-3">
            <label for="imagem" class="form-label">Imagem (opcional)</label>
            <input type="file" name="imagem" id="imagem" class="form-control" accept="image/*">
            <small class="text-muted">Se não selecionar, a imagem atual será mantida.</small>
            @if($produto->imagem)
                <img src="/images/{{ $produto->imagem }}" alt="Imagem do Produto" width="100" class="mt-2">
            @endif
        </div>
        <button type="submit" class="btn btn-success">Atualizar</button>
        <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
