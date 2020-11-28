<?php

namespace App\Repositories;

use App\Models\PerdaNegocio;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PerdaNegocioRepository
 * @package App\Repositories
 * @version February 7, 2019, 6:47 pm UTC
 *
 * @method PerdaNegocio findWithoutFail($id, $columns = ['*'])
 * @method PerdaNegocio find($id, $columns = ['*'])
 * @method PerdaNegocio first($columns = ['*'])
*/
class PerdaNegocioRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'comentario',
        'perda_negocio_id',
        'usuario_operacao_id',
        'data_perda'
    ];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $clienteAttributes = [
       'comentario',
        'perda_negocio_id',
        'usuario_operacao_id',
        'data_perda'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PerdaNegocio::class;
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
