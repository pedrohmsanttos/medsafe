<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class NegocioProduto
 * @package App\Models
 * @version February 18, 2019, 7:11 pm UTC
 *
 * @property \App\Models\Negocio negocio
 * @property \App\Models\ProdutoTipoProduto produtoTipoProduto
 * @property \Illuminate\Database\Eloquent\Collection ganhoNegocios
 * @property \Illuminate\Database\Eloquent\Collection organizacaoEnderecos
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection pessoaEnderecos
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property integer produto_tipo_produto_id
 */
class NegocioProduto extends Model
{
    use SoftDeletes;

    public $table = 'negocio_produtos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'produto_tipo_produto_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'negocio_id' => 'integer',
        'produto_tipo_produto_id' => 'integer'
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
    public function negocio()
    {
        return $this->belongsTo(\App\Models\Negocio::class)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function produtoTipoProduto()
    {
        return $this->belongsTo(\App\Models\ProdutoTipoProduto::class)->withTrashed();
    }
}
