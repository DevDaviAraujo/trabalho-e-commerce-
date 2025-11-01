<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
}
