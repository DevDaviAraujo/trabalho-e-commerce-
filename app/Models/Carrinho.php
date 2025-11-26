<?php

namespace App\Models;
use App\Models\User;
use App\Models\Produto;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\CarrinhoProduto;

class Carrinho extends Model
{
    protected $table = 'carrinhos';

    protected $fillable = [

        'id',
        'user_id',
        'token',
        'created_at',
        'updated_at',
        'deleted_at'

    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tamanho()
    {
        return $this->belongsTo(Tamanho::class, 'tamanho_id');
    }


    public function itens()
    {
        return $this->belongsToMany(Produto::class, 'carrinho_produtos')
            ->using(CarrinhoProduto::class)
            ->withPivot(['tamanho_id', 'quantidade', 'preco_unitario'])
            ->withTimestamps();
    }


}

