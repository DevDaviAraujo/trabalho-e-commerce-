@extends('admin.index')

@section('conteudo')

    <div class="container my-5">
        <div class="card shadow-sm border-0 rounded-4 mx-auto" style="max-width: 900px;">
            <div class="card-header bg-white py-3 px-4 border-0 rounded-top-4">
                {{-- ... (Seu cabeçalho do card - Título e botão Voltar) ... --}}
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0 text-dark">
                        @isset($produto)
                            <i class="bi bi-pencil-square me-2"></i>
                            Editar Produto
                        @else
                            <i class="bi bi-plus-circle me-2"></i>
                            Cadastrar Novo Produto
                        @endisset
                    </h2>
                    <a href="{{ route('produtos') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-1"></i>
                        Voltar para Lista
                    </a>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">

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



                @if(isset($produto) && $produto->medias->count() > 0)
                    <div class="mb-3">
                        <label class="form-label">Arquivos Existentes</label>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach($produto->medias as $media)
                                <div class="position-relative" style="width: 150px;">
                                    @if(Str::startsWith($media->file_type, 'image/'))
                                        <img src="{{ $media->getDir() }}" alt="Imagem do produto" class="img-fluid rounded border"
                                            style="height: 120px; object-fit: cover;">
                                    @elseif(Str::startsWith($media->file_type, 'video/'))
                                        <video controls class="rounded border" width="150" height="120" style="object-fit: cover;">
                                            <source src="{{ $media->getDir() }}" type="{{ $media->file_type }}">
                                            Seu navegador não suporta vídeo.
                                        </video>
                                    @endif

                                    <form action="{{ route('media.delete', $media->id) }}" method="POST"
                                        class="position-absolute top-0 end-0">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger rounded-circle" style="padding: 2px 6px;"
                                            onclick="return confirm('Tem certeza?');">×</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                <hr class="my-4"> @endif


                @livewire('produto-formulario')
            </div>
        </div>
    </div>
@stack('scripts')

@endsection