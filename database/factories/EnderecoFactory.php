<?php

use App\Models\Cliente;
use App\Models\Endereco;
use Faker\Generator as Faker;
use Faker\Provider\pt_BR\Address;

$factory->define(Endereco::class, function (Faker $faker) {
    $faker->addProvider(new Address($faker));

    return [
        'cep' =>  $faker->postcode,
        'rua' => $faker->streetPrefix() . " " . $faker->name,
        'numero' => $faker->buildingNumber,
        'bairro' => $faker->name,
        'municipio' => $faker->city,
        'uf' => $faker->stateAbbr(),
        'cliente_id' => function () {
            return factory(Cliente::class)->create()->id;
        },
        
    ];
});
