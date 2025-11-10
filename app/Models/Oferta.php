<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use HasFactory, SoftDeletes;
use App\Models\Produto;
class Oferta extends Model
{

    protected $table = 'ofertas';
    protected $fillable = ['descricao', 'valor_desconto', 'tipo_desconto'];

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'oferta_produtos', 'oferta_id', 'produto_id');
    }

    public function media(): MorphOne
    {
        return $this->morphOne(Media::class, 'origin');
    }

    public function getDesconto()
    {
        if (isset($this->valor_desconto)) {
            if ($this->tipo_desconto == 'porcentagem') {
                return '%' . $this->valor_desconto;
            }
            if ($this->tipo_desconto == 'unitario') {
                return 'R$' . $this->valor_desconto;
            }
        }

        return 'Não há';
    }
}
