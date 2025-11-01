<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{  @config('app.name') }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        /* Garante que o container ocupe a altura total */
        html, body {
            height: 100%;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center vh-100 bg-body-tertiary">

    <main class="w-100 p-4 p-md-5 border rounded-4 bg-body shadow-sm" style="max-width: 420px;">

        <form id="loginForm" action="{{ route('logar') }}" method="POST">
            @csrf

            <h2 class="h3 mb-4 fw-normal text-center">Login</h2>

            @error('login')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Credenciais inválidas!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @enderror

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="username" name="email" 
                       placeholder="nome@exemplo.com" value="{{ old('email') }}" required>
                <label for="username">Usuário (ou E-mail)</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" 
                       placeholder="Sua senha" required>
                <label for="password">Senha</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary rounded-pill" type="submit">
                Entrar
            </button>

            <div id="loginMessage" class="mt-3"></div>

        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>