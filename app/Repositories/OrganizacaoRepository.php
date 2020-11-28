<?php

namespace App\Repositories;

use App\Models\Organizacao;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class OrganizacaoRepository
 * @package App\Repositories
 * @version January 17, 2019, 6:47 pm UTC
 *
 * @method Organizacao findWithoutFail($id, $columns = ['*'])
 * @method Organizacao find($id, $columns = ['*'])
 * @method Organizacao first($columns = ['*'])
*/
class OrganizacaoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nome',
        'telefone',
        'email',
        'faturamento_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Organizacao::class;
    }
}
