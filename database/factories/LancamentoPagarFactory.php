<?php

use App\Models\LancamentoPagar;
use App\Models\Fornecedor;
use Faker\Generator as Faker;

$factory->define(LancamentoPagar::class, function (Faker $faker) {
    return [
        'fornecedor_id' => function () {
            return factory(Fornecedor::class)->create()->id;
        },
        'data_vencimento' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'data_emissao' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'valor_titulo' => $faker->randomFloat(2,1,999999),
        'numero_documento' => $faker->buildingNumber
    ];
});
