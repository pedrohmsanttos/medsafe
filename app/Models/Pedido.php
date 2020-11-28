<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

/**
 * Class Pedido
 * @package App\Models
 * @version February 18, 2019, 5:35 pm UTC
 *
 * @property \App\Models\Cliente cliente
 * @property \App\Models\StatusPedido statusPedido
 * @property \App\Models\User user
 * @property \Illuminate\Database\Eloquent\Collection ganhoNegocios
 * @property \Illuminate\Database\Eloquent\Collection negocioProdutos
 * @property \Illuminate\Database\Eloquent\Collection organizacaoEnderecos
 * @property \Illuminate\Database\Eloquent\Collection PedidoTipoProduto
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection pessoaEnderecos
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property integer status_pedido_id
 * @property integer cliente_id
 * @property integer corretor_id
 * @property integer usuario_operacao_id
 * @property date data_vencimento
 */
class Pedido extends Model
{
    use SoftDeletes;

    public $table = 'pedidos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'status_pedido_id',
        'cliente_id',
        'corretor_id',
        'usuario_operacao_id',
        'data_vencimento',
        'valor_total',
        'valor_desconto',
        'nome_completo',
        'telefone',
        'email',
        'cpf',
        'beneficio_terceiros'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'status_pedido_id' => 'integer',
        'cliente_id' => 'integer',
        'corretor_id' => 'integer',
        'usuario_operacao_id' => 'integer',
        'data_vencimento' => 'date',
        'valor_total' => 'string',
        'valor_desconto' => 'string',
        'nome_completo' =>'string',
        'telefone' =>'string',
        'email' =>'string',
        'cpf' =>'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'cliente_id' => 'required',
        'beneficio_terceiros' => 'required',
        'data_vencimento' => 'required',
        'itens' => 'required|min:5'
    ];

    /**
     * Validation rules on create
     *
     * @var array
     */
    public static $rulesEndereco = [
        'cep' => 'required',
        'rua' => 'required',
        'numero' => 'required',
        'bairro' => 'required',
        'municipio' => 'required',
        'email' => 'required',
        'telefone' => 'required',
        'nome_completo' => 'required',
        'cpf' => 'required',
        'uf' => 'required',
        'cliente_id' => 'required',
        'beneficio_terceiros' => 'required',
        'data_vencimento' => 'required',
        'itens' => 'required|min:5'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function cliente()
    {
        return $this->belongsTo(\App\Models\Cliente::class)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function statusPedido()
    {
        return $this->belongsTo(\App\Models\StatusPedido::class)->withTrashed();
    }

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'usuario_operacao_id', 'id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function pedidoTipoProdutos()
    {
        return $this->hasMany(\App\Models\PedidoTipoProduto::class, 'pedido_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function checkouts()
    {
        return $this->hasMany(\App\Models\Checkout::class, 'pedido_id', 'id');
    }

    /**
     * Get data format d/m/Y
     *
     * @return Date
    */
    public function getDataVencimento()
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
    public function getDataPedido()
    {
        if ($this->created_at) {
            return $this->created_at->format('d/m/Y');
        }
        return null;
    }

    public function getItensPedido()
    {
        $itens = PedidoTipoProduto::where('pedido_id', $this->id)->get();
        return $itens;
    }

    public function getLancamentos()
    {
        $lancamentos = LancamentoReceber::where('pedido_id', $this->id)->get();
        return $lancamentos;
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

    public function getStatus()
    {
        $lancamentos = LancamentoReceber::where('pedido_id', $this->id)->get();

        $baixas = DB::table('pedidos')
            ->select('lancamentos_receber.id as lancamento_id')
            ->join('lancamentos_receber', function ($join) {
                $join->on('pedidos.id', '=', 'lancamentos_receber.pedido_id');
            })->join('baixa_contas_receber', function ($join) {
                $join->on('lancamentos_receber.id', '=', 'baixa_contas_receber.lancamentoreceber_id');
            })->where('pedidos.id', $this->id)->get();
        
        if (count($lancamentos) === count($baixas) && count($lancamentos) > 0) {
            return true;
        }

        return false;
    }
}
