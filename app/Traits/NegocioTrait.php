<?php

namespace App\Traits;

use Auth;

trait NegocioTrait
{
    protected $negocio = [];

    public function __load($data)
    {
        $this->negocio = $data;
        $this->getItens();// calcular o valor total
    }

    public function getNegocio()
    {
        $arrTemp = [];
        $arrTemp['titulo']                 = $this->getTitulo();
        $arrTemp['valor']                  = $this->getValorTotal();
        $arrTemp['data_criacao']           = $this->getDataCriacao();
        $arrTemp['etapa']                  = $this->getEtapa();
        $arrTemp['status']                 = $this->getStatus();
        $arrTemp['usuario_operacao_id']    = $this->getUsuarioOperacao();
        
        return $arrTemp;
    }

    public function getSolicitante()
    {
        $arrTemp = [];
        $arrTemp['nome']            = $this->getNome();
        $arrTemp['telefone']        = $this->getTelefone();
        $arrTemp['email']           = $this->getEmail();
        if ($this->isOrganizacao()) {
            $arrTemp['faturamento_id'] = $this->getFaturamento();
        }
        
        return $arrTemp;
    }

    public function getEndereco()
    {
        $arrTemp = [];
        $arrTemp['cep']        = $this->getCep();
        $arrTemp['rua']        = $this->getRua();
        $arrTemp['numero']     = $this->getNumero();
        $arrTemp['bairro']     = $this->getBairro();
        $arrTemp['municipio']  = $this->getMunicipio();
        $arrTemp['uf']         = $this->getUf();
        
        return $arrTemp;
    }

    public function getItens()
    {
        $itens    = json_decode($this->negocio['itens']);
        $arrItens = [];
        $total    = 0;
        
        if (!is_array($itens)) {
            $this->negocio['valorTotal'] = $total;
            return $arrItens;
        }

        foreach ($itens as $value) {
            $tempItem = [
                    "tabela_preco_id" => $value->_id,
                    "valor" => $value->_price,
                    "quantidade" => $value->_quantity
                ];
            $total   +=  $value->_price * $value->_quantity;
            array_push($arrItens, $tempItem);
        }
        $this->negocio['valorTotal'] = $total;

        return $arrItens;
    }

    public function getTitulo()
    {
        return $this->negocio['titulo'];
    }

    public function getValorTotal()
    {
        return $this->negocio['valorTotal'];
    }

    public function dataToSql($data)
    {
        return implode('-', array_reverse(explode('/', $data)));
    }

    public function getDataCriacao()
    {
        return $this->dataToSql($this->negocio['data_criacao']);
    }

    public function getEtapa()
    {
        return 'Negociação';
    }

    public function getStatus()
    {
        return 0;
    }

    public function getUsuarioOperacao()
    {
        return isset($this->negocio['usuario_operacao_id']) ? $this->negocio['usuario_operacao_id'] : Auth::user()->id;
    }

    public function getNome()
    {
        return $this->negocio['nome'];
    }

    public function getTelefone()
    {
        return $this->negocio['telefone'];
    }

    public function getEmail()
    {
        return $this->negocio['email'];
    }

    public function isOrganizacao()
    {
        return (isset($this->negocio['tipopessoa']) && $this->negocio['tipopessoa'] == 2) ? true : false;
    }

    public function getFaturamento()
    {
        return $this->negocio['faturamento_id'];
    }

    public function getCep()
    {
        return $this->negocio['cep'];
    }

    public function getRua()
    {
        return $this->negocio['rua'];
    }

    public function getNumero()
    {
        return $this->negocio['numero'];
    }

    public function getBairro()
    {
        return $this->negocio['bairro'];
    }

    public function getMunicipio()
    {
        return $this->negocio['municipio'];
    }

    public function getUf()
    {
        return $this->negocio['uf'];
    }
}
