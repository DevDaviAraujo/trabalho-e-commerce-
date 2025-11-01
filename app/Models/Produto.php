<?php

namespace App\Models;
use App\Models\Media;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Oferta;


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

    public function ofertas()
    {
        return $this->belongsToMany(Oferta::class, 'oferta_produtos', 'produto_id', 'oferta_id');
    }

    public function subCategoria(): BelongsTo {
        return $this->belongsTo(subCategoria::class);
    }
}
