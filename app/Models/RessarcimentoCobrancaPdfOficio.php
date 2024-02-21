<?php

namespace App\Models;

use App\Facades\SuporteFacade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RessarcimentoCobrancaPdfOficio extends Model
{
    use HasFactory;

    protected $table = 'ressarcimento_cobrancas_pdfs_oficios';

    protected $fillable = [
        'ressarcimento_orgao_id',
        'referencia',
        'referencia_ano',
        'referencia_mes',
        'referencia_parte',
        'oficio_numero',
        'oficio_ano',
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
