<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Categoria;
use App\Models\Subcategoria;
class Filtragem extends Component
{

    public $categorias = [];
    public $subcategorias = [];

    public function mount() {
        $this->categorias = Categoria::all();
        
    }
    public function chamaSubCategoria($categoria_id)
    {

        $this->subcategorias = SubCategoria::where('categoria_id', $categoria_id)->get();

    }
    public function render()
    {
        return view('livewire.filtragem');
    }
}
