<?php

namespace App\Repositories;

use App\Models\Pedido;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PedidoRepository
 * @package App\Repositories
 * @version February 18, 2019, 5:35 pm UTC
 *
 * @method Pedido findWithoutFail($id, $columns = ['*'])
 * @method Pedido find($id, $columns = ['*'])
 * @method Pedido first($columns = ['*'])
*/
class PedidoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'status_pedido_id',
        'cliente_id',
        'corretor_id',
        'usuario_operacao_id',
        'data_vencimento'
    ];

    /**
     * @var array
     */
    protected $input = [];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $clienteAttributes = [
       'status_pedido_id',
        'cliente_id',
        'corretor_id',
        'usuario_operacao_id',
        'data_vencimento'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Pedido::class;
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

    /**
     * Report from Lancamento
     *
     * @param array $input
     *
     * @return  array Pedidos
     **/
    
    public function relatorio($input)
    {
        $this->input = $input;

        
        $pedidos = $this->scopeQuery(function ($query) {
            if ((isset($this->input['cliente']) && $this->input['cliente'] != '*') && (isset($this->input['data_inicial']) && $this->input['data_inicial'] != '' && !is_null($this->input['data_inicial']) && isset($this->input['data_final']) && $this->input['data_final'] != '' && !is_null($this->input['data_final']))) {
                $query = $query->where('cliente_id', (int) intval($this->input['cliente']))
                            ->whereBetween('created_at', [date("Y-m-d", strtotime(str_replace('/', '-', $this->input['data_inicial']))).' 00:00:00', date("Y-m-d", strtotime(str_replace('/', '-', $this->input['data_final']))).' 23:59:59' ]);
            }
            
            if (isset($this->input['cliente']) && $this->input['cliente'] != '*') {
                $query = $query->where('cliente_id', intval($this->input['cliente']));
            } // filtro de cliente

            if (isset($this->input['data_inicial']) && $this->input['data_inicial'] != '' && isset($this->input['data_final']) && $this->input['data_final'] != '') {
                $query = $query->whereBetween('created_at', [date("Y-m-d", strtotime(str_replace('/', '-', $this->input['data_inicial']))).' 00:00:00', date("Y-m-d", strtotime(str_replace('/', '-', $this->input['data_final']))).' 23:59:59' ]);
            } // filtro de data

            return $query;
        })->all();

        //dd($pedidos);die;
        
        return $pedidos;
    }

    
}
