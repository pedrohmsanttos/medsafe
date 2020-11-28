<?php

namespace App\Repositories;

use App\Models\CategoriaProdutos;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CategoriaProdutosRepository
 * @package App\Repositories
 * @version January 14, 2019, 6:50 pm UTC
 *
 * @method CategoriaProdutos findWithoutFail($id, $columns = ['*'])
 * @method CategoriaProdutos find($id, $columns = ['*'])
 * @method CategoriaProdutos first($columns = ['*'])
*/
class CategoriaProdutosRepository extends BaseRepository
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
    protected $categoriaProdutoAttributes = [
        'descricao' => 'Descrição'
    ];


    protected $filters = [];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CategoriaProdutos::class;
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
                $objTemp->campo  = $this->categoriaProdutoAttributes[$tmpBuscar[0]];
                $objTemp->valor  = $tmpBuscar[1];
                $objTemp->filtro = ($tmpFiltro[1] == 'like') ? 'Contém' : 'Igual';

                array_push($this->filters, $objTemp);
            }
        }
        
        if(isset($filters) && isset($filters['orderBy']) && isset($filters['sortedBy'])){
            $orderBy         = $filters['orderBy'];
            $sortedBy        = $filters['sortedBy'];
            $objTemp         = new \stdClass();
            $objTemp->campo  = $this->categoriaProdutoAttributes[$orderBy];
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
