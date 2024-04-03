<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlimentacaoUnidadeStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O Nome é requerido.'
        ];
    }
}
