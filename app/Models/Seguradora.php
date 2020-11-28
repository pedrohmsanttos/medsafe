<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Seguradora
 * @package App\Models
 * @version January 11, 2019, 5:10 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property string descricaoCorretor
 * @property string CNPJ
 * @property string telefone
 * @property string email
 */
class Seguradora extends Model
{
    use SoftDeletes;

    public $table = 'seguradoras';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'descricaoCorretor',
        'CNPJ',
        'telefone',
        'email'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'descricaoCorretor' => 'string',
        'CNPJ' => 'string',
        'telefone' => 'string',
        'email' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
     public static $rules = [
         'descricaoCorretor' => 'required|max:255',
         'CNPJ' => 'required|cpf_cnpj|unique:seguradoras|max:14',
         'telefone' => 'required|max:12',
         'email' => 'required|email'
     ];

    /**
     * Validation rules on update
     *
     * @var array
     */
    // public static $upRules = [
    //     'descricaoCorretor' => 'required|max:255',
    //     // 'CNPJ' => 'required|cpf_cnpj|max:14,unique:seguradoras'.$this->id,
    //     'telefone' => 'required|max:12',
    //     'email' => 'required'
    // ];

    public function rules()
    {
        switch($this->method())
        {
            case 'PUT' :{
                return [
                    'descricaoCorretor' => 'required|max:255',
                    'CNPJ' => 'required|cpf_cnpj|max:14,unique:seguradoras'.$this->id,
                    'telefone' => 'required|max:12',
                    'email' => 'required|email'
                ];
            }
            case 'POST' :{
                return [
                    'descricaoCorretor' => 'required|max:255',
                    'CNPJ' => 'required|cpf_cnpj|unique:seguradoras|max:14',
                    'telefone' => 'required|max:12',
                    'email' => 'required|email'
                ];
            }
            default:break;
        }
    }

    
}
