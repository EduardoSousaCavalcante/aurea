<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <div class="container my-4">
        <div class="row justify-content-center g-4">
            <!-- Formulário -->
            <div class="col-12 col-md-6 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm d-flex flex-column p-3">
                    <h5 class="mb-3">Criar Card</h5>
                    <form action="{{ route('dev.cards.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="img">Imagem</label>
                            <input type="file" name="img" id="img" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="titulo">Título</label>
                            <input type="text" name="titulo" id="titulo" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="descricao">Descrição</label>
                            <textarea name="descricao" id="descricao" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="link">Link</label>
                            <input type="url" name="link" id="link" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Criar Card</button>
                    </form>

                </div>
            </div>

            <!-- Preview -->
            <div class="col-12 col-md-6 col-lg-3 mb-4">
                <div class="card h-100 d-flex flex-column" id="cardPreview">
                    <img src="" class="card-img-top" id="previewImg" alt="Imagem do card">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title" id="previewTitulo">Título do card</h5>
                        <p class="card-text" id="previewDescricao">Descrição do card</p>

                        <div class="d-flex justify-content-between align-items-center mt-auto mb-1">
                            <a href="#" class="btn btn-purple" id="previewLink">Ver mais</a>
                            <div>
                                <i class="bi bi-heart-fill text-danger me-2"></i>0
                                <i class="bi bi-eye-fill ms-3"></i> 0
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('cards.index') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    <script>
        const imgInput = document.getElementById('img');
        const tituloInput = document.getElementById('titulo');
        const descricaoInput = document.getElementById('descricao');
        const linkInput = document.getElementById('link');

        const previewImg = document.getElementById('previewImg');
        const previewTitulo = document.getElementById('previewTitulo');
        const previewDescricao = document.getElementById('previewDescricao');
        const previewLink = document.getElementById('previewLink');

        imgInput.addEventListener('change', () => {
            const file = imgInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImg.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });


        tituloInput.addEventListener('input', () => {
            previewTitulo.textContent = tituloInput.value || 'Título do card';
        });

        descricaoInput.addEventListener('input', () => {
            previewDescricao.textContent = descricaoInput.value || 'Descrição do card';
        });

        linkInput.addEventListener('input', () => {
            previewLink.href = linkInput.value || '#';
        });
    </script>
</body>
</html>
