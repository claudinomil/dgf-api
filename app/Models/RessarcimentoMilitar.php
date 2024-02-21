<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RessarcimentoMilitar extends Model
{
    use HasFactory;

    protected $table = 'ressarcimento_militares';

    protected $fillable = [
        'referencia',
        'identidade_funcional',
        'rg',
        'nome',
        'oficial_praca',
        'posto_graduacao',
        'quadro_qbmp',
        'boletim',
        'lotacao_id',
        'lotacao'
    ];
}
