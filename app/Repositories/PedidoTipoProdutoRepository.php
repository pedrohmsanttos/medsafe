<?php

namespace App\Repositories;

use App\Models\PedidoTipoProduto;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PedidoTipoProdutoRepository
 * @package App\Repositories
 * @version February 18, 2019, 5:36 pm UTC
 *
 * @method PedidoTipoProduto findWithoutFail($id, $columns = ['*'])
 * @method PedidoTipoProduto find($id, $columns = ['*'])
 * @method PedidoTipoProduto first($columns = ['*'])
*/
class PedidoTipoProdutoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'pedido_id',
        'categoria_produto_id',
        'tipo_produto_id',
        'produto_id',
        'valor',
        'valor_parcela',
        'valor_desconto',
        'valor_final',
        'quantidade_parcela',
        'quantidade'
    ];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $clienteAttributes = [
       'pedido_id'  => 'Pedido',
        'categoria_produto_id' => 'Categoria do produto',
        'tipo_produto_id'=> 'Tipo do produto',
        'produto_id'=> 'Produto',
        'valor'=> 'Valor',
        'valor_parcela'=> 'Valor de parcela',
        'valor_desconto'=> 'Valor de desconto',
        'valor_final'=> 'Valor final',
        'quantidade_parcela'=> 'Quantidade de parcelas',
        'quantidade'=> 'Quantidade'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PedidoTipoProduto::class;
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
