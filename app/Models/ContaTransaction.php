<?php

namespace App\Models;

use Eloquent as Model;
use App\Traits\ContaBancariaTrait;

/**
 * Class ContaTransaction
 * @package App\Models
 * @version May 23, 2019, 5:54 pm UTC
 *
 * @property \App\Models\ContasBancaria contaBancaria
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection
 * @property integer conta_bancaria_id
 * @property float valor
 * @property string hash
 * @property string tipo
 * @property boolean accepted
 * @property string meta
 */
class ContaTransaction extends Model
{
    use ContaBancariaTrait;

    public $table = 'conta_transactions';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'conta_bancaria_id',
        'valor',
        'hash',
        'tipo',
        'accepted',
        'meta'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'conta_bancaria_id' => 'integer',
        'valor' => 'float',
        'hash' => 'string',
        'tipo' => 'string',
        'accepted' => 'boolean',
        'meta' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id' => 'required',
        'valor' => 'required',
        'hash' => 'required',
        'tipo' => 'required',
        'accepted' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function contaBancaria()
    {
        return $this->belongsTo(\App\Models\ContasBancaria::class, 'conta_bancaria_id');
    }

    public function getTitulo()
    {
        $log = json_decode($this->meta);
        
        return $log->titulo;
    }
}
