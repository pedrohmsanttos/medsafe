<?php

namespace App\Traits;

use Auth;

trait PedidoTrait
{
    protected $pedido = [];

    public function __load($data)
    {
        $this->pedido = $data;
        $this->getItens();
    }

    public function getPedido()
    {
        $arrTemp = [];
        $arrTemp['cliente_id']          = $this->pedido['cliente_id'];
        $arrTemp['data_vencimento']     = $this->getDataVencimento();
        $arrTemp['usuario_operacao_id'] = $this->getUsuarioOperacao();
        $arrTemp['valor_total']         = $this->pedido['valorTotal'];
        $arrTemp['nome_completo']         = $this->pedido['nome_completo'];
        $arrTemp['cpf']         = $this->pedido['cpf'];
        $arrTemp['email']         = $this->pedido['email'];
        $arrTemp['telefone']         = $this->pedido['telefone'];
        $arrTemp['telefone']         = $this->pedido['telefone'];
        $arrTemp['beneficio_terceiros']         = $this->pedido['beneficio_terceiros'];

        
        return $arrTemp;
    }

    public function getItens()
    {
        $itens    = json_decode($this->pedido['itens']);
        $arrItens = [];
        $total    = 0;
        
        if (!is_array($itens)) {
            $this->pedido['valorTotal'] = $total;
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
        $this->pedido['valorTotal'] = $total;

        return $arrItens;
    }

    public function getUsuarioOperacao()
    {
        return isset($this->pedido['usuario_operacao_id']) ? $this->pedido['usuario_operacao_id'] : Auth::user()->id;
    }

    public function dataToSql($data)
    {
        return implode('-', array_reverse(explode('/', $data)));
    }

    public function getDataVencimento()
    {
        return $this->dataToSql($this->pedido['data_vencimento']);
    }
}
