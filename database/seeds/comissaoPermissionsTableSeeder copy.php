<?php

use Illuminate\Database\Seeder;

class ComissaoPermissionsTableSeeder extends Seeder
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
            array("value" => "comissao_listar", "section" => "Gerenciar Comissões", "name" => "Listar"),
            array("value" => "comissao_adicionar", "section" => "Gerenciar Comissões", "name" => "Adicionar"),
            array("value" => "comissao_editar", "section" => "Gerenciar Comissões", "name" => "Editar"),
            array("value" => "comissao_deletar", "section" => "Gerenciar Comissões", "name" => "Deletar"),
            array("value" => "comissao_visualizar", "section" => "Gerenciar Comissões", "name" => "Visualizar"),
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
