<?php

namespace App\Repositories;

use App\Models\Comissao;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ComissaoRepository
 * @package App\Repositories
 * @version August 22, 2019, 5:08 pm UTC
 *
 * @method Comissao findWithoutFail($id, $columns = ['*'])
 * @method Comissao find($id, $columns = ['*'])
 * @method Comissao first($columns = ['*'])
*/
class ComissaoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'corretor_id',
        'checkout_id',
        'percentual_comissao',
        'comissao',
        'valor',
        'status_aprovacao'
    ];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $clienteAttributes = [
        'id' => 'id', 
        'corretor_id',
        'checkout_id',
        'percentual_comissao',
        'comissao',
        'valor',
        'status_aprovacao'  => 'status_aprovacao'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Comissao::class;
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
