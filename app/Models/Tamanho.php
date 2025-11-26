<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tamanho extends Model
{
    protected $table = 'tamanhos';
    protected $fillable = [

        'id',
        'tamanho',
        'created_at',
        'updated_at',
        'deleted_at'

    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

}
