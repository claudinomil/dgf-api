<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlimentacaoUnidadeUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                Rule::unique('alimentacao_unidades')->ignore($this->id)
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O Nome é requerido.'
        ];
    }
}
