<?php

namespace App\Repositories;

use App\Models\Corretora;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CorretoraRepository
 * @package App\Repositories
 * @version March 27, 2019, 2:03 pm UTC
 *
 * @method Corretora findWithoutFail($id, $columns = ['*'])
 * @method Corretora find($id, $columns = ['*'])
 * @method Corretora first($columns = ['*'])
*/
class CorretoraRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'descricao',
        'cnpj',
        'telefone',
        'email',
        'susep'
    ];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $clienteAttributes = [
       'descricao',
        'cnpj',
        'telefone',
        'email',
        'susep'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Corretora::class;
    }

    /**
     * Mapping of filter
     **/
    public function filter($filters)
    {
        if(isset($filters) && isset($filters['search']) && isset($filters['searchFields']) ){
            $search       = explode(';', $filters['search']);
            $searchFields = explode(';', $filters['searchFields']);
            foreach ($search as $index => $filter) {
                $tmpBuscar = explode(':', $filter);
                $tmpFiltro = explode(':', $searchFields[$index]);
                $objTemp   = new \stdClass();
                $objTemp->campo  = $this->clienteAttributes[$tmpBuscar[0]];
                $objTemp->valor  = $tmpBuscar[1];
                $objTemp->filtro = ($tmpFiltro[1] == 'like') ? 'Contém' : 'Igual';

                array_push($this->filters, $objTemp);
            }
        }
        
        if(isset($filters) && isset($filters['orderBy']) && isset($filters['sortedBy'])){
            $orderBy         = $filters['orderBy'];
            $sortedBy        = $filters['sortedBy'];
            $objTemp         = new \stdClass();
            $objTemp->campo  = $this->clienteAttributes[$orderBy];
            $objTemp->valor  = ($sortedBy == 'asc') ? 'Crescente' : 'Decrescente';
            $objTemp->filtro = 'Ordem';

            array_push($this->filters, $objTemp);
        }
        
        if(isset($filters) && isset($filters['situacao'])){
            $situacao         = $filters['situacao'];
            $objTemp         = new \stdClass();
            $objTemp->campo  = 'Situação';
            $objTemp->valor  = ($situacao == 'all') ? 'Todos' : $situacao;
            $objTemp->filtro = 'Situação';

            array_push($this->filters, $objTemp);
        }

        return $this->filters;
    }
}
