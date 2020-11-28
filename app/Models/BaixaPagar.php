<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BaixaPagar
 * @package App\Models
 * @version April 9, 2019, 6:21 pm UTC
 *
 * @property \App\Models\ContasBancaria contasBancaria
 * @property \App\Models\LancamentosPagar lancamentosPagar
 * @property \App\Models\FormasDePagamento formasDePagamento
 * @property \Illuminate\Database\Eloquent\Collection ganhoNegocios
 * @property \Illuminate\Database\Eloquent\Collection negocioProdutos
 * @property \Illuminate\Database\Eloquent\Collection organizacaoEnderecos
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection pessoaEnderecos
 * @property \Illuminate\Database\Eloquent\Collection produtos
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property date disponibilidade
 * @property date baixa
 * @property float valor_pago
 * @property float valor_residual
 * @property integer conta_bancaria_id
 * @property integer pagamento_id
 * @property integer lancamentopagar_id
 */
class BaixaPagar extends Model
{
    use SoftDeletes;

    public $table = 'baixa_contas_pagar';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'disponibilidade',
        'baixa',
        'valor_pago',
        'valor_residual',
        'conta_bancaria_id',
        'pagamento_id',
        'lancamentopagar_id',
        'plano_de_conta_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'disponibilidade' => 'date',
        'baixa' => 'date',
        'valor_pago' => 'float',
        'valor_residual' => 'float',
        'conta_bancaria_id' => 'integer',
        'pagamento_id' => 'integer',
        'lancamentopagar_id' => 'integer',
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
        'lancamentopagar_id' => 'required',
        'plano_de_conta_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function contasBancaria()
    {
        return $this->belongsTo(\App\Models\ContaBancaria::class, 'conta_bancaria_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function lancamentosPagar()
    {
        return $this->belongsTo(\App\Models\LancamentoPagar::class, 'lancamentopagar_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function formasDePagamento()
    {
        return $this->belongsTo(\App\Models\FormaDePagamento::class, 'pagamento_id')->withTrashed();
    }
}
