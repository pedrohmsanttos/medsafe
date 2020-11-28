<?php

use App\Models\CategoriaProdutos;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CategoriaProdutosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    
    {
        factory(CategoriaProdutos::class, 20)->create();
    }
}
