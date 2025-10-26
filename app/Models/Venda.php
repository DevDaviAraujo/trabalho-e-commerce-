<?php

namespace App\Models;
use App\Models\FormaPagamento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venda extends Model
{
    protected $table = 'vendas';

    protected $fillable = [

        'id',
        'carrinho_id',
        'total',
        'desconto',
        'created_at',
        'updated_at',
        'deleted_at'

    ];

    public function formas_pagamento(): HasMany {
        return $this->hasMany(FormaPagamento::class);
    }
}
