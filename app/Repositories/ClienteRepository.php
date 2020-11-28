<?php

namespace App\Repositories;

use App\Models\Cliente;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ClienteRepository
 * @package App\Repositories
 * @version December 21, 2018, 5:06 pm UTC
 *
 * @method Cliente findWithoutFail($id, $columns = ['*'])
 * @method Cliente find($id, $columns = ['*'])
 * @method Cliente first($columns = ['*'])
*/
class ClienteRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'razaoSocial',
        'nomeFantasia',
        'classificacao',
        'tipoPessoa',
        'CNPJCPF',
        'inscricaoEstadual',
        'inscricaoMunicipal',
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
    protected $clienteAttributes = [
        'razaoSocial' => 'Razão Social',
        'email' => 'E-mail',
        'nomeFantasia' => 'Nome Fantasia',
        'classificacao' => 'Classificação',
        'tipoPessoa' => 'Tipo de Pessoa',
        'inscricaoEstadual' => 'Inscrição Municipal',
        'inscricaoMunicipal' => 'Inscrição Estadual',
        'nomeTitular' => 'Nome do titular',
        'CNPJCPF' => 'CNPJ/CPF',
        'CPF' => 'CPF do titular',
        'cep' => 'CEP',
        'rua' => 'Logradouro',
        'numero' => 'Número',
        'bairro' => 'Bairoo',
        'municipio' => 'Município',
        'uf' => 'Estado',
        'funcao' => 'Função',
        'telefone' => 'Telefone'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Cliente::class;
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
            $objTemp->filtro = 'Igual/Contém';

            array_push($this->filters, $objTemp);
        }
        
        return $this->filters;
    }
}
