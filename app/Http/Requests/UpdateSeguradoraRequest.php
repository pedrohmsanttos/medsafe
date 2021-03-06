<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Seguradora;

class UpdateSeguradoraRequest extends FormRequest
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
        //return Seguradora::$rules;
        return [
            'descricaoCorretor' => 'required|max:255',
            'CNPJ' => 'required|cpf_cnpj|max:14,unique:seguradoras'.$this->id,
            'telefone' => 'required|max:12',
            'email' => 'required'
        ];
        
    }
}
