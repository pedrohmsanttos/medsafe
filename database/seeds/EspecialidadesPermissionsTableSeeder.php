<?php

use Illuminate\Database\Seeder;

class EspecialidadesPermissionsTableSeeder extends Seeder
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
            // Lançamentos a Pagar
            array("value" => "especialidade_listar", "section" => "Especialidades", "name" => "Listar"),
            array("value" => "especialidade_adicionar", "section" => "Especialidades", "name" => "Adicionar"),
            array("value" => "especialidade_editar", "section" => "Especialidades", "name" => "Editar"),
            array("value" => "especialidade_deletar", "section" => "Especialidades", "name" => "Deletar"),
            array("value" => "especialidade_visualizar", "section" => "Especialidades", "name" => "Visualizar"),
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
