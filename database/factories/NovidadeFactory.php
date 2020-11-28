<?php

use App\Models\Novidade;
use Faker\Generator as Faker;

$factory->define(Novidade::class, function (Faker $faker) {
    return [
        'titulo' => $faker->text(5),
        'texto' => $faker->text(15),
    ];
});
