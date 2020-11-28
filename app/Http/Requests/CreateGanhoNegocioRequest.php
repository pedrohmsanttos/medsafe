<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\GanhoNegocio;

class CreateGanhoNegocioRequest extends FormRequest
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
            return GanhoNegocio::$rulesPF;
        } else {
            return GanhoNegocio::$rulesPJ;
        }
    }
}
