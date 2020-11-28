<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PlanoDeContas
 * @package App\Models
 * @version January 11, 2019, 7:37 pm UTC
 *
 * @property \App\Models\ContasBancaria contasBancaria
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property string classificacao
 * @property string descricao
 * @property string tipoConta
 * @property string caixa
 * @property string banco
 * @property string cliente
 * @property string fornecedor
 * @property integer contabancaria_id
 */
class PlanoDeContas extends Model
{
    use SoftDeletes;

    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships; // relation from json

    public $table = 'plano_de_contas';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'classificacao',
        'descricao',
        'tipoConta',
        'caixa',
        'banco',
        'cliente',
        'fornecedor',
        'contabancaria_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'classificacao' => 'string',
        'descricao' => 'string',
        'tipoConta' => 'string',
        'caixa' => 'string',
        'banco' => 'string',
        'cliente' => 'string',
        'fornecedor' => 'string',
        'contabancaria_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'classificacao' => 'required|max:18',
        'descricao' => 'required',
        'tipoConta' => 'required',
        'contabancaria_id' => 'required',
        'plano_de_conta_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function contasBancaria()
    {
        return $this->belongsTo('App\Models\ContaBancaria', 'contabancaria_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function descricaoConta()
    {
        return $this->classificacao . ' - ' . $this->descricao;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     **/
    public function movimentacao()
    {
        return $this->hasManyJson(ContaTransaction::class, 'meta->plano_de_contas_id');
    }
}
