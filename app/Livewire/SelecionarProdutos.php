<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Produto;
use App\Models\SubCategoria;
use Livewire\Attributes\Computed; // 👈 Adicionado
use Livewire\Attributes\On;       // 👈 Adicionado

class SelecionarProdutos extends Component
{
    use WithPagination;

    public $search = '';
    public $categoria = '';
    public $produtosSelecionados = [];

    protected $paginationTheme = 'bootstrap';

    // 👇 'listeners' foi substituído pelo atributo #[On]
    // protected $listeners = ['atualizarSelecionados'];

    /**
     * Recebe a lista de selecionados de um componente pai (se houver).
     */
    #[On('atualizarSelecionados')] // 👈 Sintaxe moderna do Livewire 3
    public function atualizarSelecionados($selecionados)
    {
        $this->produtosSelecionados = $selecionados;
    }

    /**
     * Adiciona ou remove um ID da lista de selecionados.
     */
    public function atualizarSelecao($id)
    {
        if (in_array($id, $this->produtosSelecionados)) {
            $this->produtosSelecionados = array_diff($this->produtosSelecionados, [$id]);
        } else {
            $this->produtosSelecionados[] = $id;
        }
    }

    /**
     * Reseta a paginação sempre que o filtro de busca mudar.
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Reseta a paginação sempre que o filtro de categoria mudar.
     */
    public function updatingCategoria()
    {
        $this->resetPage();
    }

    /**
     * Otimização: Busca as categorias apenas uma vez e armazena em cache.
     * 'persist: true' mantém o cache entre as requisições.
     */
    #[Computed(persist: true)]
    public function categorias()
    {
        return SubCategoria::orderBy('descricao')->get();
    }

    /**
     * Renderiza o componente.
     */
    public function render()
    {
        $query = Produto::query();

        if ($this->search) {
            $query->where('nome', 'like', "%{$this->search}%")
                ->orWhere('codigo', 'like', "%{$this->search}%");
        }

        if ($this->categoria) {
            // Assumindo que o filtro de 'categoria' se refere a 'sub_categoria_id'
            $query->where('sub_categoria_id', $this->categoria);
        }

        $produtos = $query->paginate(10);

        return view('livewire.selecionar-produtos', [
            'produtos' => $produtos,
            'categorias' => $this->categorias, // 👈 Utiliza a computed property
        ]);
    }
}