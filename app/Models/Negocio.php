<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

/**
 * Class Negocio
 * @package App\Models
 * @version January 17, 2019, 6:53 pm UTC
 *
 * @property \App\Models\MotivoPerdaNegocio motivoPerdaNegocio
 * @property \App\Models\Organizacao organizacao
 * @property \App\Models\Pessoa pessoa
 * @property \Illuminate\Database\Eloquent\Collection negocioProdutos
 * @property \Illuminate\Database\Eloquent\Collection organizacaoEnderecos
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection pessoaEnderecos
 * @property \Illuminate\Database\Eloquent\Collection produtos
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property string titulo
 * @property float valor
 * @property date data_fechamento
 * @property date data_criacao
 * @property string etapa
 * @property string status
 * @property date data_perda
 * @property date data_ganho
 * @property string motivo_perda
 * @property integer organizacao_id
 * @property integer pessoa_id
 * @property integer motivo_perda_negocio_id
 */
class Negocio extends Model
{
    use SoftDeletes;

    public $table = 'negocios';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'titulo',
        'valor',
        'data_fechamento',
        'data_criacao',
        'etapa',
        'status',
        'data_perda',
        'data_ganho',
        'motivo_perda',
        'organizacao_id',
        'pessoa_id',
        'motivo_perda_negocio_id',
        'usuario_operacao_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'titulo' => 'string',
        'valor' => 'float',
        'data_fechamento' => 'date',
        'data_criacao' => 'date',
        'etapa' => 'string',
        'status' => 'string',
        'data_perda' => 'date',
        'data_ganho' => 'date',
        'motivo_perda' => 'string',
        'organizacao_id' => 'integer',
        'pessoa_id' => 'integer',
        'motivo_perda_negocio_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'usuario_operacao_id' => 'required',
        'titulo' => 'required',
        'data_criacao' => 'required',
        'cep' => 'required',
        'rua' => 'required',
        'numero' => 'required',
        'bairro' => 'required',
        'municipio' => 'required',
        'uf' => 'required',
        'titulo' => 'required',
        'nome' => 'required',
        'telefone' => 'required',
        'email' => 'required',
        'valor' =>'required'
    ];

    /**
     * Validation rules of update
     *
     * @var array
     */
    public static $upRules = [
        'titulo' => 'required',
        'data_criacao' => 'required',
        'cep' => 'required',
        'rua' => 'required',
        'numero' => 'required',
        'bairro' => 'required',
        'municipio' => 'required',
        'uf' => 'required',
        'titulo' => 'required'
    ];

    /**
     * Descrição status
     *
     * @var array
     */
    public $desc_status = [
        'EM ABERTO', 'PERDIDO', 'GANHO', 'EXCLUÍDO'
    ];

    /**
     * @return Descrição \App\Models\Negocio
     **/
    public function getStatus()
    {
        return $this->desc_status[($this->status-1)];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function motivoPerdaNegocio()
    {
        return $this->belongsTo(\App\Models\MotivoPerdaNegocio::class)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function organizacao()
    {
        return $this->belongsTo(\App\Models\Organizacao::class)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function pessoa()
    {
        return $this->belongsTo(\App\Models\Pessoa::class)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function tableaPreco()
    {
        return $this->belongsTo(\App\Models\ProdutoTipoProduto::class)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function usuarioOperacao()
    {
        return $this->belongsTo(\App\Models\User::class)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function servicos()
    {
        return $this->belongsTo(\App\Models\ProdutoTipoProduto::class)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function produtos()
    {
        return $this->belongsToMany(\App\Models\ProdutoTipoProduto::class, 'negocio_produtos', 'negocio_id', 'produto_tipo_produto_id');
    }

    /**
     * Return Endereço on Negocio
     *
     * @var Object
     */
    public function endereco()
    {
        return $this->hasOne('App\Models\Endereco')->withTrashed();
    }

    /**
     * Return Array Itens on Negocio
     *
     * @var Array
     */
    public function itens()
    {
        return $this->hasMany('App\Models\Item', 'negocio_id', 'id');
    }

    /**
     * Get data format Y-m-d
     *
     * @return Date
    */
    public function getDataNegocio()
    {
        if ($this->data_criacao) {
            return $this->data_criacao->format('d/m/Y');
        }
        return null;
    }

    /**
     * Get data format d/m/Y
     *
     * @return Date
    */
    public function getDataFechamento()
    {
        if ($this->data_fechamento) {
            return $this->data_fechamento->format('d/m/Y');
        }
        return null;
    }

    /**
     * Get data format Y-m-d
     *
     * @return Date
    */
    public function getVencimentoNegocio()
    {
        if ($this->data_vencimento) {
            return $this->data_vencimento->format('d/m/Y');
        }
        return null;
    }

    /**
    * Get data format d/m/Y
    *
    * @return Date
    */
    public function getDataPerda()
    {
        if ($this->data_perda) {
            return $this->data_perda->format('d/m/Y');
        }
        return null;
    }

    /**
     * Get data format d/m/Y
     *
     * @return Date
    */
    public function getDataCriacao()
    {
        if ($this->data_criacao) {
            return $this->data_criacao->format('d/m/Y');
        }
        return null;
    }

    /**
     * Get data format d/m/Y
     *
     * @return Date
    */
    public function getDataGanho()
    {
        if ($this->data_ganho) {
            return $this->data_ganho->format('d/m/Y');
        }
        return null;
    }

    /**
     * Get Valor format 00.00
     *
     * @return Date
    */
    public function getValor()
    {
        if ($this->valor) {
            return number_format($this->valor, 2);
        }
        return (float) '00.00';
    }

    public function lancamentosReceber()
    {
        $item               = $this->itens()->first();
        if (isset($item->pedido_id)) {
            $lancamentoRecebers = LancamentoReceber::where('pedido_id', $item->pedido_id)->get();
            return $lancamentoRecebers;
        } else {
            $lancamentoRecebers = LancamentoReceber::where('negocio_id', $this->id)->get();
            return $lancamentoRecebers;
        }
    }
}
