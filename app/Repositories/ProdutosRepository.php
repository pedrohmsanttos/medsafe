<?php

namespace App\Repositories;

use App\Models\Produtos;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ProdutosRepository
 * @package App\Repositories
 * @version January 14, 2019, 6:50 pm UTC
 *
 * @method Produtos findWithoutFail($id, $columns = ['*'])
 * @method Produtos find($id, $columns = ['*'])
 * @method Produtos first($columns = ['*'])
*/
class ProdutosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'descricao',
        'valor',
        'tipo_produto_id',
        'categoria_produto_id'
    ];
    protected $filters = [];

    /**
     * @var array
     */
    protected $produtoAttributes = [
        'descricao'             => 'Descrição',
        'tipo_produto_id'       => 'Tipo de Produto',
        'categoria_produto_id'  => 'Categoria de Produto',
    ];


    /**
     * Configure the Model
     **/
    public function model()
    {
        return Produtos::class;
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
                $objTemp->campo  = $this->produtoAttributes[$tmpBuscar[0]];
                $objTemp->valor  = $tmpBuscar[1];
                $objTemp->filtro = ($tmpFiltro[1] == 'like') ? 'Contém' : 'Igual';

                array_push($this->filters, $objTemp);
            }
        }
        
        if(isset($filters) && isset($filters['orderBy']) && isset($filters['sortedBy'])){
            $orderBy         = $filters['orderBy'];
            $sortedBy        = $filters['sortedBy'];
            $objTemp         = new \stdClass();
            $objTemp->campo  = $this->produtoAttributes[$orderBy];
            $objTemp->valor  = ($sortedBy == 'asc') ? 'Crescente' : 'Descrescente';
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
