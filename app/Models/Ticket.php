<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Ticket
 * @package App\Models
 * @version June 12, 2019, 8:51 pm UTC
 *
 * @property \App\Models\Category category
 * @property \App\Models\User user
 * @property \Illuminate\Database\Eloquent\Collection comments
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection
 * @property integer user_id
 * @property integer category_id
 * @property string ticket_id
 * @property string titulo
 * @property string prioridade
 * @property string mensagem
 * @property string status
 */
class Ticket extends Model
{
    use SoftDeletes;

    public $table = 'tickets';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'category_id',
        'titulo',
        'prioridade',
        'mensagem',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'category_id' => 'integer',
        'titulo' => 'string',
        'prioridade' => 'string',
        'mensagem' => 'string',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'category_id' => 'required',
        'titulo' => 'required',
        'mensagem' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function category()
    {
        return $this->belongsTo(\App\Models\CategoriaTicket::class, 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function comments()
    {
        return $this->hasMany(\App\Models\CommentTicket::class);
    }

    public function getStatus()
    {
        if ($this->status == 0) {
            return 'Aguardando Atendimento';
        } elseif ($this->status == 1) {
            return 'Em Atendimento';
        } else {
            return 'Fechado';
        }
    }
}
