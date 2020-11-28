<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Endereco
 * @package App\Models
 * @version December 28, 2018, 3:23 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property string rua
 * @property string bairro
 * @property string municipio
 * @property string uf
 * @property string cep
 * @property string numero
 */
class Endereco extends Model
{
    use SoftDeletes;

    public $table = 'enderecos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'rua',
        'bairro',
        'municipio',
        'uf',
        'cep',
        'numero',
        'cliente_id',
        'fornecedor_id',
        'pedido_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'rua' => 'string',
        'bairro' => 'string',
        'municipio' => 'string',
        'uf' => 'string',
        'cep' => 'string',
        'numero' => 'string',
        'cliente_id' => 'integer',
        'fornecedor_id' => 'integer',
        'pedido_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
    
}
