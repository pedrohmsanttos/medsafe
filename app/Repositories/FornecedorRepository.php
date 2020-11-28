<?php

namespace App\Repositories;

use App\Models\Fornecedor;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class FornecedoresRepository
 * @package App\Repositories
 * @version January 2, 2019, 9:18 pm UTC
 *
 * @method Fornecedores findWithoutFail($id, $columns = ['*'])
 * @method Fornecedores find($id, $columns = ['*'])
 * @method Fornecedores first($columns = ['*'])
*/
class FornecedorRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'razaoSocial',
        'nomeFantasia',
        'classificacao',
        'tipoPessoa',
        'CNPJCPF',
        'inscricaoEstadual',
        'inscricaoMunicipal',
        'telefone',
        'email',
        'nomeTitular',
        'CPF'
    ];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $fornecedorAttributes = [
        'razaoSocial' => 'Razão Social',
        'nomeFantasia' => 'Nome Fantasia',
        'nomeTitular' => 'Nome do titular',
        'CNPJCPF' => 'CNPJ/CPF'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Fornecedor::class;
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
                $objTemp->campo  = $this->fornecedorAttributes[$tmpBuscar[0]];
                $objTemp->valor  = $tmpBuscar[1];
                $objTemp->filtro = ($tmpFiltro[1] == 'like') ? 'Contém' : 'Igual';

                array_push($this->filters, $objTemp);
            }
        }
        
        if(isset($filters) && isset($filters['orderBy']) && isset($filters['sortedBy'])){
            $orderBy         = $filters['orderBy'];
            $sortedBy        = $filters['sortedBy'];
            $objTemp         = new \stdClass();
            $objTemp->campo  = $this->fornecedorAttributes[$orderBy];
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

        return $this->filters;
    }
}
