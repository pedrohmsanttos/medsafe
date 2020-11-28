<?php

use Illuminate\Database\Seeder;

class ParametroPermissionsSeeder extends Seeder
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
            array("value" => "parametro_listar", "section" => "Parametro", "name" => "Listar"),
            array("value" => "parametro_editar", "section" => "Parametro", "name" => "Editar"),
            array("value" => "parametro_visualizar", "section" => "Parametro", "name" => "Visualizar"),
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
