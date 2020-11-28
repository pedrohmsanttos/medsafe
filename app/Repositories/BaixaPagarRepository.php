<?php

namespace App\Repositories;

use App\Models\BaixaPagar;
use App\Models\ContaBancaria;
use App\Models\FormaDePagamento;
use App\Models\LancamentoPagar;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BaixaPagarRepository
 * @package App\Repositories
 * @version April 9, 2019, 6:21 pm UTC
 *
 * @method BaixaPagar findWithoutFail($id, $columns = ['*'])
 * @method BaixaPagar find($id, $columns = ['*'])
 * @method BaixaPagar first($columns = ['*'])
*/
class BaixaPagarRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'disponibilidade',
        'baixa',
        'valor_pago',
        'valor_residual',
        'conta_bancaria_id',
        'pagamento_id',
        'lancamentopagar_id',
        'plano_de_conta_id'
    ];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $baixaPagarAttributes = [
        'disponibilidade'   => 'Disponibilidade',
        'baixa'             => 'Baixa',
        'valor_pago'        => 'Valor Pago',
        'valor_residual'    => 'Valor Residual',
        'conta_bancaria_id' => 'Conta Bancária',
        'pagamento_id'      => 'Tipo Pagamento',
        'lancamentopagar_id'=> 'Lançamento'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BaixaPagar::class;
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
                $objTemp->campo  = $this->baixaPagarAttributes[$tmpBuscar[0]];

                

                if ($objTemp->campo == 'Disponibilidade' || $objTemp->campo == 'Baixa') {
                    $objTemp->valor = date('d/m/Y', strtotime(str_replace("-", "/", $tmpBuscar[1])));
                } elseif ($objTemp->campo == 'Conta Bancária') {
                    $objTemp->valor  = ContaBancaria::find($tmpBuscar[1])->getName();
                } elseif ($objTemp->campo == 'Tipo Pagamento') {
                    $objTemp->valor  = FormaDePagamento::find($tmpBuscar[1])->titulo;
                } elseif ($objTemp->campo == 'Lançamento') {
                    $objTemp->valor  = LancamentoPagar::find($tmpBuscar[1])->getTitulo();
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
            $objTemp->campo  = $this->baixaPagarAttributes[$orderBy];
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
