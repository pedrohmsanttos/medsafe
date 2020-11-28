<?php

use Illuminate\Database\Seeder;
use App\Models\Apolice;
use App\Models\Beneficio;
use App\Models\Cobertura;

class ApolicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Apolice::class, 10)->create()
            ->each(function ($u) {
                $u->beneficios()->saveMany(factory(Beneficio::class, rand(1, 5))->make());
                $u->coberturas()->saveMany(factory(Cobertura::class, rand(1, 5))->make());
            });
    }
}
