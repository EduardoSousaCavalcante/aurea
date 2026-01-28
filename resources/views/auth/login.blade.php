<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Acesso</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-sm" style="width: 100%; max-width: 400px;">
        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="text-center mb-4">
                <img src="{{ asset('google.png') }}" class="mb-2" style="width: 150px;" alt="Logo">
                <h4 class="mb-0">Fazer login</h4>
            </div>

            @if ($errors->any())
                <p class="text-center pt-2 text-danger">{{ $errors->first() }}</p>
            @endif

            <div class="mb-3">
                <label for="nomeUsuario" class="form-label">Email de Acesso</label>
                <input type="email" class="form-control" name="email" id="nomeUsuario" required>
            </div>

            <div class="mb-3">
                <label for="senhaUsuario" class="form-label">Senha</label>
                <input type="password" class="form-control" name="password" id="senhaUsuario" required>
            </div>

            <button type="submit" class="btn btn-purple w-100">Logar</button>

            <div class="text-center mt-3">
                <a href="/" class="text-decoration-none">Voltar</a>
            </div>
        </form>
    </div>
</body>
</html>
