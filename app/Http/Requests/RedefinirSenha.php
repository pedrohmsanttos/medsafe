<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class RedefinirSenha extends FormRequest
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
            'senha' => 'required|min:5',
            'confirmar_senha' => 'required|min:5|same:senha',
        ];
    }
}
