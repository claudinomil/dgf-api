<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FerramentaUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'descricao' => ['required'],
            'url' => ['required'],
            'icon' => ['required'],
            'user_id' => ['required'],
            'ordem_visualizacao' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O Nome é requerido.',
            'descricao.required' => 'A Descrição é requerido.',
            'url.required' => 'A URL é requerido.',
            'icon.required' => 'O Ícone é requerido.',
            'user_id.required' => 'O Usuário é requerido.',
            'ordem_visualizacao.required' => 'A Ordem Visualização é obrigatório'
        ];
    }
}
