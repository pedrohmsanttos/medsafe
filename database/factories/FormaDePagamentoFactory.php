<?php

use App\Models\FormaDePagamento;
use Faker\Generator as Faker;

$factory->define(FormaDePagamento::class, function (Faker $faker) {
    return [
        'titulo' => $faker->title
    ];
});
