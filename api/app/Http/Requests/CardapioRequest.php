<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardapioRequest extends FormRequest
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
            'nome'           => $obrigatorio.'string|max:255',
            'descricao'      => $obrigatorio.'string',
            'restaurante_id' => $obrigatorio.'exists:App\Models\Restaurante,id',
        ];
    }

    public function  messages()
    {
        return [
            'nome.required'         =>'O campo nome é obrigatório',
            'nome.string'           =>'O campo nome deve ser texto',
            'nome.max'              =>'O campo nome excedeu o tamanho máximo',
            'descricao.required'    =>'O campo descricao é obrigatório',
            'descricao.string'      =>'O campo descricao deve ser texto',
            'restaurante_id.exists' =>'Restaurante não encontrado',
            'restaurante_id.required'    =>'O campo restaurante é obrigatório',

        ];
    }
}
