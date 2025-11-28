<?php

namespace App\Models;
use App\Models\Media;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Oferta;
use App\Models\Tamanho;
use App\Models\Carrinho;
use Illuminate\Support\Facades\DB;


class Produto extends Model
{
    protected $table = 'produtos';
    protected $fillable = [

        'id',
        'sub_categoria_id',
        'nome',
        'descricao',
        'modelo',
        'codigo',
        'preco',
        'estoque',
        'created_at',
        'updated_at',
        'deleted_at'

    ];


    public function preco()
    {
        $precoBase = $this->attributes['preco'];

        // pega a primeira oferta (ou a mais recente)
        $oferta = $this->ofertas()->orderBy('created_at', 'desc')->first();

        if (!$oferta) {
            return $precoBase;
        }

        // desconto unitário
        if ($oferta->tipo_desconto === 'unitario') {
            return max(0, $precoBase - $oferta->valor_desconto);
        }

        // desconto percentual
        if ($oferta->tipo_desconto === 'porcentagem') {
            return max(0, $precoBase * (1 - $oferta->valor_desconto / 100));
        }

        return $precoBase;
    }


    public function categoria()
    {

        return $this->subCategoria->categoria->descricao;

    }
    public function carrinhos()
    {
        return $this->belongsToMany(Carrinho::class, 'carrinho_produtos')
            ->withPivot(['tamanho_id', 'quantidade', 'preco_unitario'])
            ->withTimestamps();
    }

    public function tamanhos()
    {
        return $this->hasMany(Tamanho::class, 'produto_id');
    }

    public function medias(): MorphMany
    {
        return $this->morphMany(Media::class, 'origin');
    }

    public function media(): MorphOne
    {
        return $this->morphOne(Media::class, 'origin');
    }

    public function ofertas()
    {
        return $this->belongsToMany(Oferta::class, 'oferta_produtos', 'produto_id', 'oferta_id');
    }

    public function subCategoria(): BelongsTo
    {
        return $this->belongsTo(SubCategoria::class);
    }
}
