<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Produtos
 * @package App\Models
 * @version January 14, 2019, 6:50 pm UTC
 *
 * @property \App\Models\CategoriaProduto categoriaProduto
 * @property \App\Models\TipoProduto tipoProduto
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property string descricao
 * @property float valor
 * @property integer tipo_produto_id
 * @property integer categoria_produto_id
 */
class Produtos extends Model
{
    use SoftDeletes;

    public $table = 'produtos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'descricao',
        'valor',
        'tipo_produto_id',
        'categoria_produto_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'descricao' => 'string',
        'valor' => 'float',
        'tipo_produto_id' => 'integer',
        'categoria_produto_id' => 'integer'
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
    //public function categoriaProduto()
    //{
    //    return $this->belongsTo(\App\Models\CategoriaProdutos::class);
    //}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    //public function tipoProduto()
    //{
    //    return $this->belongsTo(\App\Models\TipoProdutos::class);
    //}


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function produtoTipoProduto()
    {
        return $this->belongsTo(\App\Models\ProdutoTipoProduto::class)->withTrashed();
    }
}
