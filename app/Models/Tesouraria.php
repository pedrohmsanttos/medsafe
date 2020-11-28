<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Tesouraria
 * @package App\Models
 * @version April 5, 2019, 2:23 pm UTC
 *
 * @property \App\Models\Cliente cliente
 * @property \App\Models\FormasDePagamento formasDePagamento
 * @property \App\Models\Fornecedor fornecedor
 * @property \App\Models\PlanoDeConta planoDeConta
 * @property \Illuminate\Database\Eloquent\Collection ganhoNegocios
 * @property \Illuminate\Database\Eloquent\Collection negocioProdutos
 * @property \Illuminate\Database\Eloquent\Collection organizacaoEnderecos
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection pessoaEnderecos
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property integer plano_de_contas_id
 * @property integer formas_de_pagamento_id
 * @property integer fornecedor_id
 * @property integer cliente_id
 * @property string tipo
 * @property string valor
 * @property string numero_documento
 * @property date data_emissao
 * @property date data_vencimento
 * @property date data_disponibilidade
 */
class Tesouraria extends Model
{
    use SoftDeletes;

    public $table = 'tesourarias';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'plano_de_contas_id',
        'formas_de_pagamento_id',
        'fornecedor_id',
        'cliente_id',
        'tipo',
        'valor',
        'numero_documento',
        'data_emissao',
        'data_vencimento',
        'data_disponibilidade',
        'conta_bancaria_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'plano_de_contas_id' => 'integer',
        'formas_de_pagamento_id' => 'integer',
        'conta_bancaria_id' => 'integer',
        'fornecedor_id' => 'integer',
        'cliente_id' => 'integer',
        'tipo' => 'string',
        'valor' => 'string',
        'numero_documento' => 'string',
        'data_emissao' => 'date',
        'data_vencimento' => 'date',
        'data_disponibilidade' => 'date'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'plano_de_contas_id' => 'required',
        'formas_de_pagamento_id' => 'required',
        'tipo' => 'required',
        'valor' => 'required',
        'fornecedor_id' => 'required_without:cliente_id',
        'cliente_id' => 'required_without:fornecedor_id'
    ];

    public static $upRules = [
        'plano_de_contas_id' => 'required',
        'formas_de_pagamento_id' => 'required',
        'valor' => 'required',
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
    public function formasDePagamento()
    {
        return $this->belongsTo(\App\Models\FormasDePagamento::class)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function fornecedor()
    {
        return $this->belongsTo(\App\Models\Fornecedor::class)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function planoDeConta()
    {
        return $this->belongsTo(\App\Models\PlanoDeContas::class, 'plano_de_contas_id')->withTrashed();
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
    public function getDataEmissao()
    {
        if ($this->data_emissao) {
            return $this->data_emissao->format('d/m/Y');
        }
        return null;
    }

    /**
     * Get data format d/m/Y
     *
     * @return Date
    */
    public function getDataDisponibilidade()
    {
        if ($this->data_disponibilidade) {
            return $this->data_disponibilidade->format('d/m/Y');
        }
        return null;
    }
}
