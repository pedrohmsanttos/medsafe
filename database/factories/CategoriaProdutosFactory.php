<?php

use App\Models\CategoriaProdutos;
use Faker\Generator as Faker;
use Faker\Provider\pt_BR\Person;

$factory->define(CategoriaProdutos::class, function (Faker $faker) {

    $faker->addProvider(new Person($faker));

    return [
        //
        'descricao'              => $faker->name,
    ];
});
