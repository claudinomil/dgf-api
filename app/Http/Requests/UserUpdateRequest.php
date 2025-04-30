<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => [
                'nullable',
                Rule::unique('users')->ignore($this->id),
                'email'
            ],
            'layout_mode' => ['required'],
            'layout_style' => ['required'],
            'grupo_id' => ['required'],
            'situacao_id' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O Nome é requerido.',
            'email.unique' => 'O E-mail já existe.',
            'email.email' => 'O E-mail deve ser um endereço válido.',
            'layout_mode.required' => 'O Mode é requerido.',
            'layout_style.required' => 'O Estilo é requerido.',
            'grupo_id.required' => 'O Grupo é requerido.',
            'situacao_id.required' => 'A Situação é requerido.'
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
