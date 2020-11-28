<?php

use App\Models\Corretora;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CorretorasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Corretora::class, 10)->create();
    }
}
