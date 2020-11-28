<?php

use Illuminate\Database\Seeder;

class RoleClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // Role admin
        DB::table('roles')->insert([
            'name' => 'cliente_user',
            'display_name' => 'Cliente',
            'description' => 'Usuário do tipo cliente',
        ]);
    }
}
