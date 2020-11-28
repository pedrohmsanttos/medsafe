<?php

namespace App\Traits;

trait GanhoNegocioTrait
{
    protected $negocio = [];

    public function __load($data)
    {
        $this->negocio = $data;
    }

    public function getGanho()
    {
        $arrTemp = [];
        $arrTemp['comentario']          = $this->getComentario();
        $arrTemp['negocio_id']          = $this->getNegocioId();
        $arrTemp['data_ganho']          = $this->getDataGanho();
        $arrTemp['usuario_operacao_id'] = $this->getUsuarioOperacao();
        
        return $arrTemp;
    }

    public function getPedido($cliente, $negocio)
    {
        $arrTemp                         = array();
        $arrTemp['status_pedido_id']     = '1';
        $arrTemp['cliente_id']           = $cliente->id;
        $arrTemp['usuario_operacao_id']  = $this->getUsuarioOperacao();
        $arrTemp['data_vencimento']      = date("Y-m-d H:i:s");
        $arrTemp['valor_desconto']       = (float) 0;
        $arrTemp['valor_total']          = $negocio->valor;

        return $arrTemp;
    }

    public function dataToSql($data)
    {
        return implode('-', array_reverse(explode('/', $data)));
    }

    public function getDataGanho()
    {
        return $this->dataToSql($this->negocio['data_ganho']);
    }

    public function getComentario()
    {
        return isset($this->negocio['comentario']) ? $this->negocio['comentario'] : 'N/A';
    }

    public function getUsuarioOperacao()
    {
        return isset($this->negocio['usuario_operacao_id']) ? $this->negocio['usuario_operacao_id'] : Auth::user()->id;
    }

    public function getNegocioId()
    {
        return $this->negocio['negocio_id'];
    }

    public function getCliente()
    {
        $arrTemp                         = array();
        if ($this->negocio['tipoPessoa'] == 'pj') {
            $arrTemp['razaoSocial']        = $this->negocio['razaoSocial'];
            $arrTemp['nomeFantasia']       = $this->negocio['nomeFantasia'];
            $arrTemp['classificacao']      = 'none';
            $arrTemp['tipoPessoa']         = 'pj';
            $arrTemp['inscricaoEstadual']  = $this->negocio['inscricaoEstadual'];
            $arrTemp['inscricaoMunicipal'] = $this->negocio['inscricaoMunicipal'];
            $arrTemp['nomeTitular']        = $this->negocio['nomeTitular'];
            $arrTemp['CNPJCPF']            = $this->negocio['CNPJCPF'];
            $arrTemp['CPF']                = $this->negocio['CPF'];
            $arrTemp['email']              = $this->negocio['email'];
            $arrTemp['funcao']             = $this->negocio['funcao'];
            $arrTemp['telefone']           = $this->negocio['telefone'];
        } else {
            $arrTemp['nomeFantasia']       = $this->negocio['nomeFantasia'];
            $arrTemp['tipoPessoa']         = 'pf';
            $arrTemp['CNPJCPF']            = $this->negocio['CNPJCPF'];
            $arrTemp['email']              = $this->negocio['email'];
            $arrTemp['funcao']             = $this->negocio['funcao'];
            $arrTemp['telefone']           = $this->negocio['telefone'];
            $arrTemp['especialidade_id']           = $this->negocio['especialidade_id'];
        }

        return $arrTemp;
    }

    public function getEndereco()
    {
        $arrTemp = array();
        $arrTemp['cep']                = $this->negocio['cep'];
        $arrTemp['rua']                = $this->negocio['rua'];
        $arrTemp['numero']             = $this->negocio['numero'];
        $arrTemp['bairro']             = $this->negocio['bairro'];
        $arrTemp['municipio']          = $this->negocio['municipio'];
        $arrTemp['uf']                 = $this->negocio['uf'];

        return $arrTemp;
    }
}
