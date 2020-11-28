<?php

use Faker\Generator as Faker;
use Faker\Provider\pt_BR\Internet;
use Faker\Provider\pt_BR\Person;
use Faker\Provider\pt_BR\PhoneNumber;
use Faker\Provider\pt_BR\Company;
use App\Models\Corretora;
use App\Models\Corretor;

$factory->define(Corretor::class, function (Faker $faker) {
    $faker->addProvider(new Internet($faker));
    $faker->addProvider(new Person($faker));
    $faker->addProvider(new PhoneNumber($faker));
    $faker->addProvider(new Company($faker));

    return [
        'nome' => $faker->name(),
        'cpf' => $faker->cpf(false),
        'telefone' => $faker->phone,
        'email' => $faker->email,
        'celular' => $faker->phone,
        'corretora_id' => function () {
            return factory(Corretora::class)->create()->id;
        }
    ];
});
