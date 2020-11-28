<?php

namespace App\Repositories;

use App\Models\Apolice;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ApoliceRepository
 * @package App\Repositories
 * @version July 11, 2019, 5:40 pm UTC
 *
 * @method Apolice findWithoutFail($id, $columns = ['*'])
 * @method Apolice find($id, $columns = ['*'])
 * @method Apolice first($columns = ['*'])
*/
class ApoliceRepository extends BaseRepository
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
        'proposta'
    ];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $ApoliceAttributes = [
        'corretor_id',
        'pedido_id',
        'cliente_id',
        'numero' => 'Número',
        'endosso',
        'ci',
        'classe_bonus' => '',
        'proposta' => '',
        'status' => 'Status'
    ];

    /**
     * @var array
     */
    protected $apolicesStatus = [
        'Pedente',
        'Aprovado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Apolice::class;
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
                $objTemp->campo  = $this->ApoliceAttributes[$tmpBuscar[0]];
                if ($objTemp->campo == 'Status') {
                    $objTemp->valor  = $this->apolicesStatus[$tmpBuscar[1]];
                } else {
                    $objTemp->valor  = $tmpBuscar[1];
                }
                $objTemp->filtro = ($tmpFiltro[1] == 'like') ? 'Contém' : 'Igual';

                array_push($this->filters, $objTemp);
            }
        }
        
        if (isset($filters) && isset($filters['orderBy']) && isset($filters['sortedBy'])) {
            $orderBy         = $filters['orderBy'];
            $sortedBy        = $filters['sortedBy'];
            $objTemp         = new \stdClass();
            $objTemp->campo  = $this->ApoliceAttributes[$orderBy];
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
        
        $apolices = $this->scopeQuery(function ($query) {
            // if (isset($this->input['data_inicial']) && $this->input['data_inicial'] != '' && isset($this->input['data_final']) && $this->input['data_final'] != '') {
            //     //dd('entrou aqui tb');
            //     $query = $query->join('pedidos', 'pedidos.id', '=', 'apolices.pedido_id')
            //     ->join('clientes', 'clientes.id', '=', 'apolices.cliente_id')
            //     ->whereBetween('apolices.created_at', [date("Y-m-d", strtotime(str_replace('/', '-', $this->input['data_inicial']))).' 00:00:00', date("Y-m-d", strtotime(str_replace('/', '-', $this->input['data_final']))).' 23:59:59' ])
            //     ->select('pedidos.valor_total','clientes.nomeFantasia', 'apolices.*');
            // } 

            if ((isset($this->input['corretor']) && $this->input['corretor'] != '*') && (isset($this->input['data_inicial']) && $this->input['data_inicial'] != '' && !is_null($this->input['data_inicial']) && isset($this->input['data_final']) && $this->input['data_final'] != '' && !is_null($this->input['data_final']))) {
                $query = $query->join('pedidos', 'pedidos.id', '=', 'apolices.pedido_id')
                ->join('clientes', 'clientes.id', '=', 'apolices.cliente_id')
                ->where('apolices.data_ativacao','<>','')
                ->where('apolices.corretor_id', (int) intval($this->input['corretor']))
                ->whereBetween('apolices.data_ativacao', [date("Y-m-d", strtotime(str_replace('/', '-', $this->input['data_inicial']))).' 00:00:00', date("Y-m-d", strtotime(str_replace('/', '-', $this->input['data_final']))).' 23:59:59' ])
                ->select('pedidos.valor_total as valor','clientes.nomeFantasia as cliente', 'apolices.*');
            }
            
            else if (isset($this->input['corretor']) && $this->input['corretor'] != '*') {
                $query = $query->join('pedidos', 'pedidos.id', '=', 'apolices.pedido_id')
                ->join('clientes', 'clientes.id', '=', 'apolices.cliente_id')
                ->where('apolices.corretor_id', (int) intval($this->input['corretor']))
                ->where('apolices.data_ativacao','<>','')
                ->select('pedidos.valor_total as valor','clientes.nomeFantasia as cliente', 'apolices.*');
            } // filtro de usuario

            // if ($this->input['usuario'] == '*'){
            //     $query = $query->join('users', 'users.id', '=', 'negocios.usuario_operacao_id')
            //     ->leftJoin('organizacaos', 'organizacaos.id', '=', 'negocios.organizacao_id')
            //     ->leftJoin('pessoas', 'pessoas.id', '=', 'negocios.pessoa_id')
            //     ->select('pessoas.nome as pessoas','organizacaos.nome as organizacao','users.name as usuario', 'negocios.*');
            // }
            //dd($query->toSql());
            return $query;
        })->all();

        //dd($negocios);
        
        return $apolices;
    }
}
