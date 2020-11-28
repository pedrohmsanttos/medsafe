<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Fornecedores
 * @package App\Models
 * @version January 2, 2019, 9:18 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property integer id
 * @property string razaoSocial
 * @property string nomeFantasia
 * @property string classificacao
 * @property string tipoPessoa
 * @property string CNPJCPF
 * @property string inscricaoEstadual
 * @property string inscricaoMunicipal
 * @property string telefone
 * @property string email
 * @property string nomeTitular
 * @property string CPF
 */
class Fornecedor extends Model
{
    use SoftDeletes;

    public $table = 'fornecedores';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'id',
        'razaoSocial',
        'nomeFantasia',
        'classificacao',
        'tipoPessoa',
        'CNPJCPF',
        'inscricaoEstadual',
        'inscricaoMunicipal',
        'telefone',
        'email',
        'nomeTitular',
        'CPF',
        'funcao'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'razaoSocial' => 'string',
        'nomeFantasia' => 'string',
        'classificacao' => 'string',
        'tipoPessoa' => 'string',
        'CNPJCPF' => 'string',
        'inscricaoEstadual' => 'string',
        'inscricaoMunicipal' => 'string',
        'telefone' => 'string',
        'email' => 'string',
        'nomeTitular' => 'string',
        'CPF' => 'string',
        'funcao' => 'string'
    ];

    /**
     * Validation rules on create
     *
     * @var array
     */
    public static $rules = [
        'razaoSocial' => 'required',
        'nomeFantasia' => 'required',
        'classificacao' => 'required',
        'tipoPessoa' => 'required',
        'inscricaoEstadual' => 'required',
        'inscricaoMunicipal' => 'required',
        'nomeTitular' => 'required',
        'CNPJCPF' => 'required|cpf_cnpj|unique:fornecedores',
        'CPF' => 'required|cpf',
        'cep' => 'required',
        'rua' => 'required',
        'numero' => 'required',
        'bairro' => 'required',
        'municipio' => 'required',
        'uf' => 'required',
        'email' => 'required|email',
        'funcao' => 'required',
        'telefone' => 'required'
    ];

    /**
     * Validation rules on update
     *
     * @var array
     */
    public static $upRules = [
        'razaoSocial' => 'required',
        'nomeFantasia' => 'required',
        'classificacao' => 'required',
        'tipoPessoa' => 'required',
        'inscricaoEstadual' => 'required',
        'inscricaoMunicipal' => 'required',
        'nomeTitular' => 'required',
        'CNPJCPF' => 'required|cpf_cnpj',
        'CPF' => 'required|cpf',
        'cep' => 'required',
        'rua' => 'required',
        'numero' => 'required',
        'bairro' => 'required',
        'municipio' => 'required',
        'uf' => 'required',
        'email' => 'required|email',
        'funcao' => 'required',
        'telefone' => 'required'
    ];

    /**
     * Return Endereço on cliente
     *
     * @var Object
     */
    public function endereco(){
		return $this->hasOne('App\Models\Endereco')->withTrashed();
    }

    /**
     * Return Razão Social on cliente
     *
     * @var Object
     */
    public function razaoSocial(){
        if($this->razaoSocial){
            return $this->razaoSocial;
        }
    }

    
}
