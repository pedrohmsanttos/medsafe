<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Permissoes
 * @package App\Models
 * @version March 1, 2019, 3:37 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection ganhoNegocios
 * @property \Illuminate\Database\Eloquent\Collection negocioProdutos
 * @property \Illuminate\Database\Eloquent\Collection organizacaoEnderecos
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection pessoaEnderecos
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property string name
 * @property string display_name
 * @property string description
 */
class Permissoes extends Model
{
    use SoftDeletes;

    public $table = 'roles';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'display_name',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'display_name' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name'         => 'string',
        'display_name' => 'string',
        'description'  => 'string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function permissions()
    {
        return $this->belongsToMany(\App\Models\Permission::class, 'permission_role', 'permission_id', 'role_id');
        //return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'role_user');
    }
}
