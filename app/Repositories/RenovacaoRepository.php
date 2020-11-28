<?php

namespace App\Repositories;

use App\Models\Renovacao;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RenovacaoRepository
 * @package App\Repositories
 * @version August 9, 2019, 8:26 pm UTC
 *
 * @method Renovacao findWithoutFail($id, $columns = ['*'])
 * @method Renovacao find($id, $columns = ['*'])
 * @method Renovacao first($columns = ['*'])
*/
class RenovacaoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'corretor_id',
        'pedido_id',
        'cliente_id',
        'numero',
        'endosso',
        'ci',
        'classe_bonus',
        'proposta',
        'status'
    ];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $clienteAttributes = [
       'corretor_id',
        'pedido_id',
        'cliente_id',
        'numero' => 'numero',
        'endosso' => 'endosso',
        'ci' => 'ci',
        'classe_bonus' =>'classe_bonus',
        'proposta' => 'proposta',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Renovacao::class;
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
