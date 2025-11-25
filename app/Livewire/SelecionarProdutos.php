<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\SubCategoria;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class SelecionarProdutos extends Component
{
    use WithPagination;

    public $search = '';
    public $categoria = '';
    public $subCategoria = '';

    public $subcategorias = [];
    public $produtosSelecionados = [];

    protected $paginationTheme = 'bootstrap';

    #[On('atualizarSelecionados')]
    public function atualizarSelecionados($selecionados)
    {
        $this->produtosSelecionados = $selecionados;
    }

    public function atualizarSelecao($id)
    {
        if (in_array($id, $this->produtosSelecionados)) {
            $this->produtosSelecionados = array_diff($this->produtosSelecionados, [$id]);
        } else {
            $this->produtosSelecionados[] = $id;
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoria()
    {
        $this->resetPage();
        $this->subCategoria = ''; // Resetar subcategoria ao mudar categoria
    }

    public function updatingSubCategoria()
    {
        $this->resetPage();
    }


    public function chamaSubCategoria($categoria_id)
    {

        $this->subcategorias = SubCategoria::where('categoria_id', $categoria_id)->get();

    }

    #[Computed(persist: true)]
    public function categorias()
    {
        return Categoria::orderBy('descricao')->get();
    }

    public function render()
    {
        $query = Produto::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nome', 'like', "%{$this->search}%")
                    ->orWhere('codigo', 'like', "%{$this->search}%");
            });
        }

        if ($this->subCategoria) {
            $query->where('sub_categoria_id', $this->subCategoria);
        } elseif ($this->categoria) {
            // Filtra produtos pela categoria pai via relação SubCategoria
            $query->whereHas('subCategoria', function ($q) {
                $q->where('categoria_id', $this->categoria);
            });
        }

        $produtos = $query->paginate(10);

        return view('livewire.selecionar-produtos', [
            'produtos' => $produtos,
            'categorias' => $this->categorias,
            'subcategorias' => $this->subcategorias,
        ]);
    }
}
