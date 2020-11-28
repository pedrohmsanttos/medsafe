<?php

namespace App\Http\Requests\API;

use App\Models\Corretor;
use InfyOm\Generator\Request\APIRequest;

class CreateCorretorAPIRequest extends APIRequest
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
            'nome' => 'required|max:255',
            'cpf' => 'required|max:11|cpf|unique:corretores',
            'telefone' => 'required|max:12',
            'email' => 'required|email|max:50',
            'celular' => 'required|max:12',
            'telefone_2'  => 'required|max:12',
            'cnpj' => 'required|max:14|cnpj|unique:corretoras',
            'inscricao_municipal'  => 'required|max:18',
            'susep'  => 'required|max:18',
            'cep'  => 'required|max:8',
            'uf'  => 'required|max:2',
            'municipio'  => 'required|max:60',
            'bairro'  => 'required|max:60',
            'numero'  => 'required|max:16',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'error' => 'Os dados fornecidos eram inválidos!'
        ];
    }
}
