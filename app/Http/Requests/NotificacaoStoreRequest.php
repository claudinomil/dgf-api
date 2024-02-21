<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificacaoStoreRequest extends FormRequest
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
            'date' => ['required'],
            'time' => ['required'],
            'title' => ['required'],
            'notificacao' => ['required'],
            'user_id' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'date.required' => 'A Data é requerido.',
            'time.required' => 'A Hora é requerido.',
            'title.required' => 'O Título é requerido.',
            'notificacao.required' => 'A Notificação é requerido.',
            'user_id.required' => 'O Usuário é requerido.'
        ];
    }
}
