<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    <title>{{ config('app.name') }}</title>
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    {{-- Tailwind (se ainda não estiver no seu app.css) --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex flex-col min-h-screen bg-gray-50 px-auto"> {{-- Add: bg-gray-50 para um fundo suave --}}

    {{--
    MELHORIA 1:
    - Navbar agora é 'fixed' (sempre no topo) e tem altura fixa 'h-20' (80px).
    - 'bg-white shadow-md' dá uma aparência limpa e elevada.
    - A classe '.navegar' pode ser removida do CSS se ela só definia posição/fundo.
    --}}
    <nav
        class="navegar fixed top-0 left-0 right-0 z-50 flex items-center justify-between w-full h-20 px-4 bg-white shadow-md md:px-8">

        <div class="nav-esquerda flex items-center gap-4">

            {{-- MELHORIA 2: Logo agora é um link para a home --}}
            <a href="{{ route('home') }}"> {{-- Assumindo que 'home' é o nome da sua rota principal --}}
                <img src="{{ asset('storage/asset/logo3.png') }}" id="logo3" alt="EasyWalk Logo" class="h-16 w-16">
            </a>

            <div class="usuario relative">

                {{-- Botão do usuário (com ou sem login) --}}
                <button id="user-options" data-dropdown-toggle="dropdown-user"
                    class="flex items-center gap-2 text-black hover:text-gray-600 transition-colors md:w-auto focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-md p-1"
                    aria-expanded="false">

                    {{-- Ícone de usuário --}}
                    <svg class="w-10 h-10 text-black hover:text-gray-600 transition-colors cursor-pointer"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                            clip-rule="evenodd" />
                    </svg>

                    {{-- Nome do usuário (quando logado) --}}
                    @auth
                        <span class="font-medium">{{ Auth::user()->nome }}</span>
                    @endauth
                </button>

                {{-- Dropdown --}}
                <div id="dropdown-user"
                    class="absolute right-0 top-full mt-2 z-50 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="user-options">

                        @auth
                            {{-- Usuário autenticado --}}
                            <li>
                                <a href="{{ route('perfil') }}" class="block px-4 py-2 hover:bg-gray-100">Perfil</a>
                            </li>
                            <li>
                                <form action="{{ route('deslogar') }}" method="POST" class="block">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 hover:bg-gray-100">Deslogar</button>
                                </form>
                            </li>
                        @else
                            {{-- Visitante --}}
                            <li>
                                <a href="{{ route('login') }}" class="block px-4 py-2 hover:bg-gray-100">Entrar</a>
                            </li>
                            <li>
                                <a href="{{ route('cadastro') }}" class="block px-4 py-2 hover:bg-gray-100">Cadastrar</a>
                            </li>
                        @endauth

                    </ul>
                </div>

            </div>

        </div>

        {{--
        MELHORIA 4: Links do Menu (Desktop e Mobile)
        - 'id="navbar-links"' é o alvo do botão de toggle.
        - 'hidden' esconde no mobile.
        - 'md:flex' mostra no desktop.
        - Para o mobile, adicionamos 'absolute top-20 ...' para que ele abra *abaixo* da navbar.
        --}}
        <div id="navbar-links"
            class="hidden absolute top-20 left-0 w-full flex-col gap-4 p-4 bg-white shadow-md 
                    md:static md:flex md:w-auto md:flex-row md:items-center md:gap-8 md:p-0 md:shadow-none md:bg-transparent">

            {{-- Links de navegação --}}
            <a href="{{ url('nossos_produtos') }}" class="text-black hover:text-gray-600">Nossos Produtos</a>

            <button id="dropdownButton" data-dropdown-toggle="dropdownMenu"
                class="botao flex items-center justify-between w-full text-black hover:text-gray-600 md:w-auto">
                Categoria
                <svg class="w-3 h-3 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M1 1l4 4 4-4" />
                </svg>
            </button>

            <div id="dropdownMenu" class="z-50 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownButton">
                    <li>
                        {{-- Idealmente, isso seria um loop @foreach $categorias --}}
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Subcategoria 1</a>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Subcategoria 2</a>
                    </li>
                </ul>
            </div>

            <a href="{{ url('sobre_nos') }}" class="text-black hover:text-gray-600">Sobre Nós</a>
            <a href="{{ route('fale-conosco') }}" class="text-black hover:text-gray-600">Fale Conosco</a>
        </div>


        <div class="nav-direita flex items-center gap-4">
            <a href="{{ url('carrinho') }}" class="link-carrinho">
                <img src="{{ asset('storage/asset/carrinho.png') }}" class="carrinho2 w-8" alt="Carrinho">
            </a>

            {{--
            MELHORIA 5: Botão Toggle (Hambúrguer)
            - 'data-collapse-toggle="navbar-links"' diz ao Flowbite qual 'id' controlar.
            - 'md:hidden' esconde este botão no desktop.
            --}}
            <button data-collapse-toggle="navbar-links" type="button" class="menu-toggle md:hidden text-black text-3xl"
                aria-controls="navbar-links" aria-expanded="false">
                <span class="sr-only">Abrir menu principal</span>
                ☰ {{-- Você pode trocar por um ícone SVG de menu se preferir --}}
            </button>
        </div>
    </nav>

    {{--
    CORREÇÃO PRINCIPAL:
    - Adicionado 'pt-20' (padding-top: 80px) para "empurrar" o conteúdo
    para baixo da navbar de 'h-20' (altura: 80px).
    --}}
    <main role="main" class="flex-grow pt-20">
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


    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    {{--
    MELHORIA 6: Script customizado removido!
    O Flowbite agora cuida de mostrar/esconder o menu mobile
    e o dropdown de categoria.
    --}}
    @stack('scripts')
</body>




</html>