<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissoes = array(
            array("value" => "permissoes_adicionar", "section" => "Permissões", "name" => "Adicionar"),
            array("value" => "permissoes_deletar", "section" => "Permissões", "name" => "Deletar"),
            array("value" => "permissoes_editar", "section" => "Permissões", "name" => "Editar"),
            /** Clientes */
            array("value" => "cliente_listar", "section" => "Clientes", "name" => "Listar"),
            array("value" => "cliente_adicionar", "section" => "Clientes", "name" => "Adicionar"),
            array("value" => "cliente_editar", "section" => "Clientes", "name" => "Editar"),
            array("value" => "cliente_deletar", "section" => "Clientes", "name" => "Deletar"),
            array("value" => "cliente_visualizar", "section" => "Clientes", "name" => "Visualizar"),
            /** Fornecedores */
            array("value" => "fornecedores_listar", "section" => "Fornecedores", "name" => "Listar"),
            array("value" => "fornecedores_adicionar", "section" => "Fornecedores", "name" => "Adicionar"),
            array("value" => "fornecedores_editar", "section" => "Fornecedores", "name" => "Editar"),
            array("value" => "fornecedores_deletar", "section" => "Fornecedores", "name" => "Deletar"),
            array("value" => "fornecedores_visualizar", "section" => "Fornecedores", "name" => "Visualizar"),
            /** Seguradoras */
            array("value" => "seguradoras_listar", "section" => "Seguradoras", "name" => "Listar"),
            array("value" => "seguradoras_adicionar", "section" => "Seguradoras", "name" => "Adicionar"),
            array("value" => "seguradoras_editar", "section" => "Seguradoras", "name" => "Editar"),
            array("value" => "seguradoras_deletar", "section" => "Seguradoras", "name" => "Deletar"),
            array("value" => "seguradoras_visualizar", "section" => "Seguradoras", "name" => "Visualizar"),
            // contasbancarias
            array("value" => "conta_bancaria_listar", "section" => "Contas Bancárias", "name" => "Listar"),
            array("value" => "conta_bancaria_adicionar", "section" => "Contas Bancárias", "name" => "Adicionar"),
            array("value" => "conta_bancaria_editar", "section" => "Contas Bancárias", "name" => "Editar"),
            array("value" => "conta_bancaria_deletar", "section" => "Contas Bancárias", "name" => "Deletar"),
            array("value" => "conta_bancaria_visualizar", "section" => "Contas Bancárias", "name" => "Visualizar"),
            // Categoria Produtos
            array("value" => "categoria_produtos_listar", "section" => "Categoria de Produtos", "name" => "Listar"),
            array("value" => "categoria_produtos_adicionar", "section" => "Categoria de Produtos", "name" => "Adicionar"),
            array("value" => "categoria_produtos_editar", "section" => "Categoria de Produtos", "name" => "Editar"),
            array("value" => "categoria_produtos_deletar", "section" => "Categoria de Produtos", "name" => "Deletar"),
            array("value" => "categoria_produtos_visualizar", "section" => "Categoria de Produtos", "name" => "Visualizar"),
            // tipoProdutos
            array("value" => "tipo_produtos_listar", "section" => "Tipo de Produto", "name" => "Listar"),
            array("value" => "tipo_produtos_adicionar", "section" => "Tipo de Produto", "name" => "Adicionar"),
            array("value" => "tipo_produtos_editar", "section" => "Tipo de Produto", "name" => "Editar"),
            array("value" => "tipo_produtos_deletar", "section" => "Tipo de Produto", "name" => "Deletar"),
            array("value" => "tipo_produtos_visualizar", "section" => "Tipo de Produto", "name" => "Visualizar"),
            // produtos
            array("value" => "produtos_listar", "section" => "Produto", "name" => "Listar"),
            array("value" => "produtos_adicionar", "section" => "Produto", "name" => "Adicionar"),
            array("value" => "produtos_editar", "section" => "Produto", "name" => "Editar"),
            array("value" => "produtos_deletar", "section" => "Produto", "name" => "Deletar"),
            array("value" => "produtos_visualizar", "section" => "Produto", "name" => "Visualizar"),
            // tabela de preço
            array("value" => "tabela_preco_listar", "section" => "Tabela de Preço", "name" => "Listar"),
            array("value" => "tabela_preco_adicionar", "section" => "Tabela de Preço", "name" => "Adicionar"),
            array("value" => "tabela_preco_editar", "section" => "Tabela de Preço", "name" => "Editar"),
            array("value" => "tabela_preco_deletar", "section" => "Tabela de Preço", "name" => "Deletar"),
            array("value" => "tabela_preco_visualizar", "section" => "Tabela de Preço", "name" => "Visualizar"),
            // plano de contas
            array("value" => "plano_contas_listar", "section" => "Plano de Contas", "name" => "Listar"),
            array("value" => "plano_contas_adicionar", "section" => "Plano de Contas", "name" => "Adicionar"),
            array("value" => "plano_contas_editar", "section" => "Plano de Contas", "name" => "Editar"),
            array("value" => "plano_contas_deletar", "section" => "Plano de Contas", "name" => "Deletar"),
            array("value" => "plano_contas_visualizar", "section" => "Plano de Contas", "name" => "Visualizar"),
            // novidades
            array("value" => "novidades_listar", "section" => "Novidades", "name" => "Listar"),
            array("value" => "novidades_adicionar", "section" => "Novidades", "name" => "Adicionar"),
            array("value" => "novidades_editar", "section" => "Novidades", "name" => "Editar"),
            array("value" => "novidades_deletar", "section" => "Novidades", "name" => "Deletar"),
            array("value" => "novidades_visualizar", "section" => "Novidades", "name" => "Visualizar"),
            // forma de pagamentos
            array("value" => "forma_pagamentos_listar", "section" => "Forma de Pagamento", "name" => "Listar"),
            array("value" => "forma_pagamentos_adicionar", "section" => "Forma de Pagamento", "name" => "Adicionar"),
            array("value" => "forma_pagamentos_editar", "section" => "Forma de Pagamento", "name" => "Editar"),
            array("value" => "forma_pagamentos_deletar", "section" => "Forma de Pagamento", "name" => "Deletar"),
            array("value" => "forma_pagamentos_visualizar", "section" => "Forma de Pagamento", "name" => "Visualizar"),
            // Faturamentos
            array("value" => "faixa_faturamentos_listar", "section" => "Faturamento", "name" => "Listar"),
            array("value" => "faixa_faturamentos_adicionar", "section" => "Faturamento", "name" => "Adicionar"),
            array("value" => "faixa_faturamentos_editar", "section" => "Faturamento", "name" => "Editar"),
            array("value" => "faixa_faturamentos_deletar", "section" => "Faturamento", "name" => "Deletar"),
            array("value" => "faixa_faturamentos_visualizar", "section" => "Faturamento", "name" => "Visualizar"),
            // Perda de negocio
            array("value" => "perda_negocio_listar", "section" => "Motivos Perda de Negócio", "name" => "Listar"),
            array("value" => "perda_negocio_adicionar", "section" => "Motivos Perda de Negócio", "name" => "Adicionar"),
            array("value" => "perda_negocio_editar", "section" => "Motivos Perda de Negócio", "name" => "Editar"),
            array("value" => "perda_negocio_deletar", "section" => "Motivos Perda de Negócio", "name" => "Deletar"),
            array("value" => "perda_negocio_visualizar", "section" => "Motivos Perda de Negócio", "name" => "Visualizar"),
            // Status dos Pedidos
            array("value" => "status_pedidos_listar", "section" => "Status dos Pedidos", "name" => "Listar"),
            array("value" => "status_pedidos_adicionar", "section" => "Status dos Pedidos", "name" => "Adicionar"),
            array("value" => "status_pedidos_editar", "section" => "Status dos Pedidos", "name" => "Editar"),
            array("value" => "status_pedidos_deletar", "section" => "Status dos Pedidos", "name" => "Deletar"),
            array("value" => "status_pedidos_visualizar", "section" => "Status dos Pedidos", "name" => "Visualizar"),
            // Contratos
            array("value" => "contratos_produtos_listar", "section" => "Contratos", "name" => "Listar"),
            array("value" => "contratos_produtos_adicionar", "section" => "Contratos", "name" => "Adicionar"),
            array("value" => "contratos_produtos_editar", "section" => "Contratos", "name" => "Editar"),
            array("value" => "contratos_produtos_deletar", "section" => "Contratos", "name" => "Deletar"),
            array("value" => "contratos_produtos_visualizar", "section" => "Contratos", "name" => "Visualizar"),
            // Negocios
            array("value" => "negocios_listar", "section" => "Negócios", "name" => "Listar"),
            array("value" => "negocios_adicionar", "section" => "Negócios", "name" => "Adicionar"),
            array("value" => "negocios_editar", "section" => "Negócios", "name" => "Editar"),
            array("value" => "negocios_deletar", "section" => "Negócios", "name" => "Deletar"),
            array("value" => "negocios_visualizar", "section" => "Negócios", "name" => "Visualizar"),
            // Usuário
            array("value" => "usuario_listar", "section" => "Usuários", "name" => "Listar"),
            array("value" => "usuario_adicionar", "section" => "Usuários", "name" => "Adicionar"),
            array("value" => "usuario_editar", "section" => "Usuários", "name" => "Editar"),
            array("value" => "usuario_deletar", "section" => "Usuários", "name" => "Deletar"),
            array("value" => "usuario_visualizar", "section" => "Usuários", "name" => "Visualizar"),
        );

        // Role admin
        DB::table('roles')->insert([
            'name' => 'super_user',
            'display_name' => 'Administrador',
            'description' => 'Usuário com todas as permissões',
        ]);

        foreach($permissoes as $key => $perm){

            DB::table('permissions')->insert([
                'name' => $perm['value'],
                'display_name' => $perm['name'],
                'description' => $perm['section'],
            ]);
            
            DB::table('permission_role')->insert([
                'role_id' => '1',
                'permission_id' => $key+1,
            ]);
        }

        DB::table('role_user')->insert([
            'user_id' => '1',
            'role_id' => '1',
        ]);
    }
}
