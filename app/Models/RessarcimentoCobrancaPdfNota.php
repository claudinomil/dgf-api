<?php

namespace App\Models;

use App\Facades\SuporteFacade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RessarcimentoCobrancaPdfNota extends Model
{
    use HasFactory;

    protected $table = 'ressarcimento_cobrancas_pdfs_notas';

    protected $fillable = [
        'ressarcimento_orgao_id',
        'referencia',
        'referencia_ano',
        'referencia_mes',
        'referencia_parte',
        'orgao_name',
        'oficio_numero',
        'oficio_ano',
        'total_militares',
        'valor_recursos_oriundos_fonte100',
        'valor_recursos_oriundos_fonte232',
        'valor_bruto_folha_suplementar',
        'valor_rioprevidencia',
        'valor_fundo_saude',
        'valor_total',
        'configuracao_data_vencimento',
        'configuracao_diretor_identidade_funcional',
        'configuracao_diretor_rg',
        'configuracao_diretor_nome',
        'configuracao_diretor_posto',
        'configuracao_diretor_quadro',
        'configuracao_diretor_cargo'
    ];

    protected function setConfiguracaoDataVencimentoAttribute($value) {
        $value = SuporteFacade::getDataFormatada(4, $value);
        $this->attributes['configuracao_data_vencimento'] = $value;
    }
    protected function getConfiguracaoDataVencimentoAttribute($value) {
        return SuporteFacade::getDataFormatada(1, $value);
    }
}
