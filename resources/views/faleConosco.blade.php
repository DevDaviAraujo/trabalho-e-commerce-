@extends('index')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/faleConosco.css') }}">
@endpush

@section('conteudo')

    <main class="mt-sm-40 mt-72">
        <div class="form-container">
            <h2>Fale Conosco</h2>

            @if (session('success'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                    <span class="font-medium">Sucesso!</span> {{ session('success') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                    <span class="font-medium">Erro!</span> {{ session('error') }}
                </div>
            @endif

            @if ($errors->any() && !$errors->hasAny(['nome', 'email', 'mensagem']))
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                    <span class="font-medium">Ops!</span> Houve alguns erros não esperados:
                    <ul class="mt-1.5 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form method="POST" action="{{ route('cadastrar-feedback') }}">
                @csrf
                <div class="form-group">
                    <label for="nome">Nome Completo:</label>
                    
                    <input
                        class="p-2 w-full border rounded-md @error('nome') border-red-500 @else border-gray-300 @enderror"
                        type="text" id="nome" name="nome" placeholder="Digite seu nome completo"
                        value="{{ old('nome') }}" required>

                   
                    @error('nome')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input maxlength="55"
                        class="p-2 w-full border rounded-md @error('email') border-red-500 @else border-gray-300 @enderror"
                        type="email" id="email" name="email" placeholder="Digite seu e-mail"
                        value="{{ old('email') }}" required>

                    @error('email')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="assunto">Assunto:</label>
                    <input
                        class="p-2 w-full border rounded-md @error('assunto') border-red-500 @else border-gray-300 @enderror"
                        type="assunto" id="assunto" name="assunto" placeholder="Digite o assunto"
                        value="{{ old('assunto') }}" required>

                    @error('assunto')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="mensagem">Mensagem:</label>
                    <textarea maxlength="255"
                        class="p-2 h-24 w-full border rounded-md @error('mensagem') border-red-500 @else border-gray-300 @enderror"
                        id="mensagem" name="mensagem" placeholder="Digite o mensagem do texto" required>{{ old('mensagem') }}</textarea>

                    @error('mensagem')
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <button class="botao-preto" type="submit">Enviar</button>
            </form>
        </div>
    </main>

@endsection