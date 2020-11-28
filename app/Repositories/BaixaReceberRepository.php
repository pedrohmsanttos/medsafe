<?php

namespace App\Repositories;

use App\Models\BaixaReceber;
use App\Models\ContaBancaria;
use App\Models\FormaDePagamento;
use App\Models\LancamentoReceber;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BaixaReceberRepository
 * @package App\Repositories
 * @version April 5, 2019, 6:59 pm UTC
 *
 * @method BaixaReceber findWithoutFail($id, $columns = ['*'])
 * @method BaixaReceber find($id, $columns = ['*'])
 * @method BaixaReceber first($columns = ['*'])
*/
class BaixaReceberRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'caixa_banco',
        'disponibilidade',
        'baixa',
        'valor_pago',
        'valor_residual',
        'pagamento_id',
        'lancamentoreceber_id'
    ];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $baixaReceberAttributes = [
       'caixa_banco'          => 'Caixa',
        'disponibilidade'     => 'Disponibilidade',
        'baixa'               => 'Baixa',
        'valor_pago'          => 'Valor Pago',
        'valor_residual'      => 'Valor Residual',
        'conta_bancaria_id'   => 'Conta Bancária',
        'pagamento_id'        => 'Tipo Pagamento',
        'lancamentoreceber_id'=> 'Lançamento'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BaixaReceber::class;
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
                $objTemp->campo  = $this->baixaReceberAttributes[$tmpBuscar[0]];
                if ($objTemp->campo == 'Conta Bancária') {
                    $objTemp->valor  = ContaBancaria::find($tmpBuscar[1])->getName();
                } elseif ($objTemp->campo == 'Tipo Pagamento') {
                    $objTemp->valor  = FormaDePagamento::find($tmpBuscar[1])->titulo;
                } elseif ($objTemp->campo == 'Lançamento') {
                    $objTemp->valor  = LancamentoReceber::find($tmpBuscar[1])->getTitulo();
                } elseif ($objTemp->campo == 'Disponibilidade' || $objTemp->campo == 'Baixa') {
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
            $objTemp->campo  = $this->baixaReceberAttributes[$orderBy];
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
}
