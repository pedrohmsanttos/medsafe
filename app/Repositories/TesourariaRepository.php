<?php

namespace App\Repositories;

use App\Models\Tesouraria;
use App\Models\Fornecedor;
use App\Models\FormaDePagamento;
use App\Models\Cliente;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TesourariaRepository
 * @package App\Repositories
 * @version April 5, 2019, 2:23 pm UTC
 *
 * @method Tesouraria findWithoutFail($id, $columns = ['*'])
 * @method Tesouraria find($id, $columns = ['*'])
 * @method Tesouraria first($columns = ['*'])
*/
class TesourariaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'plano_de_contas_id',
        'formas_de_pagamento_id',
        'fornecedor_id',
        'cliente_id',
        'tipo',
        'valor',
        'numero_documento',
        'data_emissao',
        'data_vencimento',
        'data_disponibilidade'
    ];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $tesourariaAttributes = [
        'plano_de_contas_id'        => "Plano de Contas",
        'formas_de_pagamento_id'    => "Forma de Pagamento",
        'fornecedor_id'             => "Fornecedor",
        'cliente_id'                => "Cliente",
        'tipo'                      => "Tipo",
        'valor'                     => "Valor",
        'numero_documento'          => "Número Documento",
        'data_emissao'              => "Data de Emissão",
        'data_vencimento'           => "Data de Vencimento",
        'data_disponibilidade'      => "Data de Disponibilidade"
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Tesouraria::class;
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
                $objTemp->campo  = $this->tesourariaAttributes[$tmpBuscar[0]];

                if ($objTemp->campo == 'Fornecedor') {
                    $objTemp->valor  = Fornecedor::find($tmpBuscar[1])->razaoSocial;
                } elseif ($objTemp->campo == 'Cliente') {
                    $objTemp->valor  = Cliente::find($tmpBuscar[1])->razaoSocial;
                } elseif ($objTemp->campo == 'Forma de Pagamento') {
                    $objTemp->valor  = FormaDePagamento::find($tmpBuscar[1])->titulo;
                } elseif ($objTemp->campo == 'Data de Emissão' || $objTemp->campo == 'Data de Vencimento' ||  $objTemp->campo == 'Data de Disponibilidade') {
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
            $objTemp->campo  = $this->tesourariaAttributes[$orderBy];
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

    /**
     * Report from Tesouraria
     *
     * @param array $input
     *
     * @return  array Tesouraria
     **/
    public function relatorio($input)
    {
        $arrParams = [];
        if (
                (isset($input['cliente']) && $input['cliente'] != '*') ||
                (isset($input['fornecedor']) && $input['fornecedor'] != '*') ||
                (isset($input['forma_de_pagamento']) && $input['forma_de_pagamento'] != '*') ||
                (isset($input['plano_de_contas']) && $input['plano_de_contas'] != '*') ||
                (isset($input['data_inicial']) && $input['data_inicial'] != '' &&
                isset($input['data_final']) && $input['data_final'] != '')
            ) {
            if (isset($input['cliente']) && $input['cliente'] != '*') {
                $arrParams['cliente_id'] = $input['cliente'];
            } elseif (isset($input['fornecedor']) && $input['fornecedor'] != '*') {
                $arrParams['fornecedor_id'] = $input['fornecedor'];
            } // filtro de fornecedor
                    
            if (isset($input['forma_de_pagamento']) && $input['forma_de_pagamento'] != '*') {
                $arrParams['formas_de_pagamento_id'] = $input['forma_de_pagamento'];
            } // filtro de forma de pagamento
        
            if (isset($input['plano_de_contas']) && $input['plano_de_contas'] != '*') {
                $arrParams['plano_de_contas_id'] = $input['plano_de_contas'];
            } // filtro de plano de contas
        
            if (isset($input['data_inicial']) && $input['data_inicial'] != '' && isset($input['data_final']) && $input['data_final'] != '') {
                array_push($arrParams, ['data_emissao','>=',date("Y-m-d", strtotime(str_replace('/', '-', $input['data_inicial'])))]);
                array_push($arrParams, ['data_emissao','<=',date("Y-m-d", strtotime(str_replace('/', '-', $input['data_final'])))]);
            } // filtro de data
            
            $tesourarias = $this->findWhere($arrParams)->all();
        } else {
            $tesourarias = $this->all();
        }

        return $tesourarias;
    }
}
