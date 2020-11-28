<?php

namespace App\Http\Requests\API;

use App\Models\Negocio;
use InfyOm\Generator\Request\APIRequest;

class CreateNegocioAPIRequest extends APIRequest
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
            'nome' => 'required',
            'email' => 'required',
            'tipopessoa' => 'required',
            'telefone_1' => 'required',
            'telefone_2' => 'required',
            'telefone_3' => 'required',
            'categoria_produto_id' => 'required',
            'tipo_produto_id' => 'required'
        ];
    }
}
