<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function subCategorias(): HasMany {
        return $this->hasMany(SubCategoria::class);
    }
}

class SubCategoria extends Model
{
    
    protected $table = 'sub_categorias';
    protected $fillable = [

        'id',
        'categoria_id',
        'descricao',
        'created_at',
        'updated_at',
        'deleted_at'

    ];

    public function categoria(): BelongsTo {
        return $this->belongsTo(Categoria::class);
    }


}
