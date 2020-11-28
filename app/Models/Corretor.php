<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Mail as Template;
use App\Jobs\SendMail;

/**
 * Class Corretor
 * @package App\Models
 * @version March 27, 2019, 2:03 pm UTC
 *
 * @property \App\Models\Corretora corretora
 * @property \Illuminate\Database\Eloquent\Collection ganhoNegocios
 * @property \Illuminate\Database\Eloquent\Collection negocioProdutos
 * @property \Illuminate\Database\Eloquent\Collection organizacaoEnderecos
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection pessoaEnderecos
 * @property \Illuminate\Database\Eloquent\Collection produtos
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property string nome
 * @property string cpf
 * @property string telefone
 * @property string email
 * @property string celular
 * @property integer corretora_id
 */
class Corretor extends Model
{
    use SoftDeletes;

    public $table = 'corretores';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $fillable = [
        'nome',
        'cpf',
        'telefone',
        'email',
        'celular',
        'aprovado',
        'comissao',
        'periodo_de_pagamento',
        'corretora_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nome' => 'string',
        'cpf' => 'string',
        'telefone' => 'string',
        'email' => 'string',
        'celular' => 'string',
        'aprovado' => 'integer',
        'comissao' => 'double',
        'periodo_de_pagamento' => 'string',
        'corretora_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nome' => 'required|max:255',
        'cpf' => 'required|cpf|unique:corretores',
        'telefone' => 'required|max:12',
        'email' => 'required|email|max:50',
        'celular' => 'required|max:12',
        'corretora' => 'required|numeric'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function corretora()
    {
        return $this->belongsTo(\App\Models\Corretora::class)->withTrashed();
    }

    public function mensagemBoaVinda($senha)
    {
        $emails = Template::where('tipo', 'Cadastro de Corretor')->get();
        
        $vars  = array(
            '__nome__'  => $this->nome,
            '__senha__' => $senha
        );

        $dados = new \stdClass();//create a new
        $dados->destinatarioNome  = $this->nome;
        $dados->destinatarioEmail = $this->email;
        $dados->logo              = "";
        $dados->tipo              = "cadastro_corretor";

        dispatch(new SendMail($vars, $dados, $emails[0]));
    }
}
