<?php

use Faker\Generator as Faker;
use App\Models\Corretora;
use Faker\Provider\pt_BR\Internet;
use Faker\Provider\pt_BR\Person;
use Faker\Provider\pt_BR\PhoneNumber;
use Faker\Provider\pt_BR\Company;

$factory->define(Corretora::class, function (Faker $faker) {
    $faker->addProvider(new Internet($faker));
    $faker->addProvider(new Person($faker));
    $faker->addProvider(new PhoneNumber($faker));
    $faker->addProvider(new Company($faker));

    return [
        'descricao' => $faker->name,
        'cnpj'      => $faker->cnpj(false),
        'telefone'  => $faker->phone,
        'email'     => $faker->safeEmail,
        'susep'     => $faker->regexify('^(\d{5})\-(\d{2})$')
    ];
});
