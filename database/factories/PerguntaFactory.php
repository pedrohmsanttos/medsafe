<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Pergunta;
use Faker\Generator as Faker;

$factory->define(Pergunta::class, function (Faker $faker) {

    return [
        'pergunta' => $faker->word,
        'resposta' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
