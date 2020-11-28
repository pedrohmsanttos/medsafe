<?php

use Illuminate\Database\Seeder;

class CotacaoCorretorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Adicionar as permissões necessárias para o Corretor/Negócio
        $permissoes   = DB::table('permissions')->where('name', 'like', 'negocios_%')->get();
        $roleCorretor = DB::table('roles')->where('name', 'corretor_user')->first();

        foreach ($permissoes as $key => $value) {
            DB::table('permission_role')->insert([
                'role_id' => $roleCorretor->id,
                'permission_id' => $value->id,
            ]);
        }
    }
}
