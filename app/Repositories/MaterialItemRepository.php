<?php

namespace App\Repositories;

use App\Models\MaterialItem;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MaterialItemRepository
 * @package App\Repositories
 * @version August 28, 2019, 1:47 pm UTC
 *
 * @method MaterialItem findWithoutFail($id, $columns = ['*'])
 * @method MaterialItem find($id, $columns = ['*'])
 * @method MaterialItem first($columns = ['*'])
*/
class MaterialItemRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'arquivo',
        'material_id'
    ];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $clienteAttributes = [
       'arquivo',
        'material_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MaterialItem::class;
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
            $objTemp->filtro = 'Igual/Contém';

            array_push($this->filters, $objTemp);
        }

        return $this->filters;
    }
}
