<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
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
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:4',
        ];
    }

    public function  messages()
    {
        return [
            'email.required'=>'O campo email é obrigatório',
            'email.string'=>'O campo email não deve ser numérico',
            'email.email'=>'O email informado não é válido',
            'email.max'=>'O campo email excedeu o tamanho máximo',
            'password.required'=>'O campo senha é obrigatório',
            'password.string'=>'O campo senha não deve ser numérico',
            'password.min'=>'O campo senha deve ter no minímo 4 caracteres',
        ];
    }
}
