<?php

namespace App\Traits;

use DateTime;
use DateInterval;
use Auth;

trait CheckoutTrait
{
    protected $pedido = [];
    protected $status = 0;

    public function __load($data)
    {
        $this->pedido = $data;
    }

    public function getCheckout()
    {
        $arrTemp = [];
        $arrTemp['cliente_id'] = $this->getCliente();
        $arrTemp['pedido_id']  = $this->getPedidoId();
        $arrTemp['user_id']    = $this->getUsuarioOperacao();
        $arrTemp['parcelas']   = $this->getParcelas();
        $arrTemp['status']     = $this->getStatus();
        $arrTemp['comissao_gerada']     = 'NAO';
        if ($this->isDesconto()) {
            $arrTemp['valor']          = $this->getValorDesconto();
        } else {
            $arrTemp['valor'] = $this->getValor();
        }

        return $arrTemp;
    }

    public function getPedido()
    {
        $arrTemp = [];
        if ($this->isDesconto()) {
            $arrTemp['valor_desconto'] = $this->getDesconto();
        }
        $arrTemp['usuario_operacao_id'] = $this->getUsuarioOperacao();

        return $arrTemp;
    }

    public function setLancamentos()
    {
        $arrTemp = [];
        for ($i = 0; $i < $this->getParcelas(); ++$i) {
            $parcela = $this->getParcela($i);
            array_push($arrTemp, $parcela);
        }
        
        return $arrTemp;
    }

    public function getParcela($parcela)
    {
        $next = 0;
        
        if ($this->pedido['dia_vencimento'] <= date('j')) {
            $next += 1;
        }

        $dateInit = date('Y-m') . '-'.$this->pedido['dia_vencimento'];
        $date     = new DateTime($dateInit);
        $interval = new DateInterval('P'.($parcela+$next).'M');
        $date->add($interval);

        if ($this->isDesconto()) {
            $tempLancamento = [
                "cliente_id" => $this->pedido['cliente_id'],
                "data_vencimento" => $date->format('Y-m-d'),
                "data_emissao" => date('Y-m-d'),
                "valor_titulo" => (float)($this->getValorDesconto() / $this->getParcelas()),
                "numero_documento" => str_pad(date('dmYhis') . $this->pedido['cliente_id'] . ($parcela+1), 16, "0", STR_PAD_RIGHT),
                "negocio_id" => $this->pedido['negocio_id'],
                "pedido_id"	=> $this->pedido['pedido_id']
            ];
        } else {
            $tempLancamento = [
                "cliente_id" => $this->pedido['cliente_id'],
                "data_vencimento" => $date->format('Y-m-d'),
                "data_emissao" => date('Y-m-d'),
                "valor_titulo" => (float)($this->getValor() / $this->getParcelas()),
                "numero_documento" => str_pad(date('dmYhis') . $this->pedido['cliente_id'] . ($parcela+1), 16, "0", STR_PAD_RIGHT),
                "negocio_id" => $this->pedido['negocio_id'],
                "pedido_id"	=> $this->pedido['pedido_id']
            ];
        }

        return $tempLancamento;
    }

    public function isDesconto()
    {
        return isset($this->pedido['valor_desconto']);
    }

    public function getCliente()
    {
        return $this->pedido['cliente_id'];
    }

    public function getPedidoId()
    {
        return $this->pedido['pedido_id'];
    }

    public function getValor()
    {
        return $this->pedido['valor'];
    }

    public function getUsuarioOperacao()
    {
        return isset($this->pedido['usuario_operacao_id']) ? $this->pedido['usuario_operacao_id'] : Auth::user()->id;
    }

    public function getParcelas()
    {
        return isset($this->pedido['parcela']) ? $this->pedido['parcela'] : 1;
    }

    public function getStatus()
    {
        if (isset($this->pedido['paymentMethod'])) {
            if ($this->pedido['paymentMethod'] == 'po') {
                return 2;
            } else {
                return 1;
            }
        } else {
            return isset($this->pedido['status']) ? $this->pedido['status'] : 0;
        }
    }

    public function getDesconto()
    {
        return (float) getRealValue($this->pedido['valor_desconto']);
    }

    public function getValorDesconto()
    {
        return (float) $this->pedido['valor'] - getRealValue($this->pedido['valor_desconto']);
    }
}
