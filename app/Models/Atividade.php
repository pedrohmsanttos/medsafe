<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Atividade
 * @package App\Models
 * @version February 1, 2019, 4:11 pm UTC
 *
 * @property \App\Models\User user
 * @property \App\Models\User user
 * @property \App\Models\Negocio negocio
 * @property \App\Models\TipoAtividade tipoAtividade
 * @property \Illuminate\Database\Eloquent\Collection negocioProdutos
 * @property \Illuminate\Database\Eloquent\Collection organizacaoEnderecos
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection pessoaEnderecos
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property integer negocio_id
 * @property string assunto
 * @property date data
 * @property time hora
 * @property time duracao
 * @property string notas
 * @property string urlProposta
 * @property integer tipo_atividade_id
 * @property string realizada
 * @property date dataVencimento
 * @property integer criador_id
 * @property integer atribuido_id
 */
class Atividade extends Model
{
    use SoftDeletes;

    public $table = 'atividades';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'negocio_id',
        'assunto',
        'data',
        'hora',
        'duracao',
        'notas',
        'urlProposta',
        'tipo_atividade_id',
        'realizada',
        'dataVencimento',
        'criador_id',
        'atribuido_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'negocio_id' => 'integer',
        'assunto' => 'string',
        'data' => 'date',
        'notas' => 'string',
        'urlProposta' => 'string',
        'tipo_atividade_id' => 'integer',
        'realizada' => 'string',
        'dataVencimento' => 'date',
        'criador_id' => 'integer',
        'atribuido_id' => 'integer'
    ];

    /**
     * Validation rules on create
     *
     * @var array
     */
    public static $rules = [
        'assunto' => 'required|max:255',
        'negocio_id' => 'required',
        'data' => 'required',
        'hora' => 'required|date_format:H:i',
        'duracao' => 'date_format:H:i',
        'tipo_atividade_id' => 'required',
        'criador_id' => 'required',
        'atribuido_id' => 'required',
        // 'urlProposta' => 'url|max:255'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function atribuido()
    {
        return $this->belongsTo(\App\Models\User::class)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function criador()
    {
        return $this->belongsTo(\App\Models\User::class)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function negocio()
    {
        return $this->belongsTo(\App\Models\Negocio::class)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function tipoAtividade()
    {
        return $this->belongsTo(\App\Models\TipoAtividade::class)->withTrashed();
    }
}
