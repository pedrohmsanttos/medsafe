<?php

use App\Models\Endereco;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(Endereco::class, 80)->create();
        // $this->call(SeguradorasTableSeeder::class);
    }
}
