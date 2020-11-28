<?php

use Illuminate\Database\Seeder;

class LancamentoPagarPermissionsSeeder extends Seeder
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
            array("value" => "lancamento_pagar_listar", "section" => "Lançamentos a Pagar", "name" => "Listar"),
            array("value" => "lancamento_pagar_adicionar", "section" => "Lançamentos a Pagar", "name" => "Adicionar"),
            array("value" => "lancamento_pagar_editar", "section" => "Lançamentos a Pagar", "name" => "Editar"),
            array("value" => "lancamento_pagar_deletar", "section" => "Lançamentos a Pagar", "name" => "Deletar"),
            array("value" => "lancamento_pagar_visualizar", "section" => "Lançamentos a Pagar", "name" => "Visualizar"),
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
