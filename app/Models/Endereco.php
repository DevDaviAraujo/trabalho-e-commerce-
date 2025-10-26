<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Endereco extends Model
{
    protected $table = 'enderecos';
    protected $fillable = [

        'id',
        'user_id',
        'rua',
        'bairro',
        'numero',
        'complemento',
        'cidade',
        'cep',
        'uf',
        'created_at',
        'updated_at',
        'deleted_at'

    ];

     public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    
}
