<?php

use Faker\Generator as Faker;
use App\Models\Seguradora;
use Faker\Provider\pt_BR\Person;

$factory->define(Seguradora::class, function (Faker $faker) {

    $faker->addProvider(new Person($faker));

    return [
        'name'              => $faker->name,
        'descricaoCorretor' => $faker->text(15),
        'CNPJ'              => $faker->cnpj(false),
        'telefone'          => $faker->phone,
        'email'             => $faker->safeEmail,
    ];
});
