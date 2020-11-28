<?php

use Illuminate\Database\Seeder;

class PedidosPermissionsTableSeeder extends Seeder
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
            array("value" => "pedidos_listar", "section" => "Gerenciar Pedido", "name" => "Listar"),
            array("value" => "pedidos_adicionar", "section" => "Gerenciar Pedido", "name" => "Adicionar"),
            array("value" => "pedidos_editar", "section" => "Gerenciar Pedido", "name" => "Editar"),
            array("value" => "pedidos_deletar", "section" => "Gerenciar Pedido", "name" => "Deletar"),
            array("value" => "pedidos_visualizar", "section" => "Gerenciar Pedido", "name" => "Visualizar"),
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
