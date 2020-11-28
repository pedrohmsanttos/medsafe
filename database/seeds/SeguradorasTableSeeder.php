<?php

use App\Models\Seguradora;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SeguradorasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Seguradora::class, 20)->create();
    }
}
