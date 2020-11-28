<?php

use Illuminate\Database\Seeder;

class BaixaPagarPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permissoes = array(
            // Baixar Contas a Receber
            array("value" => "baixaPagar_listar", "section" => "Baixar Contas a Pagar", "name" => "Listar"),
            array("value" => "baixaPagar_adicionar", "section" => "Baixar Contas a Pagar", "name" => "Adicionar"),
            array("value" => "baixaPagar_editar", "section" => "Baixar Contas a Pagar", "name" => "Editar"),
            array("value" => "baixaPagar_deletar", "section" => "Baixar Contas a Pagar", "name" => "Deletar"),
            array("value" => "baixaPagar_visualizar", "section" => "Baixar Contas a Pagar", "name" => "Visualizar"),
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
