<?php

use App\Models\BaixaReceber;
use App\Models\ContaBancaria;
use App\Models\FormaDePagamento;
use App\Models\LancamentoReceber;
use Faker\Generator as Faker;

$factory->define(BaixaReceber::class, function (Faker $faker) {
    return [
        'disponibilidade'      => $faker->date($format = 'Y-m-d', $max = 'now'),
        'baixa'                => $faker->date($format = 'Y-m-d', $max = 'now'),
        'valor_pago'           => $faker->randomFloat(2,1,999999),
        'valor_residual'       => $faker->randomFloat(2,1,999999),
        'pagamento_id'         => function () {
            return factory(FormaDePagamento::class)->create()->id;
        },
        'conta_bancaria_id'    => function () {
            return factory(ContaBancaria::class)->create()->id;
        },
        'lancamentoreceber_id' => function () {
            return factory(LancamentoReceber::class)->create()->id;
        }
    ];
});
