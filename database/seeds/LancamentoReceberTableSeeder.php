<?php

use App\Models\LancamentoReceber;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class LancamentoReceberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(LancamentoReceber::class, 20)->create();

    }
}
