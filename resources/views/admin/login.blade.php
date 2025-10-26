<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login Básica</title>
    <link rel="stylesheet" href="/css/app.css">
</head>

<body>
    <div class="login-container">
        <form class="login-form" action="{{ route('fazer_login') }}" method="POST">

            @csrf

            <h2>Login</h2>

            <div class="input-group">
                <label for="username">Usuário (ou E-mail)</label>
                <input type="text" id="username" name="email" required>
            </div>

            <div class="input-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="senha" required>
            </div>

            <button type="submit">Entrar</button>

            <div class="links">
                <a href="#">Esqueci minha senha</a>
                <a href="#">Criar conta</a>
            </div>
        </form>
    </div>
</body>

</html>