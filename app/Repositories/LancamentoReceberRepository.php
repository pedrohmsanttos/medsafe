<?php

namespace App\Repositories;

use App\Models\LancamentoReceber;
use InfyOm\Generator\Common\BaseRepository;
use DB;

/**
 * Class LancamentoReceberRepository
 * @package App\Repositories
 * @version February 18, 2019, 5:36 pm UTC
 *
 * @method LancamentoReceber findWithoutFail($id, $columns = ['*'])
 * @method LancamentoReceber find($id, $columns = ['*'])
 * @method LancamentoReceber first($columns = ['*'])
*/
class LancamentoReceberRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'cliente_id',
        'data_vencimento',
        'data_emissao',
        'numero_documento'
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
    protected $lancamentoReceberAttributes = [
        'cliente_id'       => 'Cliente',
        'data_vencimento'  => 'Data de Vencimento',
        'data_emissao'     => 'Data de Emissão',
        'numero_documento' => 'Nº de Documento',
        'nomeFantasia'     => 'Nome Fantasia',
        'cliente'          => 'Cliente',
        'valor_titulo'     => 'Valor'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LancamentoReceber::class;
    }

    /**
     * Mapping of filter
     **/
    public function filter($filters)
    {
        if (isset($filters) && isset($filters['search'])) {
            $search       = explode(';', $filters['search']);
            $searchFields = explode(';', $filters['searchFields']);
            foreach ($search as $index => $filter) {
                $tmpBuscar = explode(':', $filter);
                $tmpFiltro = explode(':', $searchFields[$index]);
                $objTemp   = new \stdClass();
                $objTemp->campo  = $this->lancamentoReceberAttributes[$tmpBuscar[0]];

                if ($objTemp->campo == 'Data de Emissão' || $objTemp->campo == 'Data de Vencimento' ||  $objTemp->campo == 'Data de Disponibilidade') {
                    $objTemp->valor = date('d/m/Y', strtotime(str_replace("-", "/", $tmpBuscar[1])));
                } else {
                    $objTemp->valor  = $tmpBuscar[1];
                }
                
                $objTemp->filtro = (isset($tmpFiltro[1]) && $tmpFiltro[1] == '=') ? 'Igual' : 'Contém';

                array_push($this->filters, $objTemp);
            }
        }
        
        if (isset($filters) && isset($filters['orderBy']) && isset($filters['sortedBy'])) {
            $orderBy         = $filters['orderBy'];
            $sortedBy        = $filters['sortedBy'];
            $objTemp         = new \stdClass();
            $objTemp->campo  = $this->lancamentoReceberAttributes[$orderBy];
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

    /**
     * Report from Lancamento
     *
     * @param array $input
     *
     * @return  array LancamentoReceber
     **/
    public function relatorio($input)
    {
        $this->input = $input;

        
        $lancamentos = $this->scopeQuery(function ($query) {
            if ((isset($this->input['cliente']) && $this->input['cliente'] != '*') && (isset($this->input['data_inicial']) && $this->input['data_inicial'] != '' && !is_null($this->input['data_inicial']) && isset($this->input['data_final']) && $this->input['data_final'] != '' && !is_null($this->input['data_final']))) {
                $query = $query->where('cliente_id', (int) intval($this->input['cliente']))
                            ->whereBetween('data_emissao', [date("Y-m-d", strtotime(str_replace('/', '-', $this->input['data_inicial']))).' 00:00:00', date("Y-m-d", strtotime(str_replace('/', '-', $this->input['data_final']))).' 23:59:59' ]);
            }
            
            if (isset($this->input['cliente']) && $this->input['cliente'] != '*') {
                $query = $query->where('cliente_id', intval($this->input['cliente']));
            } // filtro de cliente

            if (isset($this->input['data_inicial']) && $this->input['data_inicial'] != '' && isset($this->input['data_final']) && $this->input['data_final'] != '') {
                $query = $query->whereBetween('data_emissao', [date("Y-m-d", strtotime(str_replace('/', '-', $this->input['data_inicial']))).' 00:00:00', date("Y-m-d", strtotime(str_replace('/', '-', $this->input['data_final']))).' 23:59:59' ]);
            } // filtro de data

            return $query;
        })->all();

        
        return $lancamentos;
    }

    /**
     * Retrieve all data of repository, paginated
     *
     * @param null $limit
     * @param array $columns
     * @param string $method
     *
     * @return mixed
     */
    public function paginate($limit = null, $columns = ['*'], $method = "paginate")
    {
        $this->applyCriteria();
        $this->applyScope();
        $baixados = DB::table('baixa_contas_receber')->pluck('lancamentoreceber_id')->toArray();
        $limit = is_null($limit) ? config('repository.pagination.limit', 15) : $limit;
        $results = $this->model->whereNotIn('id', $baixados)->{$method}($limit, $columns);
        $results->appends(app('request')->query());
        $this->resetModel();

        return $this->parserResult($results);
    }
}
