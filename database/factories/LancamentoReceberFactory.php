<?php

use App\Models\LancamentoReceber;
use App\Models\Cliente;
use Faker\Generator as Faker;

$factory->define(LancamentoReceber::class, function (Faker $faker) {
    return [
        'data_vencimento' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'data_emissao' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'valor_titulo' => $faker->randomFloat(2,1,999999),
        'numero_documento' => $faker->buildingNumber,
        'cliente_id' => function () {
            return factory(Cliente::class)->create()->id;
        }


    ];
});
