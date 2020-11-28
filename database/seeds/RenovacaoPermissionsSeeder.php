<?php

use Illuminate\Database\Seeder;

class RenovacaoPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //
        $permissoes = array(
            // Gerenciar Pedido
            array("value" => "renovacao_listar", "section" => "Gerenciar Renovação", "name" => "Listar"),
            array("value" => "renovacao_visualizar", "section" => "Gerenciar Renovação", "name" => "Visualizar"),
        );

        foreach ($permissoes as $key => $perm) {
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
