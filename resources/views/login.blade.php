<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Flowbite CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    
    <!-- Configuração de Cores do Tailwind (para o Laranja) -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        orange: {
                            '50': '#fff7ed',
                            '100': '#ffedd5',
                            '200': '#fed7aa',
                            '300': '#fdbf84',
                            '400': '#fdbd70',
                            '500': '#f97316',
                            '600': '#ea580c',
                            '700': '#c2410c',
                            '800': '#9a3412',
                            '900': '#7c2d12',
                            '950': '#431407',
                        },
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    @if (session('success'))
        <div id="toast-success" 
             class="fixed top-5 right-5 z-50 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow" 
             role="alert">
            
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
                <span class="sr-only">Check icon</span>
            </div>

            <div class="ms-3 text-sm font-normal">{{ session('success') }}</div>

            <button type="button" 
                    class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8" 
                    data-dismiss-target="#toast-success" 
                    aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    <!-- Container Principal -->
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            
            <!-- Card de Login -->
            <div class="bg-white p-6 sm:p-8 rounded-lg shadow-lg">
                
                <!-- Cabeçalho -->
                <div class="text-center mb-8">
                    <img src="{{ asset('storage/asset/logo3.png') }}" class='mx-auto w-24 h-24' alt="EasyWalk Logo">
                    <h2 class="mt-4 text-2xl font-bold tracking-tight text-gray-900">
                        Login de Usuário
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Acesse a usa conta!
                    </p>
                </div>

                <!-- Formulário de Login -->
                <form class="space-y-6" action="{{ route('logar') }}" method="POST">
                    @csrf <!-- Token de proteção do Laravel -->

                    <!-- Mensagem de Erro Principal (Credenciais inválidas) -->
                    <!-- O controller retorna o erro na chave 'email' -->
                    @error('email')
                        @if ($message === 'As credenciais fornecidas não correspondem aos nossos registros.')
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                                <span class="font-medium">Erro de autenticação:</span> {{ $message }}
                            </div>
                        @endif
                    @enderror

                    <!-- Campo de Email -->
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Seu e-mail | número | CPF</label>
                        <input type="email" name="email" id="email" 
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5" 
                               placeholder="nome@dominio.com | (00) 0 0000-0000 | 000.000.000-00" required value="{{ old('email') }}">
                        
                        <!-- Mensagem de Erro Específica (Ex: 'email é obrigatório') -->
                        @error('email')
                            @if ($message !== 'As credenciais fornecidas não correspondem aos nossos registros.')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @endif
                        @enderror
                    </div>

                    <!-- Campo de Senha -->
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Sua senha</label>
                        <input type="password" name="password" id="password" 
                               placeholder="••••••••" 
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5" 
                               required>
                        
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lembrar-me e Esqueceu Senha -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="remember" name="remember" type="checkbox" 
                                       class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-orange-300">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="remember" class="text-gray-500">Lembrar-me</label>
                            </div>
                        </div>
                        <a href="#" class="text-sm text-orange-600 hover:underline">Esqueceu a senha?</a> <br>
                        <a href="{{ route('cadastro') }}" class="text-sm text-orange-600 hover:underline">Cadastre-se</a>
                    </div>

                    <!-- Botão de Envio -->
                    <button type="submit" 
                            class="w-full text-white bg-orange-600 hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition duration-150 ease-in-out">
                        Entrar
                    </button>
                    
                </form>
            </div>
            
            <p class="text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.
            </p>
        </div>
    </div>

    <!-- Flowbite JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>
</html>