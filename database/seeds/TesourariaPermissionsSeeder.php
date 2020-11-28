<?php

use Illuminate\Database\Seeder;

class TesourariaPermissionsSeeder extends Seeder
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
            array("value" => "tesouraria_listar", "section" => "Tesouraria", "name" => "Listar"),
            array("value" => "tesouraria_adicionar", "section" => "Tesouraria", "name" => "Adicionar"),
            array("value" => "tesouraria_editar", "section" => "Tesouraria", "name" => "Editar"),
            array("value" => "tesouraria_deletar", "section" => "Tesouraria", "name" => "Deletar"),
            array("value" => "tesouraria_visualizar", "section" => "Tesouraria", "name" => "Visualizar"),
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
