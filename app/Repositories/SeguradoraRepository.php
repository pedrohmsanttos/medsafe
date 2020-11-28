<?php

namespace App\Repositories;

use App\Models\Seguradora;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SeguradoraRepository
 * @package App\Repositories
 * @version January 11, 2019, 5:10 pm UTC
 *
 * @method Seguradora findWithoutFail($id, $columns = ['*'])
 * @method Seguradora find($id, $columns = ['*'])
 * @method Seguradora first($columns = ['*'])
*/
class SeguradoraRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'descricaoCorretor',
        'CNPJ',
        'telefone',
        'email'
    ];

    /**
     * @var array
     */
    protected $seguradoraAttributes = [
        'descricaoCorretor' => 'Descrição do Corretor',
        'CNPJ'              => 'CNPJ',
        'telefone'          => 'Telefone',
        'email'             => 'Email'
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
        return Seguradora::class;
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
                $objTemp->campo  = $this->seguradoraAttributes[$tmpBuscar[0]];
                $objTemp->valor  = $tmpBuscar[1];
                $objTemp->filtro = ($tmpFiltro[1] == 'like') ? 'Contém' : 'Igual';

                array_push($this->filters, $objTemp);
            }
        }
        
        if(isset($filters) && isset($filters['orderBy']) && isset($filters['sortedBy'])){
            $orderBy         = $filters['orderBy'];
            $sortedBy        = $filters['sortedBy'];
            $objTemp         = new \stdClass();
            $objTemp->campo  = $this->seguradoraAttributes[$orderBy]; 
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
