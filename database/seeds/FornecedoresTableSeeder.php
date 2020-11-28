<?php

use App\Models\Fornecedor;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FornecedoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Fornecedor::class, 80)->create();
    }
}
