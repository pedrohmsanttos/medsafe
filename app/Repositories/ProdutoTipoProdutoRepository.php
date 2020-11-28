<?php

namespace App\Repositories;

use App\Models\ProdutoTipoProduto;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ProdutoTipoProdutoRepository
 * @package App\Repositories
 * @version January 18, 2019, 6:02 pm UTC
 *
 * @method ProdutoTipoProduto findWithoutFail($id, $columns = ['*'])
 * @method ProdutoTipoProduto find($id, $columns = ['*'])
 * @method ProdutoTipoProduto first($columns = ['*'])
*/
class ProdutoTipoProdutoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'valor',
        'tipo_produto_id',
        'categoria_produto_id'
    ];
    

    /**
     * @var array
     */
    protected $produtoTipoProdutoAttributes = [
        'valor'=> 'Valor',
        'produto_id'=> 'Produto',
        'tipo_produto_id'=> 'Tipo do Produto',
        'categoria_produto_id' => 'Categoria do Produto',
        'tipo'=> 'Tipo do Produto',
        'categoria' => 'Categoria do Produto'
     ];

    protected $filters = [];
    /**
     * Configure the Model
     **/
    public function model()
    {
        return ProdutoTipoProduto::class;
    }


    /**
     * Consulta para gerar negócio
     **/
    public function findValor($produto_id, $categoria_produto_id, $tipo_produto_id)
    {
        $this->produto_id           = $produto_id;
        $this->categoria_produto_id = $categoria_produto_id;
        $this->tipo_produto_id      = $tipo_produto_id;
        
        return $this->scopeQuery(function ($query) {
            return $query->where([
                ['produto_id', '=', $this->produto_id],
                ['categoria_produto_id', '=', $this->categoria_produto_id],
                ['tipo_produto_id', '=', $this->tipo_produto_id]
            ]);
        })->first();
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
                $objTemp->campo  = $this->produtoTipoProdutoAttributes[$tmpBuscar[0]];
                $objTemp->valor  = $tmpBuscar[1];
                $objTemp->filtro = ($tmpFiltro[1] == 'like') ? 'Contém' : 'Igual';

                array_push($this->filters, $objTemp);
            }
        } else {
            if (isset($filters) && isset($filters['search'])) {
                $search = explode(';', $filters['search']);
                
                foreach ($search as $index => $filter) {
                    $tmpBuscar = explode(':', $filter);
                    $objTemp   = new \stdClass();
                    $objTemp->campo  = $this->produtoTipoProdutoAttributes[$tmpBuscar[0]];
                    $objTemp->valor  = $tmpBuscar[1];
                    $objTemp->filtro = ($tmpBuscar[2] == 'like') ? 'Contém' : 'Igual';
    
                    array_push($this->filters, $objTemp);
                }
            }
        }
        
        if (isset($filters) && isset($filters['orderBy']) && isset($filters['sortedBy'])) {
            $orderBy         = $filters['orderBy'];
            $sortedBy        = $filters['sortedBy'];
            $objTemp         = new \stdClass();
            $objTemp->campo  = $this->produtoTipoProdutoAttributes[$orderBy];
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
