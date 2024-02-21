<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RessarcimentoCobranca extends Model
{
    use HasFactory;

    protected $table = 'ressarcimento_cobrancas';

    protected $fillable = [
        'referencia',
        'cobranca_encerrada',
        'data_encerramento'
    ];
}
