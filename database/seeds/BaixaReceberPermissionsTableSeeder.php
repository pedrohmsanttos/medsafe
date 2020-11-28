<?php

use Illuminate\Database\Seeder;

class BaixaReceberPermissionsTableSeeder extends Seeder
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
            array("value" => "baixaReceber_listar", "section" => "Baixar Contas a Receber", "name" => "Listar"),
            array("value" => "baixaReceber_adicionar", "section" => "Baixar Contas a Receber", "name" => "Adicionar"),
            array("value" => "baixaReceber_editar", "section" => "Baixar Contas a Receber", "name" => "Editar"),
            array("value" => "baixaReceber_deletar", "section" => "Baixar Contas a Receber", "name" => "Deletar"),
            array("value" => "baixaReceber_visualizar", "section" => "Baixar Contas a Receber", "name" => "Visualizar"),
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
