<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Negocio;

class CreateNegocioRequest extends FormRequest
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

        if (isset($input['tipopessoa']) && $input['tipopessoa'] == '1') {
            return [
                'usuario_operacao_id' => 'required',
                'titulo' => 'required|max:30',
                'data_criacao' => 'required',
                'cep' => 'required|max:8',
                'rua' => 'required|max:68',
                'numero' => 'required|max:20',
                'bairro' => 'required|max:40',
                'municipio' => 'required|max:50',
                'uf' => 'required|max:2',
                'nome' => 'required|max:50',
                'telefone' => 'required|max:11',
                'email' => 'required|max:60',
                'itens' => 'required|min:5'
            ];
        } else {
            return [
                'usuario_operacao_id' => 'required',
                'titulo' => 'required|max:30',
                'data_criacao' => 'required',
                'cep' => 'required|max:8',
                'rua' => 'required|max:68',
                'numero' => 'required|max:20',
                'bairro' => 'required|max:40',
                'municipio' => 'required|max:50',
                'uf' => 'required|max:2',
                'nome' => 'required|max:50',
                'telefone' => 'required|max:11',
                'email' => 'required|max:60',
                'itens' => 'required|min:5',
                'faturamento_id' => 'required'
            ];
        }
    }
}
