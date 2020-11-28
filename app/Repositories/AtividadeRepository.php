<?php

namespace App\Repositories;

use App\Models\Atividade;
use App\Models\Negocio;
use App\Models\User;
use App\Models\TipoAtividade;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AtividadeRepository
 * @package App\Repositories
 * @version February 1, 2019, 4:11 pm UTC
 *
 * @method Atividade findWithoutFail($id, $columns = ['*'])
 * @method Atividade find($id, $columns = ['*'])
 * @method Atividade first($columns = ['*'])
*/
class AtividadeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'negocio_id',
        'assunto',
        'data',
        'hora',
        'duracao',
        'notas',
        'urlProposta',
        'tipo_atividade_id',
        'realizada',
        'dataVencimento',
        'criador_id',
        'atribuido_id'
    ];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $atividadeAttributes = [
        'negocio_id' => "Negócio",
        'assunto'    => "Assunto",
        'data'       => "Data",
        'hora'       => "Hora",
        'duracao'    => "Duração",
        'notas'      => "Notas",
        'urlProposta' => "URL da Proposta",
        'tipo_atividade_id' => "Tipo de Atividade",
        'realizada' => "Realizada",
        'dataVencimento' => "Data de Vencimento",
        'criador_id' => "Author",
        'atribuido_id' => "Atribuido"
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Atividade::class;
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
                $objTemp->campo  = $this->atividadeAttributes[$tmpBuscar[0]];
                if ($objTemp->campo == 'Negócio') {
                    $objTemp->valor  = Negocio::find($tmpBuscar[1])->titulo;
                } elseif ($objTemp->campo == 'Atribuido') {
                    $objTemp->valor  = User::find($tmpBuscar[1])->name;
                } elseif ($objTemp->campo == 'Realizada') {
                    $objTemp->valor  = ($tmpBuscar[1] == 0) ? 'Não Realizado' : 'Realizado';
                } elseif ($objTemp->campo == 'Disponibilidade' || $objTemp->campo == 'Baixa') {
                    $objTemp->valor = date('d/m/Y', strtotime(str_replace("-", "/", $tmpBuscar[1])));
                } elseif ($objTemp->campo == 'Tipo de Atividade') {
                    $objTemp->valor  = TipoAtividade::find($tmpBuscar[1])->descricao;
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
            $objTemp->campo  = $this->atividadeAttributes[$orderBy];
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
