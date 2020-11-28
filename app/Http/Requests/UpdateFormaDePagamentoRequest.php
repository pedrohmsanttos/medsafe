<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\FormaDePagamento;

class UpdateFormaDePagamentoRequest extends FormRequest
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
        // return FormaDePagamento::$rules;
        return [
            'titulo' => 'required|max:20,unique:formadepagamentos'.$this->id,
        ];
    }
}
