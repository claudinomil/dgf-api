<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SadMilitaresInformacaoUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'militar_rg' => [
                'required',
                Rule::unique('sad_militares_informacoes')->ignore($this->id)
            ],
            'setor_id' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'militar_rg.required' => 'O RG é requerido.',
            'militar_rg.unique' => 'O RG já existe.',
            'setor_id.required' => 'O Setor é requerido.'
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
