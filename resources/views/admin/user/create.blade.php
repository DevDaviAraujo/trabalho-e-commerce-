@extends('admin.index')

@section('conteudo')

    <div class="container my-5">

        <div class="card shadow-sm border-0 rounded-4 mx-auto" style="max-width: 900px;">

            <div class="card-header bg-white py-3 px-4 border-0 rounded-top-4">
                <div class="d-flex justify-content-between align-items-center">

                    <h2 class="h5 mb-0 text-dark">
                        @isset($user)
                            <i class="bi bi-pencil-square me-2"></i>
                            Editar user
                        @else
                            <i class="bi bi-plus-circle me-2"></i>
                            Cadastrar Nova user
                        @endisset
                    </h2>

                    <a href="{{ route('users') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-1"></i>
                        Voltar
                    </a>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
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
                <form action="{{ Route('cadastrar_user') }}" method="POST">
                    @csrf

                    @isset($user)
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        {{-- Se for uma rota de update RESTful, adicione: @method('PUT') --}}
                    @endisset

                    <div class="row g-3">

                        <div class="col-12">
                            <label for="desc" class="form-label">Descrição</label>
                            <input type="text" class="form-control rounded-3 @error('desc') is-invalid @enderror" id="desc"
                                name="desc" value="{{ old('desc', $user->descricao ?? '') }}" required>
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
</div> @endsection