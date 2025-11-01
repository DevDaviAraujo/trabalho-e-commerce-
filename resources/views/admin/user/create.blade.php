@extends('admin.index')

@section('conteudo')

<div class="container my-5">

    <div class="card shadow-sm border-0 rounded-4 mx-auto" style="max-width: 900px;">

        <div class="card-header bg-white py-3 px-4 border-0 rounded-top-4">
            <div class="d-flex justify-content-between align-items-center">

                {{-- Título dinâmico (corrigido para "Usuário") --}}
                <h2 class="h5 mb-0 text-dark">
                    @isset($user)
                    <i class="bi bi-pencil-square me-2"></i>
                    Editar Usuário
                    @else
                    <i class="bi bi-person-plus me-2"></i> {{-- Ícone melhorado --}}
                    Cadastrar Novo Usuário
                    @endisset
                </h2>

                <a href="{{ route('users') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-arrow-left me-1"></i>
                    Voltar
                </a>
            </div>
        </div>

        <div class="card-body p-4 p-md-5">

            {{-- Alerta de Sucesso --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            {{-- Alerta de Erro (erro genérico do catch) --}}
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            {{-- Exibe todos os erros de validação --}}
            @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <h5 class="alert-heading">Ops! Algo deu errado.</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif



            <form action="{{ route('cadastrar_user') }}" method="POST">
                @csrf

                @isset($user)
                <input type="hidden" name="id" value="{{ $user->id }}">
                @else

                @endisset

                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="name" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control rounded-3 @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $user->name ?? '') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Campo: E-mail --}}
                    <div class="col-md-6">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control rounded-3 @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', $user->email ?? '') }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Campo: Documento --}}
                    <div class="col-md-6">
                        <label for="documento" class="form-label">Documento (CPF/CNPJ)</label>
                        <input type="text" class="form-control rounded-3 @error('documento') is-invalid @enderror" id="documento"
                            name="documento" maxlength="11" value="{{ old('documento', $user->documento ?? '') }}"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');">
                        @error('documento')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Espaçador (só para o layout de senhas ficar junto) --}}
                    <div class="col-md-6"></div>

                    {{-- Campo: Senha --}}
                    <div class="col-md-6">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control rounded-3 @error('password') is-invalid @enderror" id="password"
                            name="password"
                            {{-- Senha só é obrigatória ao criar um novo usuário --}}
                            @unless(isset($user)) required @endunless>

                        @isset($user)
                        <small class="form-text text-muted">Deixe em branco para não alterar a senha.</small>
                        @endisset

                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Campo: Confirmar Senha --}}
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                        <input type="password" class="form-control rounded-3" id="password_confirmation"
                            name="password_confirmation"
                            @unless(isset($user)) required @endunless>
                    </div>

                </div>

                <hr class="my-4">

                <div class="text-end">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5">
                        @isset($user)
                        <i class="bi bi-check-circle me-1"></i>
                        Atualizar
                        @else
                        <i class="bi bi-check-circle me-1"></i>
                        Salvar
                        @endisset
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection