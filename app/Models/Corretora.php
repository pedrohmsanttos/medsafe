<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Corretora
 * @package App\Models
 * @version March 27, 2019, 2:03 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection Corretore
 * @property \Illuminate\Database\Eloquent\Collection ganhoNegocios
 * @property \Illuminate\Database\Eloquent\Collection negocioProdutos
 * @property \Illuminate\Database\Eloquent\Collection organizacaoEnderecos
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection pessoaEnderecos
 * @property \Illuminate\Database\Eloquent\Collection produtos
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property string descricao
 * @property string cnpj
 * @property string telefone
 * @property string email
 * @property string susep
 */
class Corretora extends Model
{
    use SoftDeletes;

    public $table = 'corretoras';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'descricao',
        'cnpj',
        'telefone',
        'email',
        'susep',
        'inscricao_municipal'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'descricao' => 'string',
        'cnpj' => 'string',
        'telefone' => 'string',
        'email' => 'string',
        'susep' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function corretores()
    {
        return $this->hasMany(\App\Models\Corretore::class);
    }
}
