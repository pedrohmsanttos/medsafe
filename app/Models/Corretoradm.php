<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Corretoradm
 * @package App\Models
 * @version August 21, 2019, 7:46 pm UTC
 *
 * @property \App\Models\Corretora corretora
 * @property \App\Models\User user
 * @property \Illuminate\Database\Eloquent\Collection apolices
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection tickets
 * @property string nome
 * @property string cpf
 * @property string telefone
 * @property string email
 * @property string celular
 * @property integer corretora_id
 * @property integer user_id
 * @property integer aprovado
 * @property float comissao
 * @property string periodo_de_pagamento
 */
class Corretoradm extends Model
{
    use SoftDeletes;

    public $table = 'corretores';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'nome',
        'cpf',
        'telefone',
        'email',
        'celular',
        'corretora_id',
        'user_id',
        'aprovado',
        'comissao',
        'periodo_de_pagamento'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nome' => 'string',
        'cpf' => 'string',
        'telefone' => 'string',
        'email' => 'string',
        'celular' => 'string',
        'corretora_id' => 'integer',
        'user_id' => 'integer',
        'aprovado' => 'string',
        'comissao' => 'float',
        'periodo_de_pagamento' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'corretora_id' => 'required',
        'nome' => 'required',
        'email' => 'required',
        'cpf' => 'required',
        'aprovado' =>'required',
        'comissao' =>'required',
        'periodo_de_pagamento' =>'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function corretora()
    {
        return $this->belongsTo(\App\Models\Corretora::class, 'corretora_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function apolices()
    {
        return $this->hasMany(\App\Models\Apolice::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function tickets()
    {
        return $this->hasMany(\App\Models\Ticket::class);
    }
}
