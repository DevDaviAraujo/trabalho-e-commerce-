
<div wire:loading.class="opacity-50"> 

    @foreach($produtosSelecionados as $id)
        <input type="hidden" name="produto_id[]" value="{{ $id }}" wire:key="hidden-prod-{{ $id }}">
    @endforeach
    
    <div class="d-flex gap-3 mb-3 align-items-end">
        <div class="flex-grow-1">
            <label class="form-label">Pesquisar Produto</label>
            <input type="text" 
                   wire:model.live.debounce.500ms="search" 
                   class="form-control rounded-3" 
                   placeholder="Nome ou código..."
                   wire:loading.attr="disabled" 
            >
        </div>

        <div>
            <label class="form-label">Filtrar por Categoria</label>
            <select wire:model.live="categoria" 
                    class="form-select rounded-3"
                    wire:loading.attr="disabled" 
            >
                <option value="">Todas</option>
                @foreach($categorias as $cat)
                   
                    <option value="{{ $cat->id }}">{{ $cat->descricao }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="table-responsive border rounded-3">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 50px;">Selecionar</th>
                    <th>Nome</th>
                    <th>Código</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produtos as $produto)
                    
                    <tr wire:key="produto-{{ $produto->id }}">
                        <td class="text-center">
                            <input 
                                type="checkbox" 
                                class="form-check-input" {{-- Melhor usar a classe do Bootstrap --}}
                                wire:click="atualizarSelecao({{ $produto->id }})" 
                                {{ in_array($produto->id, $produtosSelecionados) ? 'checked' : '' }}
                                wire:loading.attr="disabled" {{-- 👈 Desabilita o check enquanto processa --}}
                            >
                        </td>
                        <td>{{ $produto->nome }}</td>
                        <td>{{ $produto->codigo }}</td>
                        <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                        <td>{{ $produto->estoque }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">
                            Nenhum produto encontrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3" wire:loading.class="opacity-50">
        {{ $produtos->links() }}
    </div>
</div>