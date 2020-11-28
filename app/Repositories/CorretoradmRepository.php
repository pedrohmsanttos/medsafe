<?php

namespace App\Repositories;

use App\Models\Corretoradm;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CorretoradmRepository
 * @package App\Repositories
 * @version August 21, 2019, 7:46 pm UTC
 *
 * @method Corretoradm findWithoutFail($id, $columns = ['*'])
 * @method Corretoradm find($id, $columns = ['*'])
 * @method Corretoradm first($columns = ['*'])
*/
class CorretoradmRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nome',
        'cpf',
        'telefone',
        'email',
        'celular',
        'corretora_id',
        'user_id',
        'aprovado',
        'comissao',
        'periodo_de_pagamento'
    ];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $clienteAttributes = [
       'nome' => 'nome',
        'cpf',
        'telefone' => 'telefone',
        'email' => 'email',
        'celular',
        'corretora_id',
        'user_id',
        'aprovado' => 'aprovado',
        'comissao' => 'comissao',
        'periodo_de_pagamento' => 'periodo_de_pagamento'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Corretoradm::class;
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
