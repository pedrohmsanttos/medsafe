<?php

namespace App\Repositories;

use App\Models\MotivoPerdaNegocio;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MotivoPerdaNegocioRepository
 * @package App\Repositories
 * @version January 17, 2019, 2:30 pm UTC
 *
 * @method MotivoPerdaNegocio findWithoutFail($id, $columns = ['*'])
 * @method MotivoPerdaNegocio find($id, $columns = ['*'])
 * @method MotivoPerdaNegocio first($columns = ['*'])
*/
class MotivoPerdaNegocioRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'descricao'
    ];
    protected $filters = [];

    /**
     * @var array
     */

    protected $motivoPerdaNegocioAttributes = [
        'descricao'=>'Descrição'
    ];
    /**
     * Configure the Model
     **/
    public function model()
    {
        return MotivoPerdaNegocio::class;
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
                $objTemp->campo  = $this->motivoPerdaNegocioAttributes[$tmpBuscar[0]];
                $objTemp->valor  = $tmpBuscar[1];
                $objTemp->filtro = ($tmpFiltro[1] == 'like') ? 'Contém' : 'Igual';

                array_push($this->filters, $objTemp);
            }
        }
        
        if(isset($filters) && isset($filters['orderBy']) && isset($filters['sortedBy'])){
            $orderBy         = $filters['orderBy'];
            $sortedBy        = $filters['sortedBy'];
            $objTemp         = new \stdClass();
            $objTemp->campo  = $this->motivoPerdaNegocioAttributes[$orderBy];
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
        //dd($this->filters);
        return $this->filters;
        
    }
}
