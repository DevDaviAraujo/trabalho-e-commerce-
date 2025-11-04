<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'Painel') - {{ config('app.name', 'Admin') }}</title>

    @livewireStyles

    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="/css/app.css">

    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100 bg-light">

    <header>
        <nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ url('/admin') }}">
                    {{ config('app.name', 'Admin') }}
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">

                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('users*') ? 'active' : '' }}"
                                href="{{ route('users') }}">
                                <i class="bi bi-people me-1"></i> Usuários
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('categorias*') ? 'active' : '' }}"
                                href="{{ route('categorias') }}">
                                <i class="bi bi-tags me-1"></i>
                                Categorias
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('subcategorias*') ? 'active' : '' }}"
                                href="{{ route('subcategorias') }}">
                                <i class="bi bi-diagram-3 me-1"></i>
                                Subcategorias
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('produtos*') ? 'active' : '' }}"
                                href="{{ route('produtos') }}">
                                <i class="bi bi-box-seam me-1"></i>
                                Produtos
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('ofertas*') ? 'active' : '' }}"
                                href="{{ route('ofertas') }}"> <i class="bi bi-cash-coin me-1"></i> Ofertas
                            </a>
                        </li>

                        <li class="nav-item">
                            <form action="{{ route('deslogar') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link text-danger">
                                    <i class="bi bi-box-arrow-right me-1"></i>
                                    Deslogar
                                </button>
                            </form>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main role="main" class="flex-grow-1">
        @yield('conteudo')
    </main>

    <footer class="footer mt-auto py-3 bg-white border-top">
        <div class="container text-center">
            <span class="text-muted">
                © {{ date('Y') }} {{ config('app.name', 'Sua Empresa') }}. Todos os direitos reservados.
            </span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    @stack('scripts')

    @livewireScripts

</body>

</html>