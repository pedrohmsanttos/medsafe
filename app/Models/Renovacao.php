<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Renovacao
 * @package App\Models
 * @version August 9, 2019, 8:26 pm UTC
 *
 * @property \App\Models\Cliente cliente
 * @property \App\Models\Corretore corretor
 * @property \App\Models\Pedido pedido
 * @property \Illuminate\Database\Eloquent\Collection beneficios
 * @property \Illuminate\Database\Eloquent\Collection coberturas
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property integer corretor_id
 * @property integer pedido_id
 * @property integer cliente_id
 * @property string numero
 * @property string endosso
 * @property string ci
 * @property string classe_bonus
 * @property string proposta
 * @property integer status
 */
class Renovacao extends Model
{
    use SoftDeletes;

    public $table = 'apolices';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'corretor_id',
        'pedido_id',
        'cliente_id',
        'numero',
        'endosso',
        'ci',
        'classe_bonus',
        'proposta',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'corretor_id' => 'integer',
        'pedido_id' => 'integer',
        'cliente_id' => 'integer',
        'numero' => 'string',
        'endosso' => 'string',
        'ci' => 'string',
        'classe_bonus' => 'string',
        'proposta' => 'string',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id' => 'required',
        'corretor_id' => 'required',
        'pedido_id' => 'required',
        'cliente_id' => 'required',
        'numero' => 'required',
        'endosso' => 'required',
        'ci' => 'required',
        'classe_bonus' => 'required',
        'proposta' => 'required'
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
    public function corretor()
    {
        return $this->belongsTo(\App\Models\Corretore::class, 'corretor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function pedido()
    {
        return $this->belongsTo(\App\Models\Pedido::class, 'pedido_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function beneficios()
    {
        return $this->hasMany(\App\Models\Beneficio::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function coberturas()
    {
        return $this->hasMany(\App\Models\Cobertura::class);
    }
}
