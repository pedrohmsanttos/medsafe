<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BaixaReceber
 * @package App\Models
 * @version April 5, 2019, 6:59 pm UTC
 *
 * @property \App\Models\LancamentosPagar lancamentosPagar
 * @property \App\Models\FormasDePagamento formasDePagamento
 * @property \Illuminate\Database\Eloquent\Collection ganhoNegocios
 * @property \Illuminate\Database\Eloquent\Collection negocioProdutos
 * @property \Illuminate\Database\Eloquent\Collection organizacaoEnderecos
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection pessoaEnderecos
 * @property \Illuminate\Database\Eloquent\Collection produtos
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property string caixa_banco
 * @property date disponibilidade
 * @property date baixa
 * @property float valor_pago
 * @property float valor_residual
 * @property integer pagamento_id
 * @property integer lancamentoreceber_id
 */
class BaixaReceber extends Model
{
    use SoftDeletes;

    public $table = 'baixa_contas_receber';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'caixa_banco',
        'disponibilidade',
        'baixa',
        'valor_pago',
        'valor_residual',
        'pagamento_id',
        'conta_bancaria_id',
        'lancamentoreceber_id',
        'plano_de_conta_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'caixa_banco' => 'string',
        'disponibilidade' => 'date',
        'baixa' => 'date',
        'valor_pago' => 'float',
        'valor_residual' => 'float',
        'pagamento_id' => 'integer',
        'conta_bancaria_id' => 'integer',
        'lancamentoreceber_id' => 'integer',
        'plano_de_conta_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'baixa' => 'required',
        'valor_pago' => 'required',
        'pagamento_id' => 'required',
        'conta_bancaria_id' => 'required',
        'lancamentoreceber_id' => 'required',
        'plano_de_conta_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function lancamentosReceber()
    {
        return $this->belongsTo(\App\Models\LancamentoReceber::class, 'lancamentoreceber_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function formasDePagamento()
    {
        return $this->belongsTo(\App\Models\FormaDePagamento::class, 'pagamento_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function contasBancaria()
    {
        return $this->belongsTo(\App\Models\ContaBancaria::class, 'conta_bancaria_id')->withTrashed();
    }

    /**
     * Get data format d/m/Y
     *
     * @return Date
    */
    public function getDisponibilidade()
    {
        if ($this->disponibilidade) {
            return $this->disponibilidade->format('d/m/Y');
        }
        return null;
    }

    /**
     * Get data format d/m/Y
     *
     * @return Date
    */
    public function getBaixa()
    {
        if ($this->baixa) {
            return $this->baixa->format('d/m/Y');
        }
        return null;
    }
}
