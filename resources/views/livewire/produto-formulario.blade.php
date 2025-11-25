<div>
    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($errors->has('imagens.*'))
        @foreach ($errors->get('imagens.*') as $messages)
            @foreach ($messages as $message)
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @endforeach
        @endforeach
    @endif


    <form wire:submit.prevent="save" enctype="multipart/form-data">

        <div class="row g-3">

            <div class="col-12">
                <label for="imagens" class="form-label">
                    @isset($produto) Adicionar novas mídias @else Mídias do Produto @endisset
                </label>
                <input type="file" multiple accept=".jpg,.jpeg,.png,.webp,.avif" class="form-control rounded-3 @error('imagens') is-invalid @enderror" id="imagens"
                    wire:model="imagens" multiple {{ !isset($produtoId) ? 'required' : '' }}>
                @error('imagens')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @error('imagens.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="nome" class="form-label">Nome do Produto</label>
                <input type="text" class="form-control rounded-3 @error('nome') is-invalid @enderror" wire:model="nome"
                    required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Categoria</label>
                <select wire:model="categoria_id" wire:change="chamaSubCategoria($event.target.value)"
                    class="form-select" required>
                    <option value="">Selecione...</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->descricao }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Sub-Categoria</label>
                <select wire:model="sub_categoria_id" class="form-select" required>
                    <option value="">Selecione...</option>
                    @foreach($subcategorias as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->descricao }}</option>
                    @endforeach
                </select>
            </div>


            <div class="col-12">
                <label class="form-label">Descrição</label>

                <div wire:ignore>
                    <input id="descricao-trix" type="hidden" wire:model.live="descricao" value="{!! $descricao !!}">
                    <trix-editor input="descricao-trix"></trix-editor>
                </div>


                @error('descricao')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            @push('scripts')
                <script>
                    document.addEventListener('trix-change', function (event) {
                        @this.set('descricao', event.target.value);
                    });
                </script>
            @endpush


            <div class="col-md-4">
                <label for="codigo" class="form-label">Código (SKU)</label>
                <input type="text" class="form-control rounded-3 @error('codigo') is-invalid @enderror"
                    wire:model="codigo">
            </div>

            <div class="col-md-4">
                <label for="modelo" class="form-label">Modelo</label>
                <input type="text" class="form-control rounded-3 @error('modelo') is-invalid @enderror"
                    wire:model="modelo">
            </div>

            <div class="col-md-4">
                <label class="form-label">Tamanhos</label>
                @foreach($tamanhos as $index => $size)
                    <div class="d-flex mb-2">
                        <input type="text" wire:model="tamanhos.{{ $index }}" class="form-control me-2"
                            placeholder="Ex: P, M, 42...">
                        <button type="button" wire:click="removeTamanho({{ $index }})" class="btn btn-danger">-</button>
                    </div>
                @endforeach
                <button type="button" wire:click="addTamanho" class="btn btn-primary">Adicionar tamanho</button>
                @error('tamanhos.*') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-6">
                <label for="preco" class="form-label">Preço (R$)</label>
                <input type="number" class="form-control rounded-3 @error('preco') is-invalid @enderror"
                    wire:model="preco" step="0.01" min="0">
            </div>

            <div class="col-md-6">
                <label for="estoque" class="form-label">Estoque (Unidades)</label>
                <input type="number" class="form-control rounded-3 @error('estoque') is-invalid @enderror"
                    wire:model="estoque" step="1" min="0">
            </div>

        </div>

        <hr class="my-4">

        <div class="text-end">
            <button type="submit" class="btn btn-success btn-lg rounded-pill px-5">
                @isset($produto)
                    Atualizar Produto
                @else
                    Salvar Produto
                @endisset
            </button>
        </div>

    </form>

</div>