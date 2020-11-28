<?php

use Illuminate\Database\Seeder;

class PerguntaPermissionsTableSeeder extends Seeder
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
            array("value" => "pergunta_listar", "section" => "Perguntas", "name" => "Listar"),
            array("value" => "pergunta_adicionar", "section" => "Perguntas", "name" => "Adicionar"),
            array("value" => "pergunta_editar", "section" => "Perguntas", "name" => "Editar"),
            array("value" => "pergunta_deletar", "section" => "Perguntas", "name" => "Deletar"),
            array("value" => "pergunta_visualizar", "section" => "Perguntas", "name" => "Visualizar"),
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
