<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Mail as Template;
use App\Jobs\SendMail;

/**
 * Class Cliente
 * @package App\Models
 * @version December 21, 2018, 5:06 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property string razaoSocial
 * @property string nomeFantasia
 * @property string classificacao
 * @property string tipoPessoa
 * @property string CNPJCPF
 * @property string inscricaoEstadual
 * @property string inscricaoMunicipal
 * @property string nomeTitular
 * @property string CPF
 */
class Cliente extends Model
{
    use SoftDeletes;

    public $table = 'clientes';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'razaoSocial',
        'nomeFantasia',
        'classificacao',
        'tipoPessoa',
        'CNPJCPF',
        'inscricaoEstadual',
        'inscricaoMunicipal',
        'nomeTitular',
        'CPF',
        'telefone',
        'email',
        'funcao',
        'user_id',
        'especialidade_id',
        'dia_vencimento'
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
        'nomeTitular' => 'string',
        'CPF' => 'string',
        'telefone' => 'string',
        'email' => 'string',
        'funcao' => 'string'
    ];

    /**
     * Validation rules on create
     *
     * @var array
     */
    public static $rulesPJ = [
        'razaoSocial' => 'required',
        'nomeFantasia_pj' => 'required',
        'classificacao' => 'required|max:15',
        'tipoPessoa' => 'required',
        'inscricaoEstadual' => 'required',
        'inscricaoMunicipal' => 'required',
        'nomeTitular' => 'required',
        'CNPJCPF_pj' => 'required|cpf_cnpj|unique:clientes',
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

    /**
     * Validation rules on create
     *
     * @var array
     */
    public static $rulesPF = [
        'nomeFantasia' => 'required',
        'tipoPessoa' => 'required',
        'CNPJCPF' => 'required|cpf_cnpj|unique:clientes',
        'cep' => 'required',
        'rua' => 'required',
        'numero' => 'required',
        'bairro' => 'required',
        'municipio' => 'required',
        'especialidade_id' => 'required',
        'uf' => 'required',
        'email' => 'required|email',
        'funcao' => 'required',
        'telefone' => 'required|max:11'
    ];

    /**
     * Return Endereço on cliente
     *
     * @var Object
     */
    public function endereco()
    {
        return $this->hasOne('App\Models\Endereco')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function lancamentoReceber()
    {
        return $this->hasMany(\App\Models\LancamentoReceber::class)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     **/
    public function usuario()
    {
        return $this->belongsTo('App\Models\User', 'user_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     **/
    public function especialidade()
    {
        return $this->belongsTo('App\Models\Especialidade', 'especialidade_id')->withTrashed();
    }

    /**
     * Return Razão Social on cliente
     *
     * @var Object
     */
    public function razaoSocial()
    {
        if (!empty($this->razaoSocial)) {
            return $this->razaoSocial;
        }
        return 'Não informado!';
    }

    public function getTipo()
    {
        $mensagem = 'Não informado!';
        if (!empty($this->tipoPessoa)) {
            if ($this->tipoPessoa == "pf") {
                $mensagem = "Pessoa Física";
            } elseif ($this->tipoPessoa=="pj") {
                $mensagem = "Pessoa Jurídica";
            }
        }
        return $mensagem;
    }

    public function primeiroAcesso($pass)
    {
        $emails = Template::where('tipo', 'Cadastro de Cliente')->get();
        
        $vars  = array(
            '__email__' => $this->email,
            '__senha__' => $pass,
            '__nome__'  => $this->razaoSocial
        );

        $dados = new \stdClass();//create a new
        $dados->destinatarioNome  = $this->razaoSocial;
        $dados->destinatarioEmail = $this->email;
        $dados->logo              = "";
        $dados->tipo              = "cadastro_cliente";

        dispatch(new SendMail($vars, $dados, $emails[0]));
    }

    public function sendCheckout($id)
    {
        $emails = Template::where('tipo', 'Envio de Checkout')->get();
        
        $vars  = array(
            '__url__' => url("/checkouts/{$id}/edit"),
            '__nome__'  => $this->razaoSocial
        );

        $dados = new \stdClass();//create a new
        $dados->destinatarioNome  = $this->razaoSocial;
        $dados->destinatarioEmail = $this->email;
        $dados->logo              = "";
        $dados->tipo              = "envio_checkout";

        dispatch(new SendMail($vars, $dados, $emails[0]));
    }

    public function getCheckouts()
    {
        $checkouts = Checkout::where('cliente_id', $this->id)->whereIn('status', [0, 1])->get();
        
        return $checkouts;
    }
}
