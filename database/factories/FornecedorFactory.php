<?php

use App\Models\Fornecedor;
use App\Models\Endereco;
use Faker\Generator as Faker;
use Faker\Provider\pt_BR\Internet;
use Faker\Provider\pt_BR\Person;
use Faker\Provider\pt_BR\PhoneNumber;
use Faker\Provider\pt_BR\Company;

$factory->define(Fornecedor::class, function (Faker $faker) {
    $faker->addProvider(new Internet($faker));
    $faker->addProvider(new Person($faker));
    $faker->addProvider(new PhoneNumber($faker));
    $faker->addProvider(new Company($faker));

    return [
        'razaoSocial' => $faker->name,
        'nomeFantasia' => $faker->name,
        'classificacao' => 'Bom',
        'tipoPessoa' => $faker->regexify('^(pf|pj)$'),
        'funcao' => $faker->regexify('^(Backend|Frontend)$'),
        'CNPJCPF' => $faker->cnpj(false),
        'inscricaoEstadual' => $faker->regexify('^(\d{7})\-(\d{2})$'),
        'inscricaoMunicipal' => $faker->regexify('^(\d{3})\.(\d{3})\-(\d{1})$'),
        'nomeTitular' => $faker->name,
        'CPF' => $faker->cpf(false),
        'email' => $faker->safeEmail,
        'telefone' => $faker->phone
    ];
});
