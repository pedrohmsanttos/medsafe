<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Checkout
 * @package App\Models
 * @version May 20, 2019, 6:44 pm UTC
 *
 * @property \App\Models\Cliente cliente
 * @property \App\Models\Negocio negocio
 * @property \App\Models\Pedido pedido
 * @property \App\Models\User user
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection
 * @property integer negocio_id
 * @property integer pedido_id
 * @property integer user_id
 * @property integer cliente_id
 * @property float valor
 * @property integer parcelas
 * @property integer status
 */
class Checkout extends Model
{
    public $table = 'checkouts';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'negocio_id',
        'pedido_id',
        'user_id',
        'cliente_id',
        'valor',
        'parcelas',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'negocio_id' => 'integer',
        'pedido_id' => 'integer',
        'user_id' => 'integer',
        'cliente_id' => 'integer',
        'valor' => 'float',
        'parcelas' => 'integer',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function cliente()
    {
        return $this->belongsTo(\App\Models\Cliente::class, 'cliente_id');
    }

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
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
