<?php

namespace App\Models;
use App\Models\User;
use App\Models\Produto;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function carrinho_produtos(): HasMany {
        return $this->hasMany(CarrinhoProdutos::class);
    }

}

class CarrinhoProdutos extends Model
{
    protected $table = 'carrinho_produtos';
    protected $fillable = [

        'id',
        'carrinho_id',
        'produto_id',
        'quantidade',
        'preco_unitario',
        'created_at',
        'updated_at',
        'deleted_at'

    ];


    public function produto(): BelongsToMany {
        return $this->BelongsToMany(Produto::class);
    }
    public function carrinho(): BelongsToMany {
        return $this->BelongsToMany(Carrinho::class);
    }

}
