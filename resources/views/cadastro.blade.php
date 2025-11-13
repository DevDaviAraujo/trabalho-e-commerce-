@extends('index')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cadastro.css') }}">
@endpush

@section('conteudo')
    <div class="form-container w-full my-4 mx-auto">

        <h2 class="text-2xl font-bold mb-4">Cadastre-se</h2>

        @if ($errors->has('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                {{ $errors->first('error') }}
            </div>
        @endif

        @if ($errors->any() && !$errors->has('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('cadastrar_usuario') }}">
            @csrf

            {{-- Documento --}}
            <div class="form-group mb-3">
                <label for="documento">Documento</label>
                <input name="documento" id="documento" type="text" value="{{ old('documento') }}"
                    class="border rounded w-full p-2 @error('documento') border-red-500 @enderror"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="11" placeholder="00000000000"
                    required>
                @error('documento')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nome --}}
            <div class="form-group mb-3">
                <label for="nome">Nome completo</label>
                <input name="nome" id="nome" type="text" value="{{ old('nome') }}"
                    class="border rounded w-full p-2 @error('nome') border-red-500 @enderror"
                    placeholder="Digite seu nome completo" required>
                @error('nome')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- E-mail --}}
            <div class="form-group mb-3">
                <label for="email">E-mail</label>
                <input name="email" id="email" type="email" value="{{ old('email') }}"
                    class="border rounded w-full p-2 @error('email') border-red-500 @enderror"
                    placeholder="exemplo@email.com" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Telefone --}}
            <div class="form-group mb-3">
                <label for="telefone">Telefone</label>
                <input name="telefone" id="telefone" type="tel" value="{{ old('telefone') }}"
                    class="border rounded w-full p-2 @error('telefone') border-red-500 @enderror"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="11" placeholder="(00) 00000-0000"
                    required>
                @error('telefone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- CEP --}}
            <div class="form-group mb-3">
                <label for="cep">CEP</label>
                <input name="cep" id="cep" type="text" value="{{ old('cep') }}"
                    class="border rounded w-full p-2 @error('cep') border-red-500 @enderror" maxlength="8"
                    placeholder="00000-000" required>
                @error('cep')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Rua e Número --}}
            <div class="form-row flex gap-2 mb-3">
                <div class="w-3/4">
                    <label for="rua">Rua</label>
                    <input name="rua" id="rua" type="text" value="{{ old('rua') }}"
                        class="border rounded w-full p-2 @error('rua') border-red-500 @enderror"
                        placeholder="Digite o nome da rua" required>
                    @error('rua')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="w-1/4">
                    <label for="numero">Número</label>
                    <input name="numero" id="numero" type="text" value="{{ old('numero') }}"
                        class="border rounded w-full p-2 @error('numero') border-red-500 @enderror" placeholder="Nº"
                        required>
                    @error('numero')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Bairro --}}
            <div class="form-group mb-3">
                <label for="bairro">Bairro</label>
                <input name="bairro" id="bairro" type="text" value="{{ old('bairro') }}"
                    class="border rounded w-full p-2 @error('bairro') border-red-500 @enderror"
                    placeholder="Digite o bairro" required>
                @error('bairro')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Cidade e Estado --}}
            <div class="form-row flex gap-2 mb-3">
                <div class="w-3/4">
                    <label for="cidade">Cidade</label>
                    <input name="cidade" id="cidade" type="text" value="{{ old('cidade') }}"
                        class="border rounded w-full p-2 @error('cidade') border-red-500 @enderror"
                        placeholder="Digite sua cidade" required>
                    @error('cidade')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="w-1/4">
                    <label for="uf">Estado</label>
                    <select name="uf" id="uf" class="border rounded w-full p-2 @error('uf') border-red-500 @enderror"
                        required>
                        <option value="">Selecione</option>
                        @foreach (['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'] as $uf)
                            <option value="{{ $uf }}" {{ old('uf') == $uf ? 'selected' : '' }}>{{ $uf }}</option>
                        @endforeach
                    </select>
                    @error('uf')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Complemento --}}
            <div class="form-group mb-3">
                <label for="complemento">Complemento</label>
                <input name="complemento" id="complemento" type="text" value="{{ old('complemento') }}"
                    class="border rounded w-full p-2 @error('complemento') border-red-500 @enderror"
                    placeholder="Apartamento, bloco, etc." required>
                @error('complemento')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button class="button" type="submit">
                Enviar Cadastro
            </button>

        </form>
    </div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cepInput = document.getElementById('cep');
    if (!cepInput) return; // safety check

    cepInput.addEventListener('blur', async function () {
        let cep = this.value.replace(/\D/g, '');

        if (cep.length !== 8) {
            alert('Formato de CEP inválido.');
            return;
        }

        try {
            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            const data = await response.json();

            if (data.erro) {
                alert('CEP não encontrado.');
                return;
            }

            document.getElementById('rua').value = data.logradouro || '';
            document.getElementById('bairro').value = data.bairro || '';
            document.getElementById('cidade').value = data.localidade || '';
            document.getElementById('uf').value = data.uf || '';

        } catch (error) {
            alert('Erro ao consultar o CEP.');
            console.error(error);
        }
    });
});
</script>
@endpush
