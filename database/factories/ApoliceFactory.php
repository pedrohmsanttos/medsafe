<?php

use App\Models\Apolice;
use Faker\Generator as Faker;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Corretor;
use App\Models\Item;

$factory->define(Apolice::class, function (Faker $faker) {
    return [
        'corretor_id' => function () {
            return factory(Corretor::class)->create()->id;
        },
        'pedido_id' => function () {
            factory(Pedido::class)->create()->each(function ($u) {
                $u->itens()->saveMany(factory(Item::class, rand(1, 5))->make());
            });
            return Pedido::latest()->first()->id;
        },
        'cliente_id' => function () {
            return factory(Cliente::class)->create()->id;
        },
        'numero' => $faker->randomNumber(8),
        'endosso' => $faker->text(20),
        'ci' => $faker->text(20),
        'classe_bonus' => $faker->text(20),
        'proposta' => $faker->text(20),
        'data_vencimento' => date($format = 'Y-m-d')
    ];
});
