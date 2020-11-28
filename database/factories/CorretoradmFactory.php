<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Corretoradm;
use Faker\Generator as Faker;

$factory->define(Corretoradm::class, function (Faker $faker) {

    return [
        'nome' => $faker->word,
        'cpf' => $faker->word,
        'telefone' => $faker->word,
        'email' => $faker->word,
        'celular' => $faker->word,
        'corretora_id' => $faker->randomDigitNotNull,
        'deleted_at' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'user_id' => $faker->randomDigitNotNull,
        'aprovado' => $faker->randomDigitNotNull,
        'comissao' => $faker->randomDigitNotNull,
        'periodo_de_pagamento' => $faker->word
    ];
});
