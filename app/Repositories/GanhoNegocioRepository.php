<?php

namespace App\Repositories;

use App\Models\GanhoNegocio;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class GanhoNegocioRepository
 * @package App\Repositories
 * @version February 11, 2019, 6:42 pm UTC
 *
 * @method GanhoNegocio findWithoutFail($id, $columns = ['*'])
 * @method GanhoNegocio find($id, $columns = ['*'])
 * @method GanhoNegocio first($columns = ['*'])
*/
class GanhoNegocioRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'comentario',
        'negocio_id',
        'usuario_operacao_id',
        'data_ganho'
    ];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $ganhoNegocioAttributes = [
       'comentario',
        'negocio_id',
        'usuario_operacao_id',
        'data_ganho'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return GanhoNegocio::class;
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
                $objTemp->campo  = $this->ganhoNegocioAttributes[$tmpBuscar[0]];
                $objTemp->valor  = $tmpBuscar[1];
                $objTemp->filtro = ($tmpFiltro[1] == 'like') ? 'Contém' : 'Igual';

                array_push($this->filters, $objTemp);
            }
        }
        
        if(isset($filters) && isset($filters['orderBy']) && isset($filters['sortedBy'])){
            $orderBy         = $filters['orderBy'];
            $sortedBy        = $filters['sortedBy'];
            $objTemp         = new \stdClass();
            $objTemp->campo  = $this->ganhoNegocioAttributes[$orderBy];
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
