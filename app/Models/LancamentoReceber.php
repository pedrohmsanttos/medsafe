<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class LancamentoReceber
 * @package App\Models
 * @version February 18, 2019, 5:36 pm UTC
 *
 * @property \App\Models\Cliente cliente
 * @property \Illuminate\Database\Eloquent\Collection ganhoNegocios
 * @property \Illuminate\Database\Eloquent\Collection negocioProdutos
 * @property \Illuminate\Database\Eloquent\Collection organizacaoEnderecos
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection pessoaEnderecos
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property integer cliente_id
 * @property date data_vencimento
 * @property date data_emissao
 * @property string numero_documento
 */
class LancamentoReceber extends Model
{
    use SoftDeletes;

    public $table = 'lancamentos_receber';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'cliente_id',
        'data_vencimento',
        'data_emissao',
        'valor_titulo',
        'numero_documento',
        'negocio_id',
        'pedido_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'cliente_id' => 'integer',
        'data_vencimento' => 'date',
        'data_emissao' => 'date',
        'valor_titulo' => 'string',
        'numero_documento' => 'string',
        'negocio_id' => 'string',
        'pedido_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];


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
     * Get titulo
     *
     * @return String
    */
    public function getTitulo()
    {
        return 'Nº '. str_pad($this->id, 8, "0", STR_PAD_LEFT) . ' | R$' . number_format((float)$this->valor_titulo, 2, '.', '');
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

    public function getStatus()
    {
        $receber = BaixaReceber::where('lancamentoreceber_id', $this->id)->first();
        if (!empty($receber)) {
            return true;
        }
        return false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id')->withTrashed();
    }
}
