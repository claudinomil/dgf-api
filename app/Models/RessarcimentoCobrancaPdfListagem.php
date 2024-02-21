<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RessarcimentoCobrancaPdfListagem extends Model
{
    use HasFactory;

    protected $table = 'ressarcimento_cobrancas_pdfs_listagens';

    protected $fillable = [
        'ressarcimento_orgao_id',
        'referencia',
        'referencia_ano',
        'referencia_mes',
        'referencia_parte',
        'orgao_name',
        'configuracao_dgf2_identidade_funcional',
        'configuracao_dgf2_rg',
        'configuracao_dgf2_nome',
        'configuracao_dgf2_posto',
        'configuracao_dgf2_quadro',
        'configuracao_dgf2_cargo',
        'nota_numero',
        'nota_ano',
        'oe_cobrar'
    ];
}
