<?php

namespace App\Repositories;

use App\Models\ContaBancaria;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ContaBancariaRepository
 * @package App\Repositories
 * @version January 11, 2019, 3:45 pm UTC
 *
 * @method ContaBancaria findWithoutFail($id, $columns = ['*'])
 * @method ContaBancaria find($id, $columns = ['*'])
 * @method ContaBancaria first($columns = ['*'])
*/
class ContaBancariaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'classificacao',
        'descricao',
        'numeroConta',
        'numeroAgencia',
        'dataSaldoInicial',
        'saldoInicial',
        'caixa',
        'banco',
        'operacao'
    ];

    /**
     * @var array
     */
    protected $contaBancariaAttributes = [
        'classificacao'     => "Classificação",
        'descricao'         => "Descrição",
        'numeroConta'       => "N° Conta",
        'numeroAgencia'     => "Nº AGência",
        'dataSaldoInicial'  => "Data do Saldo Inicial",
        'saldoInicial'      => "Saldo Inicial",
        'caixa'             => "Caixa",
        'banco'             => "Banco",
        'operacao'          => "Operação"
    ];

    
    /**
     * @var array
     */
    protected $filters = [];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ContaBancaria::class;
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
                $objTemp->campo  = $this->contaBancariaAttributes[$tmpBuscar[0]];
                $objTemp->valor  = $tmpBuscar[1];
                $objTemp->filtro = ($tmpFiltro[1] == 'like') ? 'Contém' : 'Igual';

                array_push($this->filters, $objTemp);
            }
        }
        
        if(isset($filters) && isset($filters['orderBy']) && isset($filters['sortedBy'])){
            $orderBy         = $filters['orderBy'];
            $sortedBy        = $filters['sortedBy'];
            $objTemp         = new \stdClass();
            $objTemp->campo  = $this->contaBancariaAttributes[$orderBy];
            $objTemp->valor  = ($sortedBy == 'asc') ? 'Crescente' : 'Decrescente';
            $objTemp->filtro = 'Ordem';

            array_push($this->filters, $objTemp);
        }
        
        if(isset($filters) && isset($filters['situacao'])){
            
            $situacao         = $filters['situacao'];
            $objTemp         = new \stdClass();
            $objTemp->campo  = 'Situação';
            $objTemp->valor  = ($situacao == 'all') ? 'Todos' : $situacao;
            $objTemp->filtro = 'Igual/Contém';

            array_push($this->filters, $objTemp);
        }

        return obj_array_unique($this->filters);
    }
}
