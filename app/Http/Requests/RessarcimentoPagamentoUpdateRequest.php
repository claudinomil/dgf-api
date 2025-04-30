<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RessarcimentoPagamentoUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'identidade_funcional' => ['required'],
            'vinculo' => ['required'],
            'rg' => ['required'],
            'codigo_cargo' => ['required'],
            'nome_cargo' => ['required'],
            'posto_graduacao' => ['required'],
            'nome' => ['required'],
            'situacao_pagamento' => ['required'],
            'data_ingresso' => ['required'],
            'data_nascimento' => ['required'],
            'genero' => ['required'],
            'codigo_ua' => ['required'],
            'ua' => ['required'],
            'cpf' => ['required'],
            'pasep' => ['required'],
            'banco' => ['required'],
            'agencia' => ['required'],
            'conta_corrente' => ['required'],
            'numero_dependentes' => ['required'],
            'ir_dependente' => ['required'],
            'cotista' => ['required'],
            'bruto' => ['required'],
            'desconto' => ['required'],
            'liquido' => ['required'],
            'soldo' => ['required'],
            'hospital10' => ['required'],
            'rioprevidencia22' => ['required'],
            'etapa_ferias' => ['required'],
            'etapa_destacado' => ['required'],
            'ajuda_fardamento' => ['required'],
            'habilitacao_profissional' => ['required'],
            'gret' => ['required'],
            'auxilio_moradia' => ['required'],
            'gpe' => ['required'],
            'gee_capacitacao' => ['required'],
            'decreto14407' => ['required'],
            'ferias' => ['required'],
            'raio_x' => ['required'],
            'trienio' => ['required'],
            'auxilio_invalidez' => ['required'],
            'tempo_certo' => ['required'],
            'fundo_saude' => ['required'],
            'abono_permanencia' => ['required'],
            'deducao_ir' => ['required'],
            'ir_valor' => ['required'],
            'auxilio_transporte' => ['required'],
            'gram' => ['required'],
            'auxilio_fardamento' => ['required'],
            'cidade' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'identidade_funcional.required' => 'Identidade Funcional é requerido.',
            'vinculo.required' => 'Vínculo é requerido.',
            'rg.required' => 'RG é requerido.',
            'codigo_cargo.required' => 'Código Cargo é requerido.',
            'nome_cargo.required' => 'Nome Cargo é requerido.',
            'posto_graduacao.required' => 'Posto/Graduação é requerido.',
            'nome.required' => 'Nome é requerido.',
            'situacao_pagamento.required' => 'Situação Pagamento é requerido.',
            'data_ingresso.required' => 'Data Ingresso é requerido.',
            'data_nascimento.required' => 'Data Nascimento é requerido.',
            'genero.required' => 'Gênero é requerido.',
            'codigo_ua.required' => 'Código UA é requerido.',
            'ua.required' => 'UA é requerido.',
            'cpf.required' => 'CPF é requerido.',
            'pasep.required' => 'PASEP é requerido.',
            'banco.required' => 'Banco é requerido.',
            'agencia.required' => 'Agência é requerido.',
            'conta_corrente.required' => 'Conta Corrente é requerido.',
            'numero_dependentes.required' => 'Número Dependentes é requerido.',
            'ir_dependente.required' => 'IR Dependente é requerido.',
            'cotista.required' => 'Cotista é requerido.',
            'bruto.required' => 'Bruto é requerido.',
            'desconto.required' => 'Desconto é requerido.',
            'liquido.required' => 'Líquido é requerido.',
            'soldo.required' => 'Soldo é requerido.',
            'hospital10.required' => 'Hospital 10 é requerido.',
            'rioprevidencia22.required' => 'Rioprevidência 22 é requerido.',
            'etapa_ferias.required' => 'Etapa Férias é requerido.',
            'etapa_destacado.required' => 'Etapa Destacado é requerido.',
            'ajuda_fardamento.required' => 'Ajuda Fardamento é requerido.',
            'habilitacao_profissional.required' => 'Habilitação Profissional é requerido.',
            'gret.required' => 'GRET é requerido.',
            'auxilio_moradia.required' => 'Auxílio Moradia é requerido.',
            'gpe.required' => 'GPE é requerido.',
            'gee_capacitacao.required' => 'GEE Capacitação é requerido.',
            'decreto14407.required' => 'Decreto 14407 é requerido.',
            'ferias.required' => 'Férias é requerido.',
            'raio_x.required' => 'Raio X é requerido.',
            'trienio.required' => 'Triênio é requerido.',
            'auxilio_invalidez.required' => 'Auxilio Invalidez é requerido.',
            'tempo_certo.required' => 'Tempo Certo é requerido.',
            'fundo_saude.required' => 'Fundo Saúde é requerido.',
            'abono_permanencia.required' => 'Abono Permanência é requerido.',
            'deducao_ir.required' => 'Dedução IR é requerido.',
            'ir_valor.required' => 'IR Valor é requerido.',
            'auxilio_transporte.required' => 'Auxílio Transporte é requerido.',
            'gram.required' => 'GRAM é requerido.',
            'auxilio_fardamento.required' => 'Auxílio Fardamento é requerido.',
            'cidade.required' => 'Cidade é requerido.'
        ];
    }

    // Se precisar customizar a resposta JSON (para API requests)
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, response()->json([
            'message' => 'Erro de validação',
            'code' => 2020,
            'validation' => $validator->errors(),
            'content' => []
        ], 200));
    }
}
