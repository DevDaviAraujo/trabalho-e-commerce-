@extends('admin.index')
@section('conteudo')
<div class="container my-5">

    {{-- CABEÇALHO: Título e Botões de Ação --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <div>
            <h1 class="h2 mb-0">{{ $oferta->descricao }}</h1>
            <small class="text-muted">
                {{-- Usando o helper getDesconto() do seu Model --}}
                Desconto: {{ $oferta->getDesconto() }}
            </small>
        </div>
        
        <div class="d-flex justify-content-end gap-2 mt-3 mt-md-0">
            {{-- Ajuste a rota 'ofertas' conforme o nome da sua rota de listagem --}}
            <a href="{{ route('ofertas') }}" 
               class="btn btn-outline-secondary rounded-pill d-inline-flex align-items-center justify-content-center"
               title="Voltar para a lista">
                <i class="bi bi-arrow-left me-1"></i>
                Voltar
            </a>
            
            {{-- Ajuste para sua rota de edição de oferta --}}
            <a href="{{ route('oferta_edicao', ['id' => $oferta->id]) }}"
               class="btn btn-warning rounded-circle d-inline-flex align-items-center justify-content-center"
               style="width: 42px; height: 42px;" title="Editar">
                <i class="bi bi-pencil-square text-white"></i>
            </a>

            {{-- Ajuste para sua rota de deleção de oferta --}}
            <a href="{{ route('oferta_deletar', ['id' => $oferta->id]) }}"
               class="btn btn-danger rounded-circle d-inline-flex align-items-center justify-content-center"
               style="width: 42px; height: 42px;" title="Excluir"
               onclick="return confirm('Tem certeza que deseja excluir esta oferta?');">
                <i class="bi bi-trash text-white"></i>
            </a>
        </div>
    </div>

    <hr class="mb-4">

    <div class="row g-4 g-lg-5">

        {{-- COLUNA DA ESQUERDA: Mídia da Oferta --}}
        <div class="col-lg-6">
            @if($oferta->media)
                <div class="rounded border shadow-sm p-1">
                    @if(Str::startsWith($oferta->media->file_type, 'image/'))
                        <img src="{{ $oferta->media->getDir() }}" 
                             alt="Mídia da oferta" 
                             class="img-fluid rounded"
                             style="width: 100%; object-fit: cover;">
                    @elseif(Str::startsWith($oferta->media->file_type, 'video/'))
                        <video controls 
                               class="img-fluid rounded" 
                               style="width: 100%; object-fit: cover;">
                            <source src="{{ $oferta->media->getDir() }}" type="{{ $oferta->media->file_type }}">
                            Seu navegador não suporta vídeo.
                        </video>
                    @endif
                </div>
            @else
                <div class="d-flex align-items-center justify-content-center bg-light border rounded" 
                     style="height: 200px; min-height: 300px;">
                    <span class="text-muted">Oferta sem mídia</span>
                </div>
            @endif
        </div>

        {{-- COLUNA DA DIREITA: Detalhes da Oferta --}}
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-4 p-lg-5">

                    <h3 class="card-title text-primary mb-3" style="font-size: 2.5rem; font-weight: 300;">
                        {{-- Destaque para o valor do desconto --}}
                        {{ $oferta->getDesconto() }}
                    </h3>

                    <h5 class="mb-4">
                        <span class="badge bg-info-subtle text-info-emphasis rounded-pill fs-6">
                            <i class="bi bi-tag me-1"></i>
                            {{-- Contagem de produtos vinculados --}}
                            Aplicável a {{ $oferta->produtos->count() }} {{ Str::plural('produto', $oferta->produtos->count()) }}
                        </span>
                    </h5>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <strong>Tipo de Desconto</strong>
                            <span class="text-capitalize">{{ $oferta->tipo_desconto }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <strong>Valor</strong>
                            <span>
                                {{-- Mostra o valor bruto --}}
                                @if($oferta->tipo_desconto == 'porcentagem')
                                    {{ number_format($oferta->valor_desconto, 2, ',', '.') }} %
                                @else
                                    R$ {{ number_format($oferta->valor_desconto, 2, ',', '.') }}
                                @endif
                            </span>
                        </li>
                         <li class="list-group-item d-flex justify-content-between px-0">
                            <strong>Cadastrada em</strong>
                            <span>{{ $oferta->created_at->format('d/m/Y \à\s H:i') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <strong>Última Atualização</strong>
                            <span>{{ $oferta->updated_at->format('d/m/Y \à\s H:i') }}</span>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>

    {{-- SEÇÃO INFERIOR: Tabela de Produtos Vinculados --}}
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0 p-4 pb-0 rounded-top-4">
                    <h4 class="mb-0">Produtos Incluídos na Oferta</h4>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nome</th>
                                    <th>Código (SKU)</th>
                                    <th>Preço Original</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($oferta->produtos as $produto)
                                    <tr>
                                        <td>{{ $produto->nome }}</td>
                                        <td>{{ $produto->codigo ?? 'N/A' }}</td>
                                        <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-3">
                                            Nenhum produto vinculado a esta oferta.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection