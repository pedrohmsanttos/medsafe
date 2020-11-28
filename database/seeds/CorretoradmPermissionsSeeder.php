<?php

use Illuminate\Database\Seeder;

class CorretoraadmPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissoes = array(
            // Lançamentos a Pagar
            array("value" => "corretoradm_listar", "section" => "Gerenciamento de corretores", "name" => "Listar"),
            array("value" => "corretoradm_editar", "section" => "Gerenciamento de corretores", "name" => "Editar"),
            array("value" => "corretoradm_visualizar", "section" => "Gerenciamento de corretores", "name" => "Visualizar"),
        );

        foreach($permissoes as $key => $perm){

            DB::table('permissions')->insert([
                'name' => $perm['value'],
                'display_name' => $perm['name'],
                'description' => $perm['section'],
            ]);

            $idPermission = DB::getPdo()->lastInsertId();

            DB::table('permission_role')->insert([
                'role_id' => '1',
                'permission_id' => $idPermission,
            ]);
        }
    }
}
