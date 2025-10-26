<?php

namespace App\Models;
use App\Models\Media;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Produto extends Model
{
    protected $table = 'produtos';
    protected $fillable = [

        'id',
        'sub_categoria_id',
        'nome',
        'descricao',
        'tamanho',
        'modelo',
        'codigo',
        'preco',
        'estoque',
        'created_at',
        'updated_at',
        'deleted_at'

    ];

    public function carrinho_produtos(): HasMany {
        return $this->hasMany(CarrinhoProdutos::class);
    }

    public function medias(): MorphMany {
        return $this->morphMany(Media::class, 'origin');
    }

    public function subCategoria(): BelongsTo {
        return $this->belongsTo(subCategoria::class);
    }
}
