<?php

namespace App\Repositories;

use App\Models\PlanoDeContas;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PlanoDeContasRepository
 * @package App\Repositories
 * @version January 11, 2019, 7:37 pm UTC
 *
 * @method PlanoDeContas findWithoutFail($id, $columns = ['*'])
 * @method PlanoDeContas find($id, $columns = ['*'])
 * @method PlanoDeContas first($columns = ['*'])
*/
class PlanoDeContasRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'classificacao',
        'descricao',
        'tipoConta',
        'caixa',
        'banco',
        'cliente',
        'fornecedor',
        'contabancaria_id'
    ];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $planoDeContaAttributes = [
        'classificacao' => 'Classificação',
        'descricao' => 'Descrição',
        'tipoConta' => 'Tipo de Conta',
        'cliente' => 'Cliente',
        'fornecedor' => 'Fornecedor',
        'caixa' => 'Caixa',
        'banco' => 'Banco'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PlanoDeContas::class;
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
                $objTemp->campo  = $this->planoDeContaAttributes[$tmpBuscar[0]];
                $objTemp->valor  = $tmpBuscar[1];
                $objTemp->filtro = ($tmpFiltro[1] == 'like') ? 'Contém' : 'Igual';

                array_push($this->filters, $objTemp);
            }
        }
        
        if (isset($filters) && isset($filters['orderBy']) && isset($filters['sortedBy'])) {
            $orderBy         = $filters['orderBy'];
            $sortedBy        = $filters['sortedBy'];
            $objTemp         = new \stdClass();
            $objTemp->campo  = $this->planoDeContaAttributes[$orderBy];
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

        return $this->obj_array_unique($this->filters);
    }

    public function obj_array_unique($data)
    {
        // walk input array
        $_data = array();
        foreach ($data as $key => $v) {
            $arrTmp = (array) $v;
            if (isset($_data[$arrTmp['campo']])) {
                // found duplicate
                continue;
            }
            // remember unique item
            $_data[$arrTmp['campo']] = $v;
        }
        // if you need a zero-based array, otheriwse work with $_data
        $data = array_values($_data);

        return $data;
    }

    /**
     * Report from Lancamento
     *
     * @param array $input
     *
     * @return  array LancamentoReceber
     **/
    public function relatorio($input)
    {
        if ($input['plano_de_contas']=='*') {
            $planoDeContas = $this->orderBy('classificacao', 'asc')->all();
        } else {
            $planoDeContas = $this->findWhere([
                'id' => $input['plano_de_contas']
            ])->all();
        }
        $arrWheres = [];

        if (isset($input['tipo_operacao']) && $input['tipo_operacao'] != '' && $input['tipo_operacao'] != '*') {
            if ($input['tipo_operacao'] == 'rec') {
                $arrWheres[] = ['tipo','=','deposito'];
            } else {
                $arrWheres[] = ['tipo','=','retirada'];
            }
        }

        if (isset($input['cliente'])) {
            $arrWheres[] = ['meta->cliente_id' ,'=', (int) $input['cliente']];
        } elseif (isset($input['fornecedor'])) {
            $arrWheres[] = ['meta->fornecedor_id' ,'=', (int) $input['fornecedor']];
        }
        
        if (isset($this->input['data_inicial']) && $this->input['data_inicial'] != '' && isset($this->input['data_final']) && $this->input['data_final'] != '') {
            foreach ($planoDeContas as $plano) {
                if (count($arrWheres) > 0) {
                    $plano->movimentacao = $plano->movimentacao()->whereBetween('created_at', [date("Y-m-d", strtotime(str_replace('/', '-', $this->input['data_inicial']))).' 00:00:00', date("Y-m-d", strtotime(str_replace('/', '-', $this->input['data_final']))).' 23:59:59' ])->where($arrWheres)->get();
                } else {
                    $plano->movimentacao = $plano->movimentacao()->whereBetween('created_at', [date("Y-m-d", strtotime(str_replace('/', '-', $this->input['data_inicial']))).' 00:00:00', date("Y-m-d", strtotime(str_replace('/', '-', $this->input['data_final']))).' 23:59:59' ])->get();
                }
            }
        } else {
            foreach ($planoDeContas as $plano) {
                if (count($arrWheres) > 0) {
                    $plano->movimentacao = $plano->movimentacao()->where($arrWheres)->get();
                } else {
                    $plano->movimentacao = $plano->movimentacao()->get();
                }
            }
        }

        return $planoDeContas;
    }
}
