<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\MaterialItem;
use Faker\Generator as Faker;

$factory->define(MaterialItem::class, function (Faker $faker) {

    return [
        'arquivo' => $faker->word,
        'material_id' => $faker->randomDigitNotNull,
        'deleted_at' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
