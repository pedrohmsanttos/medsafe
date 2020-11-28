<?php

use App\Models\Beneficio;
use App\Models\Apolice;
use Faker\Generator as Faker;

$factory->define(Beneficio::class, function (Faker $faker) {
    return [
        'apolice_id' => function () {
            return factory(Apolice::class)->create()->id;
        },
        'nome' => $faker->text(30),
        'valor' => $faker->text(30)
    ];
});
