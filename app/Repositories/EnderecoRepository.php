<?php

namespace App\Repositories;

use App\Models\Endereco;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class EnderecoRepository
 * @package App\Repositories
 * @version December 28, 2018, 3:23 pm UTC
 *
 * @method Endereco findWithoutFail($id, $columns = ['*'])
 * @method Endereco find($id, $columns = ['*'])
 * @method Endereco first($columns = ['*'])
*/
class EnderecoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'rua',
        'bairro',
        'municipio',
        'uf',
        'cep'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Endereco::class;
    }
}
