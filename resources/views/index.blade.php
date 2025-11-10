<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyWalk</title>
    {{-- 
      Corrigido: Use o helper asset() para carregar o CSS da sua pasta 'public/css'
      Seu arquivo home.css deve estar em 'public/css/home.css'
    --}}
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

{{-- Adicionei classes do Tailwind aqui para um layout de página inteira (full height) --}}
<body class="flex flex-col min-h-screen">
    
    {{-- A classe 'navegar' vem do seu home.css, as outras são Tailwind --}}
    <nav class="navegar flex items-center justify-between">
        <!-- 🔸 ESQUERDA: logo + usuário -->
        <div class="nav-esquerda flex items-center gap-4">
            <!-- LOGO -->
            {{-- 
              Corrigido: Use o helper asset() 
              Sua logo deve estar em 'public/storage/asset/logo3.png' (ou ajuste o caminho)
            --}}
            <img src="{{ asset('storage/asset/logo3.png') }}" id="logo3" alt="EasyWalk Logo" class="h-16 w-16">

            <!-- ÍCONE USUÁRIO -->
            <div class="usuario">
                <a href="formulario.html">
                    <svg class="w-10 h-10 text-black hover:text-white transition-transform transform hover:scale-110 cursor-pointer"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- 🔸 CENTRO: links -->
        <div class="nav-links hidden md:flex items-center gap-8 text-black">
            <a href="nossos_produtos.html" class="hover:text-white">Nossos Produtos</a>

            <!-- Dropdown categoria -->
            <!-- Botão -->
            <button id="dropdownButton" data-dropdown-toggle="dropdownMenu"
                class="botao flex items-center gap-1 text-black hover:text-white">
                Categoria
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M1 1l4 4 4-4" />
                </svg>
            </button>

            <!-- Menu -->
            <div id="dropdownMenu" class="z-50 hidden bg-white divide-y divide-black-100 rounded-lg shadow w-30">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownButton">
                    <li>
                        {{-- Você pode popular isso dinamicamente com @foreach --}}
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Subcategoria</a>
                    </li>
                </ul>
            </div>


            <a href="sobre_nos.html" class="hover:text-white">Sobre Nós</a>
            <a href="fale.html" class="hover:text-white">Fale Conosco</a>
        </div>

        <!-- 🔸 DIREITA: carrinho + menu mobile -->
        <div class="nav-direita flex items-center gap-4">
            <a href="carrinho.html" class="link-carrinho">
                {{-- 
                  Corrigido: Use o helper asset() 
                  Seu ícone deve estar em 'public/storage/asset/carrinho2.png' (ou ajuste o caminho)
                --}}
                <img src="{{ asset('storage/asset/carrinho2.png') }}" class="carrinho2 w-8" alt="Carrinho">
            </a>

            <button id="menu-toggle" class="menu-toggle md:hidden text-black text-3xl">☰</button>
        </div>
    </nav>

    {{-- 
      Corrigido: Use 'flex-grow' do Tailwind para empurrar o footer para baixo
      O @yield('conteudo') é onde o 'home.blade.php' será injetado
    --}}
    <main role="main" class="flex-grow">
        @yield('conteudo')
    </main>

    {{-- A classe 'footer' vem do seu home.css --}}
    <footer class="footer">
        <div class="footer-container">

            <!-- Informações principais -->
            <div class="footer-section">
                <p>© 2025 EasyWalk - Todos os direitos reservados</p>
                <p>CNPJ: 00.000.000/0000-00</p>
            </div>

            <!-- Contato -->
            <div class="footer-section">
                <h4>Contato</h4>
                <p>📷 Instagram: <a href="#">@easywalk</a></p>
                <p>💬 WhatsApp: <a href="#">(11) 99999-9999</a></p>
                <p>✉️ E-mail: <a href="mailto:contato@easywalk.com">contato@easywalk.com</a></p>
            </div>

            <!-- Pagamentos -->
            <div class="footer-section">
                <h4>Formas de Pagamento</h4>
                <p>💳 Cartão de crédito / débito</p>
                <p>🏦 Pix / Boleto bancário</p>
            </div>

            <!-- Endereço -->
            <div class="footer-section">
                <h4>Endereço</h4>
                <p>Rua Exemplo, 123 - Centro</p>
                <p>São Paulo - SP, 01000-000</p>
            </div>
        </div>
    </footer>

    {{-- Corrigido: Scripts devem ser carregados no final do body --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script>
        // Controle do menu em telas pequenas
        const toggle = document.getElementById('menu-toggle');
        const links = document.querySelector('.nav-links'); // <-- usa a classe!

        toggle.addEventListener('click', () => {
            links.classList.toggle('ativo');
        });
    </script>

</body>

</html>