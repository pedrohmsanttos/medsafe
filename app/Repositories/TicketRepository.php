<?php

namespace App\Repositories;

use App\Models\Ticket;
use App\Models\CategoriaTicket;
use App\Models\Cliente;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TicketRepository
 * @package App\Repositories
 * @version June 12, 2019, 8:51 pm UTC
 *
 * @method Ticket findWithoutFail($id, $columns = ['*'])
 * @method Ticket find($id, $columns = ['*'])
 * @method Ticket first($columns = ['*'])
*/
class TicketRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'category_id',
        'titulo',
        'status'
    ];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $ticketAttributes = [
        'id' => 'ID',
        'category_id' => 'Categoria',
        'titulo' => 'Titulo',
        'status' => 'Status',
        'cliente' => 'Cliente',
        'CPF' => 'Cliente - CNPJCPF'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Ticket::class;
    }

    /**
     * Mapping of filter
     **/
    public function filter($filters, $cliente_id)
    {
        if (isset($filters) && isset($filters['search']) && isset($filters['searchFields'])) {
            $search       = explode(';', $filters['search']);
            $searchFields = explode(';', $filters['searchFields']);
            foreach ($search as $index => $filter) {
                $tmpBuscar = explode(':', $filter);
                $tmpFiltro = explode(':', $searchFields[$index]);
                $objTemp   = new \stdClass();
                $objTemp->campo  = $this->ticketAttributes[$tmpBuscar[0]];
                $objTemp->filtro = ($tmpFiltro[1] == 'like') ? 'Contém' : 'Igual';
                if ($objTemp->campo == 'Categoria') {
                    $objTemp->valor  = CategoriaTicket::find($tmpBuscar[1])->descricao;
                } elseif ($objTemp->campo == 'Status') {
                    if ($tmpBuscar[1] == 0) {
                        $objTemp->valor = 'Aguardando Atendimento';
                    } elseif ($tmpBuscar[1] == 1) {
                        $objTemp->valor = 'Em Atendimento';
                    } else {
                        $objTemp->valor = 'Fechado';
                    }
                } else {
                    $objTemp->valor  = $tmpBuscar[1];
                }

                array_push($this->filters, $objTemp);
            }
        }

        if (isset($cliente_id)) {
            $objTemp   = new \stdClass();
            $objTemp->filtro = 'Contém/Igual';
            $objTemp->campo  = 'Cliente';
            $objTemp->valor  = Cliente::find($cliente_id)->nomeFantasia;

            array_push($this->filters, $objTemp);
        }

        if (isset($filters['cpf'])) {
            $objTemp   = new \stdClass();
            $objTemp->filtro = 'Contém/Igual';
            $objTemp->campo  = 'Cliente';
            $cliente = Cliente::where('CNPJCPF', $filters['cpf'])->first();
            if (isset($cliente)) {
                $objTemp->valor  = Cliente::where('CNPJCPF', $filters['cpf'])->first()->nomeFantasia;
            } else {
                $objTemp->valor  = 'Cliente não cadastrado!';
            }

            array_push($this->filters, $objTemp);
        }
        
        if (isset($filters) && isset($filters['orderBy']) && isset($filters['sortedBy'])) {
            $orderBy         = $filters['orderBy'];
            $sortedBy        = $filters['sortedBy'];
            $objTemp         = new \stdClass();
            $objTemp->campo  = $this->ticketAttributes[$orderBy];
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
