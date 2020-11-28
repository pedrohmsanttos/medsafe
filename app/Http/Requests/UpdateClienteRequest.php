<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Cliente;

class UpdateClienteRequest extends FormRequest
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
        $input = $this->all();
        
        if ($input['tipoPessoa']=='pf') {
            return [
                'nomeFantasia' => 'required',
                'tipoPessoa' => 'required',
                'CNPJCPF' => 'required|cpf_cnpj|unique:clientes,CNPJCPF,'.$input['id'].'',
                'cep' => 'required',
                'rua' => 'required',
                'numero' => 'required',
                'bairro' => 'required',
                'municipio' => 'required',
                'uf' => 'required',
                'email' => 'required|email',
                'funcao' => 'required',
                'telefone' => 'required|max:11'
            ];
        } else {
            return [
                'razaoSocial' => 'required',
                'nomeFantasia_pj' => 'required',
                'classificacao' => 'required|max:15',
                'tipoPessoa' => 'required',
                'inscricaoEstadual' => 'required',
                'inscricaoMunicipal' => 'required',
                'nomeTitular' => 'required',
                'CNPJCPF_pj' => 'required|cpf_cnpj|unique:clientes,CNPJCPF,'.$input['id'].'',
                'CPF' => 'required|cpf',
                'cep' => 'required',
                'rua' => 'required',
                'numero' => 'required',
                'bairro' => 'required',
                'municipio' => 'required',
                'uf' => 'required',
                'email_pj' => 'required|email',
                'funcao_pj' => 'required',
                'telefone_pj' => 'required|max:11'
            ];
        }
    }
}
