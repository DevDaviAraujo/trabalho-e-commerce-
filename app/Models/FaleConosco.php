<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FaleConosco extends Model
{
    protected $table = 'fale_conosco';

    protected $fillable = [

        'id',
        'nome',
        'email',
        'assunto',
        'mensagem',
        'respondido',
        'created_at',
        'updated_at',
        'deleted_at'

    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }


}
