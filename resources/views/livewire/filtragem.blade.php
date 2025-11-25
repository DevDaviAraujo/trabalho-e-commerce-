<!-- Formulário de Filtro -->
<form action="{{ route('produtos') }}" method="GET" class="row gx-2 gy-2 align-items-end w-100 flex-wrap">

    <div class="col-md-4 col-lg-3">
        <input type="text" name="pesquisa" value="{{ request('pesquisa') }}" class="form-control"
            placeholder="Buscar por nome, código...">
    </div>

    <div class="col-md-4 col-lg-2">
        <select name="categoria_id" class="form-select" wire:change="chamaSubCategoria($event.target.value)">
            <option value="">Todas</option>
            @foreach($categorias as $cat)
                <option value="{{ $cat->id }}" {{ request('categoria_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->descricao }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4 col-lg-2">
        <select name="sub_categoria_id" class="form-select">
            <option value="">Todas</option>
            @foreach($subcategorias as $sub)
                <option value="{{ $sub->id }}" {{ request('sub_categoria_id') == $sub->id ? 'selected' : '' }}>
                    {{ $sub->descricao }}
                </option>
            @endforeach
        </select>
    </div>


    <div class="col-6 col-md-3 col-lg-2">
        <input type="number" step="0.01" name="preco_min" value="{{ request('preco_min') }}" class="form-control"
            placeholder="Preço min">
    </div>

    <div class="col-6 col-md-3 col-lg-2">
        <input type="number" step="0.01" name="preco_max" value="{{ request('preco_max') }}" class="form-control"
            placeholder="Preço max">
    </div>

    <div class="col-md-3 col-lg-2">
        <select name="estoque" class="form-select">
            <option value="">Estoque</option>
            <option value="disponivel" {{ request('estoque') == 'disponivel' ? 'selected' : '' }}>
                Disponível</option>
            <option value="zerado" {{ request('estoque') == 'zerado' ? 'selected' : '' }}>Zerado</option>
        </select>
    </div>

    <div class="col-md-3 col-lg-2">
        <select name="ordenar" class="form-select">
            <option value="">Ordenar</option>
            <option value="preco_asc" {{ request('ordenar') == 'preco_asc' ? 'selected' : '' }}>Preço ↑
            </option>
            <option value="preco_desc" {{ request('ordenar') == 'preco_desc' ? 'selected' : '' }}>Preço ↓
            </option>
            <option value="recentes" {{ request('ordenar') == 'recentes' ? 'selected' : '' }}>Recentes
            </option>
            <option value="antigos" {{ request('ordenar') == 'antigos' ? 'selected' : '' }}>Antigos
            </option>
        </select>
    </div>

    <div class="col-md-3 col-lg-2">
        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-funnel me-1"></i> Filtrar
        </button>
    </div>

</form>