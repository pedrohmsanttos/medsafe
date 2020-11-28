<?php

use Illuminate\Database\Seeder;
use App\Models\LancamentoPagar;
use Faker\Factory as Faker;

class LancamentoPagarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(LancamentoPagar::class, 20)->create();
    }
}
