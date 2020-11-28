<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class GanhoNegocio
 * @package App\Models
 * @version February 11, 2019, 6:42 pm UTC
 *
 * @property \App\Models\Negocio negocio
 * @property \App\Models\User user
 * @property \Illuminate\Database\Eloquent\Collection negocioProdutos
 * @property \Illuminate\Database\Eloquent\Collection organizacaoEnderecos
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection pessoaEnderecos
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property string comentario
 * @property integer negocio_id
 * @property integer usuario_operacao_id
 * @property date data_ganho
 */
class GanhoNegocio extends Model
{
    use SoftDeletes;

    public $table = 'ganho_negocios';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'comentario',
        'negocio_id',
        'usuario_operacao_id',
        'data_ganho'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'comentario' => 'string',
        'negocio_id' => 'integer',
        'usuario_operacao_id' => 'integer',
        'data_ganho' => 'date'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rulesPF = [
        'negocio_id' => 'required',
        'usuario_operacao_id' => 'required',
        'data_ganho' => 'required',
        'nomeFantasia' => 'required',
        'especialidade_id' => 'required',
        'tipoPessoa' => 'required',
        'CNPJCPF' => 'required|cpf_cnpj',
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

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rulesPJ = [
        'negocio_id' => 'required',
        'usuario_operacao_id' => 'required',
        'data_ganho' => 'required',
        'razaoSocial' => 'required',
        'nomeFantasia_pj' => 'required',
        'tipoPessoa' => 'required',
        'inscricaoEstadual' => 'required',
        'inscricaoMunicipal' => 'required',
        'nomeTitular' => 'required',
        'CNPJCPF_pj' => 'required|cpf_cnpj',
        'CPF' => 'required|cpf',
        'cep' => 'required',
        'rua' => 'required',
        'numero' => 'required',
        'bairro' => 'required',
        'municipio' => 'required',
        'uf' => 'required',
        'email_pj' => 'required|email',
        'nomeTitular' => 'required' ,
        'funcao_pj' => 'required',
        'telefone_pj' => 'required|max:11'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function negocio()
    {
        return $this->belongsTo(\App\Models\Negocio::class)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class)->withTrashed();
    }

    /**
     * Return Array Itens on Negocio
     *
     * @var Array
     */
    public function itens()
    {
        return $this->hasMany('App\Models\Item', 'pedido_id', 'id');
    }
}
