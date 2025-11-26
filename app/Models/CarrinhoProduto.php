<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CarrinhoProduto extends Pivot
{
    protected $table = 'carrinho_produtos';

    public function tamanho()
    {
        return $this->belongsTo(Tamanho::class, 'tamanho_id');
    }
}
