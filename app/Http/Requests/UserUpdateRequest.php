<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
}
