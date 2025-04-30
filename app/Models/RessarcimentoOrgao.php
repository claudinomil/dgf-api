<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class RessarcimentoOrgao extends Model
{
    use HasFactory;

    protected $table = 'ressarcimento_orgaos';

    protected $fillable = [
        'name',
        'cnpj',
        'ug',
        'responsavel',
        'esfera_id',
        'poder_id',
        'tratamento_id',
        'vocativo_id',
        'funcao_id',
        'telefone_1',
        'telefone_2',
        'cep',
        'numero',
        'complemento',
        'logradouro',
        'bairro',
        'localidade',
        'uf',
        'contato_nome',
        'contato_telefone',
        'contato_celular',
        'contato_email',
        'lotacao_id',
        'lotacao',
        'realizar_cobranca'
    ];
}
