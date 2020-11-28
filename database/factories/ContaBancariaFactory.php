<?php

use App\Models\ContaBancaria;
use Faker\Generator as Faker;

$factory->define(ContaBancaria::class, function (Faker $faker) {
    return [
        'classificacao' => 'Bom',
        'descricao' => $faker->realText(30),
        'numeroConta' => $faker->randomNumber(7),
        'numeroAgencia' => $faker->randomNumber(4),
        'dataSaldoInicial' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'saldoInicial' => $faker->randomFloat(2,1,999999),
        'caixa' => $faker->regexify('^(Online|Fisico)$'),
        'banco' => $faker->regexify('^(Caixa|Banco do Brasil)$'),
        'operacao' => '01'
    ];
});
