<?php

use Illuminate\Database\Seeder;

class MaterialPermissionsTableSeeder extends Seeder
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
            array("value" => "material_listar", "section" => "Material", "name" => "Listar"),
            array("value" => "material_adicionar", "section" => "Material", "name" => "Adicionar"),
            array("value" => "material_editar", "section" => "Material", "name" => "Editar"),
            array("value" => "material_deletar", "section" => "Material", "name" => "Deletar"),
            array("value" => "material_visualizar", "section" => "Material", "name" => "Visualizar"),
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
