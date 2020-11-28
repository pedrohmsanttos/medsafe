<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Item
 * @package App\Models
 * @version May 15, 2019, 7:19 pm UTC
 *
 * @property \App\Models\Negocio negocio
 * @property \App\Models\Pedido pedido
 * @property \App\Models\ProdutoTipoProduto tabelaPreco
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection
 * @property integer pedido_id
 * @property integer negocio_id
 * @property integer tabela_preco_id
 * @property float valor
 * @property integer quantidade
 */
class Item extends Model
{
    //use SoftDeletes;

    public $table = 'itens';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'pedido_id',
        'negocio_id',
        'tabela_preco_id',
        'valor',
        'quantidade'
    
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'pedido_id' => 'integer',
        'negocio_id' => 'integer',
        'tabela_preco_id' => 'integer',
        'valor' => 'float',
        'quantidade' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id' => 'required',
        'quantidade' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function negocio()
    {
        return $this->belongsTo(\App\Models\Negocio::class, 'negocio_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function pedido()
    {
        return $this->belongsTo(\App\Models\Pedido::class, 'pedido_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function tabelaPreco()
    {
        return $this->belongsTo(\App\Models\ProdutoTipoProduto::class, 'tabela_preco_id');
    }

    public function subTotal()
    {
        return $this->valor * $this->quantidade;
    }

    public function getDataCriacao() {
        $time = strtotime($this->created_at);
        $myFormatForView = date("d/m/y", $time);
        return $myFormatForView;
    }
}
