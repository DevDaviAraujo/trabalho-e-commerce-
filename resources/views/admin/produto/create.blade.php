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


                <form action="{{ route('cadastrar_produto') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- O ID oculto DEVE estar DENTRO do <form> --}}
                        @isset($produto)
                            <input type="hidden" name="id" value="{{ $produto->id }}">
                        @endisset

                        @php
                            $categoriaSelecionada = old('categoria_id', $produto->subcategoria->categoria_id ?? '');
                        @endphp

                        <div class="row g-3">

                            {{-- O bloco "Arquivos Existentes" não está mais aqui --}}

                            <div class="col-12">
                                <label for="imagens" class="form-label">
                                    @isset($produto) Adicionar novas mídias @else Mídias do Produto @endisset
                                </label>
                                <input type="file" class="form-control rounded-3 @error('imagens') is-invalid @enderror"
                                    id="imagens" name="imagens[]" multiple {{-- 'required' só deve ser usado ao CRIAR --}}
                                    {{ !isset($produto) ? 'required' : '' }}>
                                @error('imagens')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('imagens.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="nome" class="form-label">Nome do Produto</label>
                                <input type="text" class="form-control rounded-3 @error('nome') is-invalid @enderror"
                                    id="nome" name="nome" value="{{ old('nome', $produto->nome ?? '') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="categoria_id" class="form-label">Categoria</label>
                                <select class="form-select rounded-3 @error('categoria_id') is-invalid @enderror"
                                    id="categoria_id" name="categoria_id" required>
                                    <option value="" disabled {{ empty($categoriaSelecionada) ? 'selected' : '' }}>
                                        Selecione...
                                    </option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ $categoriaSelecionada == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->descricao }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="sub_categoria_id" class="form-label">Sub-Categoria</label>
                                <select class="form-select rounded-3 @error('sub_categoria_id') is-invalid @enderror"
                                    id="sub_categoria_id" name="sub_categoria_id" required>
                                    <option value="">Selecione uma categoria primeiro...</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="descricao" class="form-label">Descrição</label>
                                <input id="descricao" type="hidden" name="descricao"
                                    value="{{ old('descricao', $produto->descricao ?? '') }}" required>
                                <trix-editor input="descricao"
                                    class="form-control rounded-3 @error('descricao') is-invalid @enderror">
                                </trix-editor>
                                @error('descricao')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="codigo" class="form-label">Código (SKU)</label>
                                <input type="text" class="form-control rounded-3 @error('codigo') is-invalid @enderror"
                                    id="codigo" name="codigo" value="{{ old('codigo', $produto->codigo ?? '') }}">
                            </div>

                            <div class="col-md-4">
                                <label for="modelo" class="form-label">Modelo</label>
                                <input type="text" class="form-control rounded-3 @error('modelo') is-invalid @enderror"
                                    id="modelo" name="modelo" value="{{ old('modelo', $produto->modelo ?? '') }}">
                            </div>

                            <div class="col-md-4">
                                <label for="tamanho" class="form-label">Tamanho</label>
                                <input type="text" class="form-control rounded-3 @error('tamanho') is-invalid @enderror"
                                    id="tamanho" name="tamanho" value="{{ old('tamanho', $produto->tamanho ?? '') }}"
                                    placeholder="Ex: P, M, 42...">
                            </div>

                            <div class="col-md-6">
                                <label for="preco" class="form-label">Preço (R$)</label>
                                <input type="number" class="form-control rounded-3 @error('preco') is-invalid @enderror"
                                    id="preco" name="preco" step="0.01" min="0"
                                    value="{{ old('preco', $produto->preco ?? '') }}" placeholder="0,00">
                            </div>

                            <div class="col-md-6">
                                <label for="estoque" class="form-label">Estoque (Unidades)</label>
                                <input type="number" class="form-control rounded-3 @error('estoque') is-invalid @enderror"
                                    id="estoque" name="estoque" step="1" min="0"
                                    value="{{ old('estoque', $produto->estoque ?? '') }}" placeholder="0">
                            </div>

                        </div>
                        <hr class="my-4">

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5">
                                @isset($produto)
                                    <i class="bi bi-check-circle me-1"></i>
                                    Atualizar Produto
                                @else
                                    <i class="bi bi-check-circle me-1"></i>
                                    Salvar Produto
                                @endisset
                            </button>
                        </div>

                    </form>
            </div>
        </div>
    </div> @push('scripts')
        {{-- Seu script de carregar subcategorias está correto --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const categoriaSelect = document.getElementById('categoria_id');
                const subcategoriaSelect = document.getElementById('sub_categoria_id');
                const selectedSubCategoria = "{{ old('sub_categoria_id', $produto->sub_categoria_id ?? '') }}";

                function carregarSubcategorias(categoriaId) {
                    if (!categoriaId) {
                        subcategoriaSelect.innerHTML = '<option value="">Selecione uma categoria primeiro...</option>';
                        subcategoriaSelect.disabled = true;
                        return;
                    }

                    // Ajuste a URL se necessário (ex: /admin/subcategorias-por-categoria/)
                    fetch(`/subcategorias/${categoriaId}`)
                        .then(response => {
                            if (!response.ok) throw new Error('Falha na resposta da rede');
                            return response.json();
                        })
                        .then(data => {
                            subcategoriaSelect.innerHTML = '<option value="">Selecione...</option>';
                            data.forEach(sub => {
                                const opt = document.createElement('option');
                                opt.value = sub.id;
                                opt.textContent = sub.descricao;
                                if (selectedSubCategoria == sub.id) opt.selected = true;
                                subcategoriaSelect.appendChild(opt);
                            });
                            subcategoriaSelect.disabled = false;
                        })
                        .catch(error => {
                            console.error('Erro ao carregar subcategorias:', error);
                            subcategoriaSelect.innerHTML = '<option value="">Erro ao carregar</option>';
                            subcategoriaSelect.disabled = true;
                        });
                }

                categoriaSelect.addEventListener('change', function () {
                    carregarSubcategorias(this.value);
                });

                // 🔥 Carrega as subcategorias se uma categoria já estiver selecionada
                const categoriaIdInicial = categoriaSelect.value;
                if (categoriaIdInicial) {
                    carregarSubcategorias(categoriaIdInicial);
                } else {
                    subcategoriaSelect.disabled = true;
                }
            });
        </script>
    @endpush

    @stack('scripts')
@endsection