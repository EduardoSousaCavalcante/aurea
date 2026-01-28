<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NewsGeek</title>
    <link rel="icon" type="image/png" href="{{ asset('ico.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/media.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar bg-light shadow-lg d-flex p-3 justify-content-between">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <a class="navbar-brand font-weight-bold justify-content-between fs-2" href="#">News<span class="text-purple">Geek</span>!</a>
                <button id="temaBotao" class="btn btn-outline-secondary ms-3">
                    <i id="temaIcon" class="bi bi-moon-fill"></i>
                </button>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-2">
                        <a class="nav-link font-weight-bold btn btn-purple" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link font-weight-bold btn btn-outline-purple" href="#">Anime</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link font-weight-bold btn btn-outline-purple" href="#">Manga</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link font-weight-bold btn btn-outline-purple" href="#">Novels</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link font-weight-bold btn btn-purple" href="{{ route('dev.index') }}">Área Dev</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Carousel -->
    <div id="carouselExampleCaptions" class="carousel slide mb-5" data-bs-ride="carousel" style="max-width: 1340px; margin: 0 auto;">
        <div class="carousel-inner">
            @foreach($carousels as $key => $carousel)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <img src="{{ asset('images/' . $carousel->imagem) }}" class="d-block w-100" alt="{{ $carousel->titulo }}">
                <div class="carousel-caption d-none d-md-block">
                    <h5>{{ $carousel->titulo }}</h5>
                    <p>{{ $carousel->descricao }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- Cards mais visualizados -->
    <section class="m-4">
        <div class="container">
            <p class="fs-4">Mais Populares</p>
            <div class="row">
                @foreach($mostViewedCards as $card)
                <div class="col-12 col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 d-flex flex-column">
                        <img src="{{ asset('images/' . $card->img) }}" class="card-img-top" alt="{{ $card->titulo }}">
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $card->titulo }}</h5>
                            <p class="card-text">{{ $card->descricao }}</p>

                            <div class="d-flex justify-content-between align-items-center mt-auto mb-1">
                                <a class="btn btn-purple" target="_blank">Ver mais</a>
                                <div>
                                    <i class="bi bi-heart-fill text-danger me-2"></i>{{ $card->curtidas }}
                                    <i class="bi bi-eye ms-3"></i> {{ $card->views }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Cards cronológicos -->
    <section class="m-4">
        <div class="container">
            <p class="fs-4">Ultimos Adicionados</p>
            <div class="row">
                @foreach($cards as $card)
                <div class="col-12 col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 d-flex flex-column">
                        <img src="{{ asset('images/' . $card->img) }}" class="card-img-top" alt="{{ $card->titulo }}">
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $card->titulo }}</h5>
                            <p class="card-text">{{ $card->descricao }}</p>

                            <div class="d-flex justify-content-between align-items-center mt-auto mb-1">
                                <a class="btn btn-purple" target="_blank">Ver mais</a>
                                <div>
                                    <i class="bi bi-heart-fill text-danger me-2"></i>{{ $card->curtidas }}
                                    <i class="bi bi-eye ms-3"></i> {{ $card->views }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const botaoTema = document.getElementById('temaBotao');
        const temaIcon = document.getElementById('temaIcon');
        const body = document.body;
        const navbar = document.querySelector('.navbar');

        // Aplica o tema salvo no localStorage
        if(localStorage.getItem('tema') === 'escuro'){
            body.classList.add('dark-mode');
            navbar.classList.add('dark-mode');
            temaIcon.classList.remove('bi-moon-fill');
            temaIcon.classList.add('bi-sun-fill');
        }

        botaoTema.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            navbar.classList.toggle('dark-mode');

            if(body.classList.contains('dark-mode')){
                localStorage.setItem('tema', 'escuro');
                temaIcon.classList.remove('bi-moon-fill');
                temaIcon.classList.add('bi-sun-fill');
            } else {
                localStorage.setItem('tema', 'claro');
                temaIcon.classList.remove('bi-sun-fill');
                temaIcon.classList.add('bi-moon-fill');
            }
        });

    </script>
</body>
</html>