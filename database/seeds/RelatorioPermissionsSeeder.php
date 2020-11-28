<?php

use Illuminate\Database\Seeder;

class RelatorioPermissionsSeeder extends Seeder
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
            array("value" => "relatorio_contas_receber", "section" => "Relatório", "name" => "Lançamentos e Baixa de Contas a Receber"),
            array("value" => "relatorio_contas_pagar", "section" => "Relatório", "name" => "Lançamentos e Baixa de contas a Pagar"),
            array("value" => "relatorio_negocio_periodo", "section" => "Relatório", "name" => "Negócios por Período"),
            array("value" => "relatorio_plano_contas", "section" => "Relatório", "name" => "Plano de Contas"),
            array("value" => "relatorio_pedido_servico", "section" => "Relatório", "name" => "Pedidos por Período"),
            array("value" => "relatorio_pedido_periodo", "section" => "Relatório", "name" => "Pedidos por Serviço"),
            array("value" => "relatorio_sumario_vendas", "section" => "Relatório", "name" => "Sumário de Vendas"),
            array("value" => "relatorio_tesouraria", "section" => "Relatório", "name" => "Tesouraria"),
            array("value" => "atendimento_visualizar", "section" => "Atendimentos Solicitados", "name" => "Visualizar"),
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
