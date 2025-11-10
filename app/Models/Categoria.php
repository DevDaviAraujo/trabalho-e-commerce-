<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\SubCategoria;

class Categoria extends Model
{
    
    protected $table = 'categorias';
    protected $fillable = [

        'id',
        'descricao',
        'created_at',
        'updated_at',
        'deleted_at'

    ];

    public function subs(): HasMany {
        return $this->hasMany(SubCategoria::class);
    }
}
