<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ContaBancariaTrait;

/**
 * Class ContaBancaria
 * @package App\Models
 * @version January 11, 2019, 3:45 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property string classificacao
 * @property string descricao
 * @property string numeroConta
 * @property string numeroAgencia
 * @property date dataSaldoInicial
 * @property decimal saldoInicial
 * @property string caixa
 * @property string banco
 * @property string operacao
 */
class ContaBancaria extends Model
{
    use SoftDeletes;
    use ContaBancariaTrait;

    public $table = 'contas_bancarias';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    /**
     * The attributes with names banks.
     *
     * @var array
     */
    private $bancos = [
        '001' => 'Banco do Brasil',
        '351' => 'Banco Santander',
        '033' => 'Banco Santander Brasil',
        '748' => 'Banco Cooperativo Sicredi',
        '004' => 'Banco do Nordeste',
        '041' => 'Banrisul',
        '237' => 'Bradesco',
        '104' => 'Caixa Econômica Federal',
        '399' => 'HSBC',
        '341' => 'Itau',
    ];

    public $fillable = [
        'classificacao',
        'descricao',
        'numeroConta',
        'numeroAgencia',
        'dataSaldoInicial',
        'saldoInicial',
        'caixa',
        'banco',
        'operacao'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'ID' => 'integer',
        'classificacao' => 'string',
        'descricao' => 'string',
        'numeroConta' => 'string',
        'numeroAgencia' => 'string',
        'dataSaldoInicial' => 'datetime:d/m/Y',
        'saldoInicial' => 'float',
        'caixa' => 'string',
        'banco' => 'string',
        'operacao' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'classificacao'    => 'required|max:18',
        'descricao' => 'required|max:50',
        'numeroConta' => 'required',
        'numeroAgencia' => 'required',
        'dataSaldoInicial' => 'required',
        'caixa' => 'required|max:10 ',
        'banco' => 'required',
        'saldoInicial' => 'required'
    ];

    /**
     * Validation rules on update
     *
     * @var array
     */
    public static $upRules = [
        'classificacao'    => 'required|max:18',
        'descricao' => 'required|max:50',
        'numeroConta' => 'required',
        'numeroAgencia' => 'required',
        'dataSaldoInicial' => 'required',
        'caixa' => 'required|max:10 ',
        'banco' => 'required',
        'saldoInicial' => 'required'
    ];

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName()
    {
        return "Ag: $this->numeroAgencia Conta: $this->numeroConta - {$this->getBanco($this->banco)}";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function carteira()
    {
        return $this->hasMany(\App\Models\ContaTransaction::class);
    }

    /**
     * Get the name of Bank.
     *
     * @return string
     */
    public function getBanco($reg)
    {
        if (array_key_exists($reg, $this->bancos)) {
            return $this->bancos[$reg];
        }
        return 'Banco não cadastrado';
    }
}
