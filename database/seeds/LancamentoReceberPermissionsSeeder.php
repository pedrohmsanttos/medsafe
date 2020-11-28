<?php

use Illuminate\Database\Seeder;

class LancamentoReceberPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissoes = array(
            // Lançamentos a Receber
            array("value" => "lancamento_receber_listar", "section" => "Lançamentos a Receber", "name" => "Listar"),
            array("value" => "lancamento_receber_adicionar", "section" => "Lançamentos a Receber", "name" => "Adicionar"),
            array("value" => "lancamento_receber_editar", "section" => "Lançamentos a Receber", "name" => "Editar"),
            array("value" => "lancamento_receber_deletar", "section" => "Lançamentos a Receber", "name" => "Deletar"),
            array("value" => "lancamento_receber_visualizar", "section" => "Lançamentos a Receber", "name" => "Visualizar"),
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
