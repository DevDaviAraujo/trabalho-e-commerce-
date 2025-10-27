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
        <form id="loginForm" class="login-form" action="{{ route('fazer_login') }}" method="POST">
            @csrf

            <h2>Login</h2>

            <div class="input-group">
                <label for="username">Usuário (ou E-mail)</label>
                <input type="text" id="username" name="email" required>
            </div>

            <div class="input-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div id="loginMessage"></div>
            <button type="submit">Entrar</button>

            <div class="links">
                <a href="#">Esqueci minha senha</a>
                <a href="#">Criar conta</a>
            </div>
        </form>

        <script>
            document.getElementById('loginForm').addEventListener('submit', async function (e) {
                e.preventDefault();

                const form = e.target;
                const formData = new FormData(form);
                const messageDiv = document.getElementById('loginMessage');
                messageDiv.innerHTML = '';

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json',
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        messageDiv.innerHTML = `
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Login realizado com sucesso! Redirecionando...
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;
                        setTimeout(() => window.location.href = data.redirect, 1000);
                    } else {
                        messageDiv.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ${data.message || 'Credenciais inválidas.'}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;
                    }
                } catch (err) {
                    console.error(err);
                    messageDiv.innerHTML = `
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                Erro de conexão. Tente novamente mais tarde.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
                }
            });

        </script>


    </div>
</body>

</html>