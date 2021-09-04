<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestauranteRequest extends FormRequest
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
        $obrigatorio = $this->getMethod()=='POST'?'required|':'';
        return [
            'nome'      => $obrigatorio.'string|max:255',
            'descricao' => $obrigatorio.'string',
            'telefone'  => 'string|size:11',
            'endereco'  => 'string|max:255',
            'cep'       => 'string|size:8',
            'cidade'    => 'string|max:255',
            'estado'    => 'string|size:2',
            'ativo'     => 'boolean',
        ];
    }

    public function  messages()
    {
        return [
            'nome.required'      =>'O campo nome é obrigatório',
            'nome.string'        =>'O campo nome deve ser texto',
            'nome.max'           =>'O campo nome excedeu o tamanho máximo',
            'descricao.required' =>'O campo descricao é obrigatório',
            'descricao.string'   =>'O campo descricao deve ser texto',
            'telefone.string'    =>'O campo telefone deve ser texto',
            'telefone.size'      =>'O campo telefone deve conter 11 caracteres',
            'endereco.string'    =>'O campo endereco deve ser texto',
            'endereco.max'       =>'O campo endereco excedeu o tamanho máximo',
            'cep.string'         =>'O campo cep deve ser texto',
            'cep.size'           =>'O campo cep deve conter 8 caracteres',
            'cidade.string'      =>'O campo cidade deve ser texto',
            'cidade.max'         =>'O campo cidade excedeu o tamanho máximo',
            'estado.string'      =>'O campo estado deve ser texto',
            'estado.size'        =>'O campo estado deve conter 2 caracteres',
            'ativo.boolean'      =>'O campo ativo dever ser boleano',
        ];
    }
}
