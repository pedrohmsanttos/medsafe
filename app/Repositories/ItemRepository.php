<?php

namespace App\Repositories;

use App\Models\Item;
use InfyOm\Generator\Common\BaseRepository;
use DB;

/**
 * Class ItemRepository
 * @package App\Repositories
 * @version May 15, 2019, 7:19 pm UTC
 *
 * @method Item findWithoutFail($id, $columns = ['*'])
 * @method Item find($id, $columns = ['*'])
 * @method Item first($columns = ['*'])
*/
class ItemRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'pedido_id',
        'negocio_id',
        'tabela_preco_id',
        'valor',
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
       'pedido_id',
        'negocio_id',
        'tabela_preco_id',
        'valor',
        'quantidade'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Item::class;
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
                $objTemp->campo  = $this->clienteAttributes[$tmpBuscar[0]];
                $objTemp->valor  = $tmpBuscar[1];
                $objTemp->filtro = ($tmpFiltro[1] == 'like') ? 'Contém' : 'Igual';

                array_push($this->filters, $objTemp);
            }
        }
        
        if (isset($filters) && isset($filters['orderBy']) && isset($filters['sortedBy'])) {
            $orderBy         = $filters['orderBy'];
            $sortedBy        = $filters['sortedBy'];
            $objTemp         = new \stdClass();
            $objTemp->campo  = $this->clienteAttributes[$orderBy];
            $objTemp->valor  = ($sortedBy == 'asc') ? 'Crescente' : 'Decrescente';
            $objTemp->filtro = 'Ordem';

            array_push($this->filters, $objTemp);
        }
        
        if (isset($filters) && isset($filters['situacao'])) {
            $situacao         = $filters['situacao'];
            $objTemp         = new \stdClass();
            $objTemp->campo  = 'Situação';
            $objTemp->valor  = ($situacao == 'all') ? 'Todos' : $situacao;
            $objTemp->filtro = 'Igual/Contém';

            array_push($this->filters, $objTemp);
        }

        return $this->filters;
    }

    public function relatorio($input)
    {
        $this->input = $input;
       
        $pedidos = $this->scopeQuery(function ($query) {
            if (isset($this->input['servico']) && $this->input['servico'] != '*') {
                $query = $query->whereNotNull('pedido_id')
                ->join('produto_tipo_produtos', 'produto_tipo_produtos.id', '=', 'itens.tabela_preco_id')
                ->join('pedidos', 'itens.pedido_id', '=', 'pedidos.id')
                ->join('clientes', 'clientes.id', '=', 'pedidos.cliente_id')
                ->join('produtos', 'produtos.id', '=', 'produto_tipo_produtos.produto_id')
                ->join('tipo_produtos', 'tipo_produtos.id', '=', 'produto_tipo_produtos.tipo_produto_id')
                ->join('categoria_produtos', 'categoria_produtos.id', '=', 'produto_tipo_produtos.categoria_produto_id')
                ->where('produto_tipo_produtos.produto_id', intval($this->input['servico']))
                ->orderBy('produtos.descricao', 'ASC')
                ->select('produtos.id', 'clientes.nomeFantasia as cliente','produtos.descricao as produto', 'tipo_produtos.descricao as tipo', 'categoria_produtos.descricao as categoria', 'itens.*');
            } else {
                $query = $query->whereNotNull('pedido_id')
                ->join('produto_tipo_produtos', 'produto_tipo_produtos.id', '=', 'itens.tabela_preco_id')
                ->join('pedidos', 'itens.pedido_id', '=', 'pedidos.id')
                ->join('clientes', 'clientes.id', '=', 'pedidos.cliente_id')
                ->join('produtos', 'produtos.id', '=', 'produto_tipo_produtos.produto_id')
                ->join('tipo_produtos', 'tipo_produtos.id', '=', 'produto_tipo_produtos.tipo_produto_id')
                ->join('categoria_produtos', 'categoria_produtos.id', '=', 'produto_tipo_produtos.categoria_produto_id')
                ->orderBy('produtos.descricao', 'ASC')
                ->select('produtos.id','clientes.nomeFantasia as cliente', 'produtos.descricao as produto', 'tipo_produtos.descricao as tipo', 'categoria_produtos.descricao as categoria', 'itens.*');
            }

            if (isset($this->input['cliente']) && $this->input['cliente'] != '*') {
                $query = $query->where('pedidos.cliente_id', intval($this->input['cliente']));
            }
            
            return $query;
        })->all();

        return $pedidos;
    }

    public function relatorioNegocioPedido($input)
    {
        $this->input = $input;
       

        

        $pedidos = $this->scopeQuery(function ($query) {
            if (isset($this->input['servico']) && $this->input['servico'] != '*') {
                $query = $query->whereNotNull('itens.pedido_id')
                    ->join('produto_tipo_produtos', 'produto_tipo_produtos.id', '=', 'itens.tabela_preco_id')
                    ->join('produtos', 'produtos.id', '=', 'produto_tipo_produtos.produto_id')
                    ->join('tipo_produtos', 'tipo_produtos.id', '=', 'produto_tipo_produtos.tipo_produto_id')
                    ->join('pedidos', 'itens.pedido_id', '=', 'pedidos.id')
                    ->join('categoria_produtos', 'categoria_produtos.id', '=', 'produto_tipo_produtos.categoria_produto_id')
                    ->join('checkouts', 'checkouts.pedido_id', '=', 'itens.pedido_id')
                    ->where('produto_tipo_produtos.produto_id', intval($this->input['servico']))
                    ->where('checkouts.status', 2)
                    ->orderBy('produtos.descricao', 'ASC')
                    ->select(DB::raw('produtos.id,produtos.created_at, MAX(produtos.descricao) as produto, MAX(tipo_produtos.descricao) as tipo, MAX(categoria_produtos.descricao) as categoria, SUM(itens.quantidade) as quantidade'))
                    ->groupBy('produtos.id');
            } else {
                $query = $query->whereNotNull('itens.pedido_id')
                    ->join('produto_tipo_produtos', 'produto_tipo_produtos.id', '=', 'itens.tabela_preco_id')
                    ->join('produtos', 'produtos.id', '=', 'produto_tipo_produtos.produto_id')
                    ->join('tipo_produtos', 'tipo_produtos.id', '=', 'produto_tipo_produtos.tipo_produto_id')
                    ->join('categoria_produtos', 'categoria_produtos.id', '=', 'produto_tipo_produtos.categoria_produto_id')
                    ->join('checkouts', 'checkouts.pedido_id', '=', 'itens.pedido_id')
                    ->join('pedidos', 'itens.pedido_id', '=', 'pedidos.id')
                    ->where('checkouts.status', 2)
                    ->orderBy('produtos.descricao', 'ASC')
                    ->select(DB::raw('produtos.id,produtos.created_at, MAX(produtos.descricao) as produto, MAX(tipo_produtos.descricao) as tipo, MAX(categoria_produtos.descricao) as categoria, SUM(itens.quantidade) as quantidade, SUM(itens.valor) as valor'))
                    ->groupBy('produtos.id');
            }


            if (isset($this->input['data_inicial']) && $this->input['data_inicial'] != '' && isset($this->input['data_final']) && $this->input['data_final'] != '') {
                $query = $query->whereBetween('pedidos.created_at', [date("Y-m-d", strtotime(str_replace('/', '-', $this->input['data_inicial']))).' 00:00:00', date("Y-m-d", strtotime(str_replace('/', '-', $this->input['data_final']))).' 23:59:59' ]);
            } // filtro de data
            
            return $query;
        })->all();

        return $pedidos;
    }
}
