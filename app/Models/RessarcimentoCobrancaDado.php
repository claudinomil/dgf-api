<?php

namespace App\Models;

use App\Facades\SuporteFacade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RessarcimentoCobrancaDado extends Model
{
    use HasFactory;

    protected $table = 'ressarcimento_cobrancas_dados';

    protected $fillable = [
        'ressarcimento_referencia_id',
        'ressarcimento_orgao_id',
        'ressarcimento_militar_id',
        'ressarcimento_pagamento_id',
        'referencia',
        'referencia_ano',
        'referencia_mes',
        'referencia_parte',
        'orgao_name',
        'orgao_cnpj',
        'orgao_ug',
        'orgao_destinatario_pequeno',
        'orgao_destinatario_grande',
        'orgao_responsavel',
        'orgao_esfera',
        'orgao_poder',
        'orgao_tratamento_completo',
        'orgao_tratamento_reduzido',
        'orgao_vocativo',
        'orgao_funcao',
        'orgao_telefone_1',
        'orgao_telefone_2',
        'orgao_cep',
        'orgao_numero',
        'orgao_complemento',
        'orgao_logradouro',
        'orgao_bairro',
        'orgao_localidade',
        'orgao_uf',
        'orgao_contato_nome',
        'orgao_contato_telefone',
        'orgao_contato_celular',
        'orgao_contato_email',
        'militar_identidade_funcional',
        'militar_rg',
        'militar_nome',
        'militar_posto_graduacao',
        'militar_quadro_qbmp',
        'militar_boletim',
        'militar_lotacao_id',
        'militar_lotacao',
        'pagamento_bruto',
        'pagamento_etapa_ferias',
        'pagamento_etapa_destacado',
        'pagamento_hospital10',
        'pagamento_rioprevidencia22',
        'pagamento_fundo_saude',
        'listagem_vencimento_bruto',
        'listagem_fundo_saude_10',
        'listagem_rioprevidencia22',
        'listagem_fonte10',
        'listagem_folha_suplementar',
        'listagem_valor_total',
        'configuracao_data_vencimento',
        'configuracao_diretor_identidade_funcional',
        'configuracao_diretor_rg',
        'configuracao_diretor_nome',
        'configuracao_diretor_posto',
        'configuracao_diretor_quadro',
        'configuracao_diretor_cargo',
        'configuracao_dgf2_identidade_funcional',
        'configuracao_dgf2_rg',
        'configuracao_dgf2_nome',
        'configuracao_dgf2_posto',
        'configuracao_dgf2_quadro',
        'configuracao_dgf2_cargo',
        'nota_numero',
        'nota_ano',
        'oficio_numero',
        'oficio_ano',
        'oe_cobrar'
    ];

    protected function setConfiguracaoDataVencimentoAttribute($value) {
        $value = SuporteFacade::getDataFormatada(4, $value);
        $this->attributes['configuracao_data_vencimento'] = $value;
    }
    protected function getConfiguracaoDataVencimentoAttribute($value) {
        return SuporteFacade::getDataFormatada(1, $value);
    }
}
