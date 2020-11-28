<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comissao;
use Faker\Generator as Faker;

$factory->define(Comissao::class, function (Faker $faker) {

    return [
        'corretor_id' => $faker->randomDigitNotNull,
        'checkout_id' => $faker->randomDigitNotNull,
        'percentual_comissao' => $faker->word,
        'comissao' => $faker->word,
        'valor' => $faker->word,
        'deleted_at' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'status_aprovacao' => $faker->word
    ];
});
