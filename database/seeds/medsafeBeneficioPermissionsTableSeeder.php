<?php

use Illuminate\Database\Seeder;

class MedsafeBeneficioPermissionsTableSeeder extends Seeder
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
            array("value" => "medsafeBeneficio_listar", "section" => "Benefícios MEDSafer", "name" => "Listar"),
            array("value" => "medsafeBeneficio_adicionar", "section" => "Benefícios MEDSafer", "name" => "Adicionar"),
            array("value" => "medsafeBeneficio_editar", "section" => "Benefícios MEDSafer", "name" => "Editar"),
            array("value" => "medsafeBeneficio_deletar", "section" => "Benefícios MEDSafer", "name" => "Deletar"),
            array("value" => "medsafeBeneficio_visualizar", "section" => "Benefícios MEDSafer", "name" => "Visualizar"),
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
