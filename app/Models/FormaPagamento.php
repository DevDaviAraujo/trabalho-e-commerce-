<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormaPagamento extends Model
{
    protected $table = 'forma_pagamento';

    protected $fillable = [

        'id',
        'venda_id',
        'total',
        'formapgto',
        'created_at',
        'updated_at',
        'deleted_at'

    ];
}
