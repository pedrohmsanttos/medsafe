<?php

namespace App\Repositories;

use App\Models\Negocio;
use App\Models\Pessoa;
use App\Models\Organizacao;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class NegocioRepository
 * @package App\Repositories
 * @version January 17, 2019, 6:53 pm UTC
 *
 * @method Negocio findWithoutFail($id, $columns = ['*'])
 * @method Negocio find($id, $columns = ['*'])
 * @method Negocio first($columns = ['*'])
*/
class NegocioRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'titulo',
        'valor',
        'data_fechamento',
        'data_criacao',
        'etapa',
        'status',
        'data_perda',
        'data_ganho',
        'motivo_perda',
        'organizacao_id',
        'pessoa_id',
        'motivo_perda_negocio_id'
    ];
    protected $filters = [];


    /**
     * @var array
     */
    protected $negocioAttributes = [
        'titulo'                    => 'Título',
        'valor'                     => 'Valor',
        'data_fechamento'           => 'Data de Fechamento',
        'data_criacao'              => 'Data de Criação',
        'etapa'                     => 'Etapa',
        'status'                    => 'Status',
        'data_perda'                => 'Data da Perda',
        'data_ganho'                => 'Data do Ganho',
        'organizacao_id'            => 'Organização',
        'pessoa_id'                 => 'Pessoa',
        'motivo_perda_negocio_id'   => 'Motivo da Perda'
    ];

    public function model()
    {
        return Negocio::class;
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
                $objTemp->campo  = $this->negocioAttributes[$tmpBuscar[0]];

                $valor = $tmpBuscar[1];

                if( strtoupper( $tmpBuscar[0] )  == "STATUS"){
                    $valor = status_negocio()[$tmpBuscar[1]];
                }

                if (  $objTemp->campo  == 'Pessoa') {
                    $valor  = Pessoa::find($tmpBuscar[1])->nome;
                }

                if ( $objTemp->campo  == 'Organização') {
                    $valor  = Organizacao::find($tmpBuscar[1])->nome;
                }
                if ($tmpBuscar[0] == "data_criacao") {
                    $objTemp->valor = date('d/m/Y', strtotime(str_replace("-", "/", $tmpBuscar[1])));
                    
                }
                else{
                    $objTemp->valor  = $valor;
                }
                
                
             
                $objTemp->filtro = ($tmpFiltro[1] == 'like') ? 'Contém' : 'Igual';

                array_push($this->filters, $objTemp);
            }
        }
        
        if(isset($filters) && isset($filters['orderBy']) && isset($filters['sortedBy'])){
            $orderBy         = $filters['orderBy'];
            $sortedBy        = $filters['sortedBy'];
            $objTemp         = new \stdClass();
            $objTemp->campo  =  $this->negocioAttributes[$orderBy];
            $objTemp->valor  = ($sortedBy == 'asc') ? 'Crescente' : 'Decrescente';
            $objTemp->filtro = 'Ordem';

            array_push($this->filters, $objTemp);
        }
        
        if(isset($filters) && isset($filters['situacao'])){
            
            $situacao         = $filters['situacao'];
            $objTemp         = new \stdClass();
            $objTemp->campo  = 'Situação';
            $objTemp->valor  = ($situacao == 'all') ? 'Todos' : $situacao;
            $objTemp->filtro = 'Contém/Igual';

            array_push($this->filters, $objTemp);
        }

        return $this->filters;
    }
    
    

    public function relatorio($input)
    {
        $this->input = $input;
        
        $negocios = $this->scopeQuery(function ($query) {
            if ((isset($this->input['usuario']) && $this->input['usuario'] != '*') && (isset($this->input['data_inicial']) && $this->input['data_inicial'] != '' && !is_null($this->input['data_inicial']) && isset($this->input['data_final']) && $this->input['data_final'] != '' && !is_null($this->input['data_final']))) {
                $query = $query->join('users as u', 'u.id', '=', 'negocios.usuario_operacao_id')
                ->leftJoin('organizacaos as o', 'o.id', '=', 'negocios.organizacao_id')
                ->leftJoin('pessoas as p', 'p.id', '=', 'negocios.pessoa_id')
                ->where('negocios.usuario_operacao_id', (int) intval($this->input['usuario']))
                ->whereBetween('negocios.data_criacao', [date("Y-m-d", strtotime(str_replace('/', '-', $this->input['data_inicial']))).' 00:00:00', date("Y-m-d", strtotime(str_replace('/', '-', $this->input['data_final']))).' 23:59:59' ])
                ->select('p.nome as pessoas','o.nome as organizacao','u.name as usuario', 'negocios.*');
            }
            
            if (isset($this->input['usuario']) && $this->input['usuario'] != '*') {
                $query = $query->join('users as us', 'us.id', '=', 'negocios.usuario_operacao_id')
                ->leftJoin('organizacaos as org', 'org.id', '=', 'negocios.organizacao_id')
                ->leftJoin('pessoas as pes', 'pes.id', '=', 'negocios.pessoa_id')
                ->where('usuario_operacao_id', intval($this->input['usuario']))
                ->select('pes.nome as pessoas','org.nome as organizacao','us.name as usuario', 'negocios.*');
            } // filtro de usuario

            if (isset($this->input['data_inicial']) && $this->input['data_inicial'] != '' && isset($this->input['data_final']) && $this->input['data_final'] != '') {
                $query = $query->join('users as use', 'use.id', '=', 'negocios.usuario_operacao_id')
                ->leftJoin('organizacaos as orga', 'orga.id', '=', 'negocios.organizacao_id')
                ->leftJoin('pessoas as pess', 'pess.id', '=', 'negocios.pessoa_id')
                ->whereBetween('negocios.data_criacao', [date("Y-m-d", strtotime(str_replace('/', '-', $this->input['data_inicial']))).' 00:00:00', date("Y-m-d", strtotime(str_replace('/', '-', $this->input['data_final']))).' 23:59:59' ])
                ->select('pess.nome as pessoas','orga.nome as organizacao','use.name as usuario', 'negocios.*');
            } 
            if ($this->input['usuario'] == '*'){
                $query = $query->join('users', 'users.id', '=', 'negocios.usuario_operacao_id')
                ->leftJoin('organizacaos', 'organizacaos.id', '=', 'negocios.organizacao_id')
                ->leftJoin('pessoas', 'pessoas.id', '=', 'negocios.pessoa_id')
                ->select('pessoas.nome as pessoas','organizacaos.nome as organizacao','users.name as usuario', 'negocios.*');
            }
            //dd($query->toSql());
            return $query;
        })->all();

        //dd($negocios);
        
        return $negocios;
    }

}
