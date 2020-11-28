<?php
    function estados()
    {
        return array(
                    array("sigla" => "AC", "nome" => "Acre"),
                    array("sigla" => "AL", "nome" => "Alagoas"),
                    array("sigla" => "AM", "nome" => "Amazonas"),
                    array("sigla" => "AP", "nome" => "Amapá"),
                    array("sigla" => "BA", "nome" => "Bahia"),
                    array("sigla" => "CE", "nome" => "Ceará"),
                    array("sigla" => "DF", "nome" => "Distrito Federal"),
                    array("sigla" => "ES", "nome" => "Espírito Santo"),
                    array("sigla" => "GO", "nome" => "Goiás"),
                    array("sigla" => "MA", "nome" => "Maranhão"),
                    array("sigla" => "MT", "nome" => "Mato Grosso"),
                    array("sigla" => "MS", "nome" => "Mato Grosso do Sul"),
                    array("sigla" => "MG", "nome" => "Minas Gerais"),
                    array("sigla" => "PA", "nome" => "Pará"),
                    array("sigla" => "PB", "nome" => "Paraíba"),
                    array("sigla" => "PR", "nome" => "Paraná"),
                    array("sigla" => "PE", "nome" => "Pernambuco"),
                    array("sigla" => "PI", "nome" => "Piauí"),
                    array("sigla" => "RJ", "nome" => "Rio de Janeiro"),
                    array("sigla" => "RN", "nome" => "Rio Grande do Norte"),
                    array("sigla" => "RO", "nome" => "Rondônia"),
                    array("sigla" => "RS", "nome" => "Rio Grande do Sul"),
                    array("sigla" => "RR", "nome" => "Roraima"),
                    array("sigla" => "SC", "nome" => "Santa Catarina"),
                    array("sigla" => "SE", "nome" => "Sergipe"),
                    array("sigla" => "SP", "nome" => "São Paulo"),
                    array("sigla" => "TO", "nome" => "Tocantins")
                );
    }

    function bancos()
    {
        return array(
            array('code' => '001', 'name' => 'Banco do Brasil'),
            array('code' => '351', 'name' => 'Banco Santander'),
            array('code' => '033', 'name' => 'Banco Santander Brasil'),
            array('code' => '748', 'name' => 'Banco Cooperativo Sicredi'),
            array('code' => '004', 'name' => 'Banco do Nordeste'),
            array('code' => '041', 'name' => 'Banrisul'),
            array('code' => '237', 'name' => 'Bradesco'),
            array('code' => '104', 'name' => 'Caixa Econômica Federal'),
            array('code' => '399', 'name' => 'HSBC'),
            array('code' => '341', 'name' => 'Itau'),
        );
    }

    function status_negocio()
    {
        return  [
        'EM ABERTO', 'PERDIDO', 'GANHO', 'EXCLUÍDO'
       ];
    }

    function limpaMascara($campo)
    {
        $campo = str_replace(".", "", $campo);
        $campo = str_replace("-", "", $campo);
        $campo = str_replace("/", "", $campo);
        
        return $campo;
    }

    /**
     * Mapping of check permissions
     **/
    function in_array_field($needle, $needleField, $haystack, $strict = false)
    {
        if ($strict) {
            foreach ($haystack as $item) {
                if (isset($item->$needleField) && $item->$needleField === $needle) {
                    return true;
                }
            }
        } else {
            foreach ($haystack as $item) {
                if (isset($item->$needleField) && $item->$needleField == $needle) {
                    return true;
                }
            }
        }
        return false;
    }

    function obj_array_unique($data)
    {
        // walk input array
        $_data = array();
        foreach ($data as $key => $v) {
            $arrTmp = (array) $v;
            if (isset($_data[$arrTmp['campo']])) {
                // found duplicate
                continue;
            }
            // remember unique item
            $_data[$arrTmp['campo']] = $v;
        }
        // if you need a zero-based array, otheriwse work with $_data
        $data = array_values($_data);

        return $data;
    }

    function getFilter($filter, $arr)
    {
        $convert_to_array = explode(';', $arr);

        for ($i=0; $i < count($convert_to_array); $i++) {
            $key_value = explode(':', $convert_to_array [$i]);
            $end_array[$key_value[0]] = $key_value[1];
        }

        return $end_array[$filter];
    }

    function dateBRtoSQL($date)
    {
        return implode('-', array_reverse(explode('/', $date)));
    }

    function getRealValue($value)
    {
        $value = str_replace('R$ ', '', $value);
    
        $valor = explode(",", $value);
        $valorFinal = str_replace(".", "", $valor[0]);
        if (count($valor)>1) {
            $valorFinal .= "." . $valor[1];
        }

        return (float) $valorFinal;
    }

    function dateSqlToBR($date)
    {
        return date("d/m/Y", strtotime($date));
    }

    function removeLastCharacter($string){
        return mb_substr($string, 0, -1);
    }
