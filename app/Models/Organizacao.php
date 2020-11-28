<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Organizacao
 * @package App\Models
 * @version January 17, 2019, 6:47 pm UTC
 *
 * @property \App\Models\Faturamento faturamento
 * @property \Illuminate\Database\Eloquent\Collection negocioProdutos
 * @property \Illuminate\Database\Eloquent\Collection Negocio
 * @property \Illuminate\Database\Eloquent\Collection organizacaoEnderecos
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection pessoaEnderecos
 * @property \Illuminate\Database\Eloquent\Collection produtos
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property string nome
 * @property string telefone
 * @property string email
 * @property integer faturamento_id
 */
class Organizacao extends Model
{
    use SoftDeletes;

    public $table = 'organizacaos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'nome',
        'telefone',
        'email',
        'faturamento_id',
        'organizacao_nome'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nome' => 'string',
        'telefone' => 'string',
        'email' => 'string',
        'organizacao_nome' => 'string',
        'faturamento_id' => 'integer'
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
    public function faturamento()
    {
        return $this->belongsTo(\App\Models\Faturamentos::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function negocios()
    {
        return $this->hasMany(\App\Models\Negocio::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function enderecos()
    {
        return $this->belongsToMany(\App\Models\Endereco::class, 'organizacao_enderecos');
    }
}
