@extends('admin.index')

@section('conteudo')

    <div class="container my-5">
        <div class="card shadow-sm border-0 rounded-4 mx-auto" style="max-width: 900px;">
            <div class="card-header bg-white py-3 px-4 border-0 rounded-top-4">
                {{-- Cabeçalho do Card: Título e Botão Voltar --}}
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0 text-dark">
                        @isset($oferta)
                            <i class="bi bi-pencil-square me-2"></i>
                            Editar Oferta
                        @else
                            <i class="bi bi-plus-circle me-2"></i>
                            Cadastrar Nova Oferta
                        @endisset
                    </h2>
                    {{-- Ajuste a rota 'ofertas' conforme o nome da sua rota de listagem --}}
                    <a href="{{ route('ofertas') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-1"></i>
                        Voltar para Lista
                    </a>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">

                {{-- Alertas de Sucesso e Erro --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('cadastrar_oferta') }}" method="POST" enctype="multipart/form-data">
                    @csrf


                    @isset($oferta)
                        <input type="hidden" name="id" value="{{ $oferta->id }}">
                    @endisset


                    @php
                        $produtosSelecionados = old('produtos', $oferta ? $oferta->produtos->pluck('id')->toArray() : []);
                        $tipoSelecionado = old('tipo_desconto', $oferta->tipo_desconto ?? 'porcentagem');
                    @endphp

                    <div class="row g-3">

                        <div class="col-12">
                            <label for="media" class="form-label">
                                @isset($oferta) Adicionar novas mídias @else Mídias da oferta @endisset
                            </label>
                            <input type="file" class="form-control rounded-3 @error('media') is-invalid @enderror"
                                id="media" name="media">
                            @error('media')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="descricao" class="form-label">Descrição da Oferta</label>
                            <input type="text" class="form-control rounded-3 @error('descricao') is-invalid @enderror"
                                id="descricao" name="descricao" value="{{ old('descricao', $oferta->descricao ?? '') }}"
                                required>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="tipo_desconto" class="form-label">Tipo de Desconto</label>
                            <select class="form-select rounded-3 @error('tipo_desconto') is-invalid @enderror"
                                id="tipo_desconto" name="tipo_desconto" required>
                                <option value="porcentagem" {{ $tipoSelecionado == 'porcentagem' ? 'selected' : '' }}>
                                    Porcentagem (%)
                                </option>
                                <option value="unitario" {{ $tipoSelecionado == 'unitario' ? 'selected' : '' }}>
                                    Valor Fixo (R$)
                                </option>
                            </select>
                            @error('tipo_desconto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="valor_desconto" class="form-label">Valor do Desconto</label>
                            <input type="number"
                                class="form-control rounded-3 @error('valor_desconto') is-invalid @enderror"
                                id="valor_desconto" name="valor_desconto" step="0.01" min="0"
                                value="{{ old('valor_desconto', $oferta->valor_desconto ?? '') }}" placeholder="0,00"
                                >
                            @error('valor_desconto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mt-4">
                            <label class="form-label fw-semibold">Selecionar Produtos</label>
                            @livewire('selecionar-produtos', ['produtosSelecionados' => $produtosSelecionados ?? []])
                        </div>


                    </div>
                    <hr class="my-4">

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5">
                            @isset($oferta)
                                <i class="bi bi-check-circle me-1"></i>
                                Atualizar Oferta
                            @else
                                <i class="bi bi-check-circle me-1"></i>
                                Salvar Oferta
                            @endisset
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection