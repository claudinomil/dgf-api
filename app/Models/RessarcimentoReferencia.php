<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RessarcimentoReferencia extends Model
{
    use HasFactory;

    protected $table = 'ressarcimento_referencias';

    protected $fillable = [
        'referencia',
        'ano',
        'mes',
        'parte'
    ];
}
