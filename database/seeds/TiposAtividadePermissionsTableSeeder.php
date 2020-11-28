<?php

use Illuminate\Database\Seeder;

class TiposAtividadePermissionsTableSeeder extends Seeder
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
            // Tipos de Atividade
            array("value" => "tipo_atividade_listar", "section" => "Tipos de Atividade", "name" => "Listar"),
            array("value" => "tipo_atividade_adicionar", "section" => "Tipos de Atividade", "name" => "Adicionar"),
            array("value" => "tipo_atividade_editar", "section" => "Tipos de Atividade", "name" => "Editar"),
            array("value" => "tipo_atividade_deletar", "section" => "Tipos de Atividade", "name" => "Deletar"),
            array("value" => "tipo_atividade_visualizar", "section" => "Tipos de Atividade", "name" => "Visualizar"),
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
