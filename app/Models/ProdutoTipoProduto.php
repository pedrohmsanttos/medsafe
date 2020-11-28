<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProdutoTipoProduto
 * @package App\Models
 * @version January 18, 2019, 6:02 pm UTC
 *
 * @property \App\Models\CategoriaProduto categoriaProduto
 * @property \App\Models\Produto produto
 * @property \App\Models\TipoProduto tipoProduto
 * @property \Illuminate\Database\Eloquent\Collection negocioProdutos
 * @property \Illuminate\Database\Eloquent\Collection organizacaoEnderecos
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection pessoaEnderecos
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property float valor
 * @property integer produto_id
 * @property integer tipo_produto_id
 * @property integer categoria_produto_id
 */
class ProdutoTipoProduto extends Model
{
    use SoftDeletes;

    public $table = 'produto_tipo_produtos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'valor',
        'produto_id',
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
        'valor' => 'float',
        'produto_id' => 'integer',
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
    public function categoriaProduto()
    {
        return $this->belongsTo(\App\Models\CategoriaProdutos::class)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function produto()
    {
        return $this->belongsTo(\App\Models\Produtos::class)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function tipoProduto()
    {
        return $this->belongsTo(\App\Models\TipoProdutos::class)->withTrashed();
    }

    public function titulo()
    {
        $produto   = $this->produto()->first()->descricao;
        $categoria = $this->categoriaProduto()->first()->descricao;
        $tipo      = $this->tipoProduto()->first()->descricao;

        return $produto . ' - ' . $categoria . ' [' . $tipo. ']';
    }
}
