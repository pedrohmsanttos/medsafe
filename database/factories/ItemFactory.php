<?php

use Faker\Generator as Faker;
use App\Models\Item;
use App\Models\ProdutoTipoProduto;

$factory->define(Item::class, function (Faker $faker) {
    $tabelaPreco = ProdutoTipoProduto::inRandomOrder()->first();
    
    return [
        'tabela_preco_id' => $tabelaPreco->id,
        'valor' => $tabelaPreco->valor,
        'quantidade' => 1
    ];
});
