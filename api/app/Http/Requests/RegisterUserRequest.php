<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4',
        ];
    }

    public function  messages()
    {
        return [
            'name.required'    =>'O campo nome é obrigatório',
            'name.string'      =>'O campo nome deve ser texto',
            'name.max'         =>'O campo nome excedeu o tamanho máximo',
            'email.required'   =>'O campo email é obrigatório',
            'email.string'     =>'O campo email deve ser texto',
            'email.email'      =>'O email informado não é válido',
            'email.max'        =>'O campo email excedeu o tamanho máximo',
            'email.unique'     =>'O email informado já está cadastrado',
            'password.required'=>'O campo senha é obrigatório',
            'password.string'  =>'O campo senha deve ser texto',
            'password.min'     =>'O campo senha deve ter no minímo 4 caracteres',
        ];
    }
}
