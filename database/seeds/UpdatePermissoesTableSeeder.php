<?php

use Illuminate\Database\Seeder;

class UpdatePermissoesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissoes = array(
            /** Clientes */
            array("value" => "produto_tipo_produtos_listar", "section" => "Tabela de Preço", "name" => "Listar"),
            array("value" => "produto_tipo_produtos_adicionar", "section" => "Tabela de Preço", "name" => "Adicionar"),
            array("value" => "produto_tipo_produtos_editar", "section" => "Tabela de Preço", "name" => "Editar"),
            array("value" => "produto_tipo_produtos_deletar", "section" => "Tabela de Preço", "name" => "Deletar"),
            array("value" => "produto_tipo_produtos_visualizar", "section" => "Tabela de Preço", "name" => "Visualizar"),
            array("value" => "config_email", "section" => "Mensagens de E-mail", "name" => "Editar")
        );

        foreach($permissoes as $key => $perm){

            $id = DB::table('permissions')->insertGetId([
                'name' => $perm['value'],
                'display_name' => $perm['name'],
                'description' => $perm['section'],
            ]);
            
            DB::table('permission_role')->insert([
                'role_id' => '1',
                'permission_id' => $id,
            ]);
        }
    }
}
