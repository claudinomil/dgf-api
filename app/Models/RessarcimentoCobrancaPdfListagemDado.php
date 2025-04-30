<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RessarcimentoCobrancaPdfListagemDado extends Model
{
    use HasFactory;

    protected $table = 'ressarcimento_cobrancas_pdfs_listagens_dados';

    protected $fillable = [
        'ressarcimento_cobranca_pdf_listagem_id',
        'militar_identidade_funcional',
        'militar_posto_graduacao',
        'militar_nome',
        'vencimento_bruto',
        'fundo_saude_10',
        'rioprevidencia22',
        'fonte10',
        'folha_suplementar',
        'valor_total'
    ];
}
