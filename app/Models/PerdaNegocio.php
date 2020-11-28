<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PerdaNegocio
 * @package App\Models
 * @version February 7, 2019, 6:47 pm UTC
 *
 * @property \App\Models\MotivoPerdaNegocio motivoPerdaNegocio
 * @property \App\Models\User user
 * @property \Illuminate\Database\Eloquent\Collection negocioProdutos
 * @property \Illuminate\Database\Eloquent\Collection organizacaoEnderecos
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection pessoaEnderecos
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property string comentario
 * @property integer negocio_id
 * @property integer usuario_operacao_id
 * @property date data_perda
 */
class PerdaNegocio extends Model
{
    use SoftDeletes;

    public $table = 'perda_negocios';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'comentario',
        'negocio_id',
        'usuario_operacao_id',
        'data_perda'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'comentario' => 'string',
        'negocio_id' => 'integer',
        'usuario_operacao_id' => 'integer',
        'data_perda' => 'date'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'negocio_id' => 'required',
        'usuario_operacao_id' => 'required',
        'data_perda' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function motivoPerdaNegocio()
    {
        return $this->belongsTo(\App\Models\MotivoPerdaNegocio::class)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class)->withTrashed();
    }

    /**
     * Get data format d/m/Y
     *
     * @return Date
    */
    public function getDataPerda()
    {
        if ($this->data_perda) {
            return $this->data_perda->format('d/m/Y');
        }
        return null;
    }

    /**
     * Get User
     *
     * @return String
    */
    public function getUsuarioOperacao()
    {
        if ($this->usuario_operacao_id) {
            $user = User::find($this->usuario_operacao_id)->withTrashed()->first();
            if (!empty($user)) {
                return $user->name;
            }
            return 'Não definido!';
        }
        return null;
    }

    /**
     * Get Negócio
     *
     * @return String
    */
    public function getNegocio()
    {
        if ($this->negocio_id) {
            $negocio = Negocio::find($this->negocio_id)->withTrashed()->first();
            if (!empty($negocio)) {
                return $negocio->titulo;
            }
            return 'Não definido!';
        }
        return null;
    }
}
