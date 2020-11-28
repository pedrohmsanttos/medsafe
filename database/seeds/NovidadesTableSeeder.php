<?php

use App\Models\Novidade;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class NovidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Novidade::class, 20)->create();
    }
}
