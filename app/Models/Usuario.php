<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Usuario
 * @package App\Models
 * @version March 8, 2019, 5:26 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection Atividade
 * @property \Illuminate\Database\Eloquent\Collection Endereco
 * @property \Illuminate\Database\Eloquent\Collection GanhoNegocio
 * @property \Illuminate\Database\Eloquent\Collection negocioProdutos
 * @property \Illuminate\Database\Eloquent\Collection Negocio
 * @property \Illuminate\Database\Eloquent\Collection organizacaoEnderecos
 * @property \Illuminate\Database\Eloquent\Collection Pedido
 * @property \Illuminate\Database\Eloquent\Collection PerdaNegocio
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection pessoaEnderecos
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property string login
 * @property string name
 * @property string email
 * @property string password
 * @property string remember_token
 */
class Usuario extends Model
{
    use SoftDeletes;

    public $table = 'users';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'login',
        'name',
        'email',
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'login' => 'string',
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'remember_token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'login' => 'required',
        'name' => 'required',
        'email' => 'required|unique:users',
        'password' => 'required|min:4|max:10',
        'roles' => 'required',
    ];
    /**
     * Validation rules
     *
     * @var array
     */
    public static $upRules = [
        'login' => 'required',
        'name' => 'required',
        'email' => 'required|unique:users,email,{{$id}}',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function atividades()
    {
        return $this->hasMany(\App\Models\Atividade::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function enderecos()
    {
        return $this->hasMany(\App\Models\Endereco::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function ganhoNegocios()
    {
        return $this->hasMany(\App\Models\GanhoNegocio::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function negocios()
    {
        return $this->hasMany(\App\Models\Negocio::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function pedidos()
    {
        return $this->hasMany(\App\Models\Pedido::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function perdaNegocios()
    {
        return $this->hasMany(\App\Models\PerdaNegocio::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class, 'role_user');
    }
}
