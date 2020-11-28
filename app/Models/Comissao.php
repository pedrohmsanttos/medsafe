<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Comissao
 * @package App\Models
 * @version August 22, 2019, 5:08 pm UTC
 *
 * @property \App\Models\Checkout checkout
 * @property \App\Models\Corretore corretor
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
 * @property integer checkout_id
 * @property string percentual_comissao
 * @property string comissao
 * @property string valor
 * @property string status_aprovacao
 */
class Comissao extends Model
{
    use SoftDeletes;

    public $table = 'comissoes';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'corretor_id',
        'checkout_id',
        'percentual_comissao',
        'comissao',
        'valor',
        'status_aprovacao'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'corretor_id' => 'integer',
        'checkout_id' => 'integer',
        'percentual_comissao' => 'string',
        'comissao' => 'string',
        'valor' => 'string',
        'status_aprovacao' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'status_aprovacao' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function checkout()
    {
        return $this->belongsTo(\App\Models\Checkout::class, 'checkout_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function corretor()
    {
        return $this->belongsTo(\App\Models\Corretoradm::class, 'corretor_id');
    }
    
}
