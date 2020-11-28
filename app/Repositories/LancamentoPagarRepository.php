<?php

namespace App\Repositories;

use App\Models\LancamentoPagar;
use App\Models\Fornecedor;
use InfyOm\Generator\Common\BaseRepository;
use DB;

/**
 * Class LancamentoPagarRepository
 * @package App\Repositories
 * @version March 29, 2019, 3:18 pm UTC
 *
 * @method LancamentoPagar findWithoutFail($id, $columns = ['*'])
 * @method LancamentoPagar find($id, $columns = ['*'])
 * @method LancamentoPagar first($columns = ['*'])
*/
class LancamentoPagarRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'fornecedor_id',
        'data_vencimento',
        'data_emissao',
        'valor_titulo',
        'numero_documento'
    ];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $lancamentoPagarAttributes = [
       'fornecedor_id'      => "Fornecedor",
        'data_vencimento'   => "Data de Vencimento",
        'data_emissao'      => "Data de Emissão",
        'valor_titulo'      => "Valor do Título",
        'numero_documento'  => "Número Documento"
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LancamentoPagar::class;
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
                $objTemp->campo  = $this->lancamentoPagarAttributes[$tmpBuscar[0]];
                
                if ($objTemp->campo == 'Fornecedor') {
                    $objTemp->valor  = Fornecedor::find($tmpBuscar[1])->razaoSocial;
                } elseif ($objTemp->campo == 'Data de Emissão' || $objTemp->campo == 'Data de Vencimento') {
                    $objTemp->valor = date('d/m/Y', strtotime(str_replace("-", "/", $tmpBuscar[1])));
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
            $objTemp->campo  = $this->lancamentoPagarAttributes[$orderBy];
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
        $lancamentos = $this->scopeQuery(function ($query) use ($input) {
            if ((isset($input['fornecedor']) && $input['fornecedor'] != '*') && (isset($input['data_inicial']) && $input['data_inicial'] != '' && isset($input['data_final']) && $input['data_final'] != '')) {
                $query = $query->where('fornecedor_id', $input['fornecedor'])
                            ->whereBetween('data_emissao', [date("Y-m-d", strtotime(str_replace('/', '-', $input['data_inicial']))), date("Y-m-d", strtotime(str_replace('/', '-', $input['data_final']))) ]);
            }

            if (isset($input['fornecedor']) && $input['fornecedor'] != '*') {
                $query = $query->where('fornecedor_id', (int) intval($input['fornecedor']));
            } // filtro de fornecedor

            if (isset($input['data_inicial']) && $input['data_inicial'] != '' && isset($input['data_final']) && $input['data_final'] != '') {
                $query = $query->whereBetween('data_emissao', [date("Y-m-d", strtotime(str_replace('/', '-', $input['data_inicial']))), date("Y-m-d", strtotime(str_replace('/', '-', $input['data_final']))) ]);
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
        $baixados = DB::table('baixa_contas_pagar')->pluck('lancamentopagar_id')->toArray();
        $limit = is_null($limit) ? config('repository.pagination.limit', 15) : $limit;
        $results = $this->model->whereNotIn('id', $baixados)->{$method}($limit, $columns);
        $results->appends(app('request')->query());
        $this->resetModel();

        return $this->parserResult($results);
    }
}
