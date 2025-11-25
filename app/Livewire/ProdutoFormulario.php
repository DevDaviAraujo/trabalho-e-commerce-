<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\SubCategoria;
use App\Http\Controllers\WebsiteControllers\MediaController;
use App\Http\Controllers\WebsiteControllers\ProdutoController;
use Illuminate\Validation\Rule;
use DB;

class ProdutoFormulario extends Component
{
    use WithFileUploads;

    public $produtoId;
    public $nome;
    public $descricao;
    public $codigo;
    public $modelo;
    public $preco;
    public $estoque;
    public $categoria_id;
    public $sub_categoria_id;
    public $imagens = [];
    public $tamanhos = [];
    public $categorias = [];
    public $subcategorias = [];

    public function mount($produto = null)
    {
        // 1. Carrega todas as categorias
        $this->categorias = Categoria::all();

        if ($produto) {
            $this->produtoId = $produto->id;
            $this->nome = $produto->nome;
            $this->descricao = $produto->descricao;
            $this->codigo = $produto->codigo;
            $this->modelo = $produto->modelo;
            $this->preco = $produto->preco;
            $this->estoque = $produto->estoque;

            $this->categoria_id = $produto->subCategoria->categoria_id ?? null;
            $this->chamaSubCategoria($this->categoria_id); // <-- correto
            $this->sub_categoria_id = $produto->sub_categoria_id;

            $this->tamanhos = $produto->tamanhos->pluck('tamanho')->toArray();

        } else {
            $this->tamanhos = [''];
        }
    }

    public function chamaSubCategoria($categoria_id)
    {
        $this->subcategorias = SubCategoria::where('categoria_id', $categoria_id)->get();


        $this->sub_categoria_id = null;
    }

    public function addTamanho()
    {
        $this->tamanhos[] = '';
    }

    public function removeTamanho($index)
    {
        unset($this->tamanhos[$index]);
        $this->tamanhos = array_values($this->tamanhos);
    }

    protected function rules()
    {
        return [
            'nome' => ['required', Rule::unique('produtos', 'nome')->ignore($this->produtoId)],
            'descricao' => 'required',
            'codigo' => 'required',
            'modelo' => 'required',
            'preco' => 'required|numeric|min:0',
            'estoque' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'sub_categoria_id' => 'required|exists:sub_categorias,id',
            'tamanhos.*' => 'required',
            'imagens.*' => $this->produtoId
                ? 'nullable|file|max:20000|mimes:jpeg,png,jpg,gif,webp,avif'
                : 'required|file|max:20000|mimes:jpeg,png,jpg,gif,webp,avif',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        $data = [
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'codigo' => $this->codigo,
            'modelo' => $this->modelo,
            'preco' => $this->preco,
            'estoque' => $this->estoque,
            'sub_categoria_id' => $this->sub_categoria_id,
        ];

        $result = app(ProdutoController::class)->salvar($data, $this->tamanhos, $this->produtoId);

        if ($result['status'] !== 'success') {
            session()->flash('error', $result['message']);
            return;
        }

        $produtoId = $result['id'];

        // Salvar imagens do Livewire
        foreach ($this->imagens as $imagem) {
            app(MediaController::class)->save_file(
                $imagem,
                $produtoId,
                Produto::class,
                'produto'
            );
        }

        session()->flash('success', 'Produto salvo com sucesso!');

        if (empty($this->produtoId)) {
            $this->reset([
                'nome',
                'descricao',
                'codigo',
                'modelo',
                'preco',
                'estoque',
                'sub_categoria_id'
            ]);
        }
    }



    public function render()
    {
        return view('livewire.produto-formulario');
    }
}