<?php

use Faker\Generator as Faker;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Corretor;
use App\Models\Usuario;

$factory->define(Pedido::class, function (Faker $faker) {
    return [
        'status_pedido_id' => 1,
        'cliente_id' => function () {
            return factory(Cliente::class)->create()->id;
        },
        'corretor_id' => function () {
            return factory(Corretor::class)->create()->id;
        },
        'usuario_operacao_id' => 1,
        'data_vencimento' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'valor_total' => $faker->randomFloat(2, 1, 9999),
        'valor_desconto' => 0
    ];
});
