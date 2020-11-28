<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PedidoTipoProduto
 * @package App\Models
 * @version February 18, 2019, 5:36 pm UTC
 *
 * @property \App\Models\CategoriaProduto categoriaProduto
 * @property \App\Models\Pedido pedido
 * @property \App\Models\Produto produto
 * @property \App\Models\TipoProduto tipoProduto
 * @property \Illuminate\Database\Eloquent\Collection ganhoNegocios
 * @property \Illuminate\Database\Eloquent\Collection negocioProdutos
 * @property \Illuminate\Database\Eloquent\Collection organizacaoEnderecos
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection pessoaEnderecos
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property integer pedido_id
 * @property integer categoria_produto_id
 * @property integer tipo_produto_id
 * @property integer produto_id
 * @property float valor
 * @property float valor_parcela
 * @property float valor_desconto
 * @property float valor_final
 * @property integer quantidade_parcela
 * @property integer quantidade
 */
class PedidoTipoProduto extends Model
{
    use SoftDeletes;

    public $table = 'pedido_tipo_produtos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'pedido_id',
        'categoria_produto_id',
        'tipo_produto_id',
        'produto_id',
        'valor',
        'valor_parcela',
        'valor_desconto',
        'valor_final',
        'quantidade_parcela',
        'quantidade'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'pedido_id' => 'integer',
        'categoria_produto_id' => 'integer',
        'tipo_produto_id' => 'integer',
        'produto_id' => 'integer',
        'valor' => 'float',
        'valor_parcela' => 'float',
        'valor_desconto' => 'float',
        'valor_final' => 'float',
        'quantidade_parcela' => 'integer',
        'quantidade' => 'integer'
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
    public function pedido()
    {
        return $this->belongsTo(\App\Models\Pedido::class)->withTrashed();
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
}
