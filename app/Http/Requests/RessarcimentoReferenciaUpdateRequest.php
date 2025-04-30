<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RessarcimentoReferenciaUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'referencia' => [
                'required',
                Rule::unique('ressarcimento_referencias')->ignore($this->id)
            ],
            'ano' => ['required', 'date_format:Y'],
            'mes' => ['required', 'date_format:m']
        ];
    }

    public function messages()
    {
        return [
            'referencia.required' => 'A Referência é requerida.',
            'referencia.unique' => 'A Referência já existe.',
            'ano.required' => 'O Ano é requerido.',
            'ano.date_format' => 'O Ano não é válido.',
            'mes.required' => 'O Mês é requerido.',
            'mes.date_format' => 'O Mês não é válido.'
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
