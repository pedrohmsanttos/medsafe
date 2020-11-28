<?php

namespace App\Repositories;

use App\Models\TipoAtividade;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TipoAtividadeRepository
 * @package App\Repositories
 * @version February 1, 2019, 5:50 pm UTC
 *
 * @method TipoAtividade findWithoutFail($id, $columns = ['*'])
 * @method TipoAtividade find($id, $columns = ['*'])
 * @method TipoAtividade first($columns = ['*'])
*/
class TipoAtividadeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'descricao'
    ];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $tiposAtividadesAttributes = [
       'descricao' => 'Descrição'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return TipoAtividade::class;
    }

    /**
     * Mapping of filter
     **/
    public function filter($filters)
    {
        if (isset($filters) && isset($filters['search']) && isset($filters['searchFields'])) {
            $search       = explode(';', $filters['search']);
            $searchFields = explode(';', $filters['searchFields']);
            foreach ($search as $index => $filter) {
                $tmpBuscar = explode(':', $filter);
                $tmpFiltro = explode(':', $searchFields[$index]);
                $objTemp   = new \stdClass();
                $objTemp->campo  = $this->tiposAtividadesAttributes[$tmpBuscar[0]];
                $objTemp->valor  = $tmpBuscar[1];
                $objTemp->filtro = ($tmpFiltro[1] == 'like') ? 'Contém' : 'Igual';

                array_push($this->filters, $objTemp);
            }
        }
        
        if (isset($filters) && isset($filters['orderBy']) && isset($filters['sortedBy'])) {
            $orderBy         = $filters['orderBy'];
            $sortedBy        = $filters['sortedBy'];
            $objTemp         = new \stdClass();
            $objTemp->campo  = $this->tiposAtividadesAttributes[$orderBy];
            $objTemp->valor  = ($sortedBy == 'asc') ? 'Crescente' : 'Decrescente';
            $objTemp->filtro = 'Ordem';

            array_push($this->filters, $objTemp);
        }
        
        if (isset($filters) && isset($filters['situacao'])) {
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
