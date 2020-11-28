<?php

use Illuminate\Database\Seeder;

class RoleCorretorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'corretor_user',
            'display_name' => 'Corretor',
            'description' => 'Usuário do tipo corretor',
        ]);
    }
}
