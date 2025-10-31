@extends('admin.index')
@section('conteudo')
<div class="container my-5">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <div>
            <h1 class="h2 mb-0">{{ $produto->nome }}</h1>
            <small class="text-muted">
                {{ $produto->subcategoria->categoria->descricao }} / {{ $produto->subcategoria->descricao }}
            </small>
        </div>
        
        <div class="d-flex justify-content-end gap-2 mt-3 mt-md-0">
            <a href="{{ route('produtos') }}" {{-- ← Ajuste para sua rota de listagem --}}
               class="btn btn-outline-secondary rounded-pill d-inline-flex align-items-center justify-content-center"
               title="Voltar para a lista">
                <i class="bi bi-arrow-left me-1"></i>
                Voltar
            </a>
            <a href="{{ route('produto_edicao', ['id' => $produto->id]) }}"
               class="btn btn-warning rounded-circle d-inline-flex align-items-center justify-content-center"
               style="width: 42px; height: 42px;" title="Editar">
                <i class="bi bi-pencil-square text-white"></i>
            </a>
            <a href="{{ route('produto_deletar', ['id' => $produto->id]) }}"
               class="btn btn-danger rounded-circle d-inline-flex align-items-center justify-content-center"
               style="width: 42px; height: 42px;" title="Excluir"
               onclick="return confirm('Tem certeza que deseja excluir este produto?');"> {{-- Adiciona confirmação --}}
                <i class="bi bi-trash text-white"></i>
            </a>
        </div>
    </div>

    <hr class="mb-4">

    <div class="row g-4 g-lg-5">

        <div class="col-lg-6">
            @if($produto->medias->count() > 0)
                <div class="row g-3">
                    @foreach($produto->medias as $media)
                        <div class="col-6 col-md-4">
                            <div class="rounded border shadow-sm p-1">
                                @if(Str::startsWith($media->file_type, 'image/'))
                                    <img src="{{ $media->getDir() }}" 
                                         alt="Imagem do produto" 
                                         class="img-fluid rounded"
                                         style="height: 150px; width: 100%; object-fit: cover;">
                                @elseif(Str::startsWith($media->file_type, 'video/'))
                                    <video controls 
                                           class="img-fluid rounded" 
                                           style="height: 150px; width: 100%; object-fit: cover;">
                                        <source src="{{ $media->getDir() }}" type="{{ $media->file_type }}">
                                        Seu navegador não suporta vídeo.
                                    </video>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="d-flex align-items-center justify-content-center bg-light border rounded" 
                     style="height: 200px;">
                    <span class="text-muted">Produto sem imagens</span>
                </div>
            @endif
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-4 p-lg-5">

                    <h3 class="card-title text-primary mb-3" style="font-size: 2.5rem; font-weight: 300;">
                        R$ {{ number_format($produto->preco, 2, ',', '.') }}
                    </h3>

                    <h5 class="mb-4">
                        @if($produto->estoque > 0)
                            <span class="badge bg-success-subtle text-success-emphasis rounded-pill fs-6">
                                <i class="bi bi-check-circle me-1"></i>
                                {{ $produto->estoque }} unidades em estoque
                            </span>
                        @else
                            <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill fs-6">
                                <i class="bi bi-x-circle me-1"></i>
                                Fora de estoque
                            </span>
                        @endif
                    </h5>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <strong>Código (SKU)</strong>
                            <span>{{ $produto->codigo ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <strong>Modelo</strong>
                            <span>{{ $produto->modelo ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <strong>Tamanho</strong>
                            <span>{{ $produto->tamanho ?? 'N/A' }}</span>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0 p-4 pb-0 rounded-top-4">
                    <h4 class="mb-0">Descrição Detalhada</h4>
                </div>
                <div class="card-body p-4">
                    <div class="trix-content">
                        {!! $produto->descricao !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection