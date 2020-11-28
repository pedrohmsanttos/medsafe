
<aside id="leftsidebar" class="sidebar">
        <div class="user-info">
            <div class="image">
                <img src="{{asset('imgs/user.png')}}" width="48" height="48" alt="User">
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{auth()->user()->name}}</div>
                <div class="email">{{auth()->user()->email}}</div>
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="{{url('/meuperfil')}}"><i class="material-icons">person</i>Perfil</a></li>
                        <li><a href="{{url('/sair')}}"><i class="material-icons">input</i>Sair</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="menu">
            <ul class="list">
                <li class="{!! (Request::is('home') || Request::is('/') | Request::is('meuperfil') ) ? 'active' : '' !!}">
                    <a href="{{url('/home')}}">
                        <i class="material-icons">home</i>
                        <span>Página Inicial</span>
                    </a>
                </li>
                @if( !Auth::user()->hasRole('cliente_user') && !Auth::user()->hasRole('corretor_user'))
                <li class="treeview {!! ( Request::is('cadastros') || Request::is('statusPedidos') || Request::is('statusPedidos/create') || Request::is('statusPedidos/*') || Request::is('tipoAtividades') || Request::is('tipoAtividades/create') || Request::is('tipoAtividades/*') || Request::is('motivoPerdaNegocios') || Request::is('motivoPerdaNegocios/create') || Request::is('motivoPerdaNegocios/*') || Request::is('motivoPerdaNegocios') || Request::is('faturamentos') || Request::is('faturamentos/create') || Request::is('faturamentos') || Request::is('faturamentos/*') || Request::is('contasbancarias') || Request::is('contasbancarias/*') || Request::is('planodecontas') || Request::is('planodecontas/*') || Request::is('formaDePagamentos') || Request::is('formaDePagamentos/*') || Request::is('produtos') || Request::is('produtos/*') || Request::is('categoriaProdutos') || Request::is('categoriaProdutos/*') || Request::is('tipoProdutos') || Request::is('tipoProdutos/*') || Request::is('produtoTipoProdutos') || Request::is('produtoTipoProdutos/*') || Request::is('contratos') || Request::is('contratos/*') || Request::is('clientes') || Request::is('clientes/*') || Request::is('fornecedores') || Request::is('fornecedores/*') || Request::is('seguradoras') || Request::is('seguradoras/*') || Request::is('novidades') || Request::is('novidades/*') || Request::is('categoriaTickets') || Request::is('categoriaTickets/*') || Request::is('materials') || Request::is('materials/*')) ? 'active' : '' !!}">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">save</i>
                        <span>Cadastros</span>
                    </a>
                    <ul class="ml-menu">
                        <li class="treeview {!! (Request::is('negocios') || Request::is('statusPedidos') || Request::is('statusPedidos/create') || Request::is('statusPedidos/*') || Request::is('tipoAtividades') || Request::is('tipoAtividades/create') || Request::is('tipoAtividades/*') || Request::is('motivoPerdaNegocios') || Request::is('motivoPerdaNegocios/create') || Request::is('motivoPerdaNegocios/*') || Request::is('motivoPerdaNegocios') || Request::is('faturamentos') || Request::is('faturamentos/create') || Request::is('faturamentos') || Request::is('faturamentos/*')) ? 'active' : '' !!}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">business_center</i>
                                <span>Negócios</span>
                            </a>
                            <ul class="ml-menu">
                                @permission(['status_pedidos_listar','status_pedidos_adicionar','status_pedidos_editar','status_pedidos_deletar','status_pedidos_visualizar'])
                                <li class="treeview {!! ( Request::is('statusPedidos') || Request::is('statusPedidos/create') || Request::is('statusPedidos/*') ) ? 'active' : '' !!}">
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">local_shipping</i>
                                        <span>Status de Pedidos</span>
                                    </a>
                                    <ul class="ml-menu">
                                        @permission('status_pedidos_adicionar')
                                        <li class="{!! (Request::is('statusPedidos/create')) ? 'active' : '' !!}"><a href="{{url('statusPedidos/create')}}">Adicionar</a></li>
                                        @endpermission
                                        @permission('status_pedidos_listar')
                                        <li class="{!! (Request::is('statusPedidos')) ? 'active' : '' !!}"><a href="{{url('statusPedidos')}}">Listar</a></li>
                                        @endpermission
                                    </ul>
                                </li> 
                                @endpermission

                                @permission(['tipo_atividade_listar','tipo_atividade_adicionar','tipo_atividade_editar','tipo_atividade_deletar','tipo_atividade_visualizar'])
                                <li class="treeview {!! (Request::is('tipoAtividades') || Request::is('tipoAtividades/create') || Request::is('tipoAtividades/*')) ? 'active' : '' !!}">
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">assignment_turned_in</i>
                                        <span>Tipos Atividade</span>
                                    </a>
                                    <ul class="ml-menu">
                                        @permission('tipo_atividade_listar')
                                        <li class="{!! (Request::is('tipoAtividades/create')) ? 'active' : '' !!}"><a href="{{url('tipoAtividades/create')}}">Adicionar</a></li>
                                        @endpermission
                                        @permission('tipo_atividade_listar')
                                        <li class="{!! (Request::is('tipoAtividades')) ? 'active' : '' !!}" ><a href="{{url('tipoAtividades')}}">Listar</a></li>
                                        @endpermission
                                    </ul>
                                </li>
                                @endpermission

                                @permission(['perda_negocio_listar','perda_negocio_adicionar','perda_negocio_editar','perda_negocio_deletar','perda_negocio_visualizar'])
                                <li class="treeview {!! (Request::is('motivoPerdaNegocios') || Request::is('motivoPerdaNegocios/create') || Request::is('motivoPerdaNegocios/*') || Request::is('motivoPerdaNegocios')) ? 'active' : '' !!}">
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">money_off</i>
                                        <span>Motivos de Perda de Negócios</span>
                                    </a>
                                    <ul class="ml-menu">
                                        @permission('perda_negocio_adicionar')
                                        <li class="{!! (Request::is('motivoPerdaNegocios/create')) ? 'active' : '' !!}" ><a href="{{url('motivoPerdaNegocios/create')}}">Adicionar</a></li>
                                        @endpermission
                                        @permission('perda_negocio_listar')
                                        <li class="{!! (Request::is('motivoPerdaNegocios')) ? 'active' : '' !!}"><a href="{{url('motivoPerdaNegocios')}}">Listar</a></li>
                                        @endpermission
                                    </ul>
                                </li>  
                                @endpermission

                                @permission(['faixa_faturamentos_listar','faixa_faturamentos_adicionar','faixa_faturamentos_editar','faixa_faturamentos_deletar','faixa_faturamentos_visualizar'])
                                <li class="treeview {!! (Request::is('faturamentos') || Request::is('faturamentos/create') || Request::is('faturamentos') || Request::is('faturamentos/*')) ? 'active' : '' !!}">
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">attach_money</i>
                                        <span>Faixas de Faturamento</span>
                                    </a>
                                    <ul class="ml-menu">
                                        @permission('faixa_faturamentos_adicionar')
                                        <li class="{!! (Request::is('faturamentos/create')) ? 'active' : '' !!}"><a href="{{url('faturamentos/create')}}">Adicionar</a></li>
                                        @endpermission
                                        @permission('faixa_faturamentos_listar')
                                        <li class="{!! (Request::is('faturamentos')) ? 'active' : '' !!}"><a href="{{url('faturamentos')}}">Listar</a></li>
                                        @endpermission
                                    </ul>
                                </li>
                                @endpermission
                            </ul>
                        </li>

                        <li class="treeview {!! (Request::is('contasbancarias') || Request::is('contasbancarias/*') || Request::is('planodecontas') || Request::is('planodecontas/*') || Request::is('formaDePagamentos') || Request::is('formaDePagamentos/*')) ? 'active' : '' !!}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">monetization_on</i>
                                <span>Financeiro</span>
                            </a>
                            <ul class="ml-menu">
                                @permission(['conta_bancaria_listar','conta_bancaria_adicionar','conta_bancaria_editar','conta_bancaria_deletar','conta_bancaria_visualizar'])
                                <li class="treeview {!! (Request::is('contasbancarias') || Request::is('contasbancarias/*')) ? 'active' : '' !!}">
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">account_balance</i>
                                        <span>Contas bancárias</span>
                                    </a>
                                    <ul class="ml-menu">
                                        @permission('conta_bancaria_adicionar')
                                        <li class="{!! (Request::is('contasbancarias/create')) ? 'active' : '' !!}"><a href="{{url('contasbancarias/create')}}">Adicionar</a></li>
                                        @endpermission
                                        @permission('conta_bancaria_listar')
                                        <li class="{!! (Request::is('contasbancarias')) ? 'active' : '' !!}"><a href="{{url('contasbancarias')}}">Listar</a></li>
                                        @endpermission
                                    </ul>
                                </li>
                                @endpermission

                                @permission(['plano_contas_listar','plano_contas_adicionar','plano_contas_editar','plano_contas_deletar','plano_contas_visualizar'])
                                <li class="treeview {!! (Request::is('planodecontas') || Request::is('planodecontas/*')) ? 'active' : '' !!}">
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">class</i>
                                        <span>Plano de Contas</span>
                                    </a>
                                    <ul class="ml-menu">
                                        @permission('plano_contas_adicionar')
                                        <li class="{!! (Request::is('planodecontas/create')) ? 'active' : '' !!}"><a href="{{url('planodecontas/create')}}">Adicionar</a></li>
                                        @endpermission
                                        @permission('plano_contas_listar')
                                        <li class="{!! (Request::is('planodecontas')) ? 'active' : '' !!}"><a href="{{url('planodecontas')}}">Listar</a></li>
                                        @endpermission
                                    </ul>
                                </li>
                                @endpermission

                                @permission(['forma_pagamentos_listar','forma_pagamentos_adicionar','forma_pagamentos_editar','forma_pagamentos_deletar','forma_pagamentos_visualizar'])
                                <li class="treeview {!! (Request::is('formaDePagamentos') || Request::is('formaDePagamentos/*') ) ? 'active' : '' !!}">
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">payment</i>
                                        <span>Formas de Pagamento</span>
                                    </a>
                                    <ul class="ml-menu">
                                        @permission('forma_pagamentos_adicionar')
                                        <li class="{!! (Request::is('formaDePagamentos/create')) ? 'active' : '' !!}"><a href="{{url('formaDePagamentos/create')}}">Adicionar</a></li>
                                        @endpermission
                                        @permission('forma_pagamentos_listar')
                                        <li class="{!! (Request::is('formaDePagamentos')) ? 'active' : '' !!}"><a href="{{url('formaDePagamentos')}}">Listar</a></li>
                                        @endpermission
                                    </ul>
                                </li>
                                @endpermission
                            </ul>
                        </li>

                        <li class="treeview {!! (Request::is('produtos') || Request::is('produtos/*') || Request::is('tipoProdutos') || Request::is('tipoProdutos/*') || Request::is('categoriaProdutos') || Request::is('categoriaProdutos/*') || Request::is('produtoTipoProdutos') || Request::is('produtoTipoProdutos/*') || Request::is('contratos') || Request::is('contratos/*')) ? 'active' : '' !!}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">flag</i>
                                <span>Produtos/Serviços</span>
                            </a>
                            <ul class="ml-menu">
                                @permission(['produtos_listar','produtos_adicionar','produtos_editar','produtos_deletar','produtos_visualizar'])
                                <li class="treeview {!! (Request::is('produtos') || Request::is('produtos/*')) ? 'active' : '' !!}">
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">sim_card</i>
                                        <span>Produtos/Serviços</span>
                                    </a>
                                    <ul class="ml-menu">
                                        @permission('produtos_adicionar')
                                        <li class="{!! (Request::is('produtos/create')) ? 'active' : '' !!}"><a href="{{url('produtos/create')}}">Adicionar</a></li>
                                        @endpermission
                                        @permission('produtos_listar')
                                        <li class="{!! (Request::is('produtos')) ? 'active' : '' !!}"><a href="{{url('produtos')}}">Listar</a></li>
                                        @endpermission
                                    </ul>
                                </li>
                                @endpermission

                                @permission(['categoria_produtos_listar','categoria_produtos_adicionar','categoria_produtos_editar','categoria_produtos_deletar','categoria_produtos_visualizar'])
                                <li class="treeview {!! (Request::is('categoriaProdutos') || Request::is('categoriaProdutos/*')) ? 'active' : '' !!}">
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">bookmark_border</i>
                                        <span>Categoria de Produtos/Serviços</span>
                                    </a>
                                    <ul class="ml-menu">
                                        @permission('categoria_produtos_adicionar')
                                        <li class="{!! (Request::is('categoriaProdutos/create')) ? 'active' : '' !!}"><a href="{{url('categoriaProdutos/create')}}">Adicionar</a></li>
                                        @endpermission
                                        @permission('categoria_produtos_listar')
                                        <li class="{!! (Request::is('categoriaProdutos')) ? 'active' : '' !!}"><a href="{{url('categoriaProdutos')}}">Listar</a></li>
                                        @endpermission
                                    </ul>
                                </li>   
                                @endpermission

                                @permission(['tipo_produtos_listar','tipo_produtos_adicionar','tipo_produtos_editar','tipo_produtos_deletar','tipo_produtos_visualizar'])
                                <li class="treeview {!! (Request::is('tipoProdutos') || Request::is('tipoProdutos/*')) ? 'active' : '' !!}">
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">opacity</i>
                                        <span>Tipo de Produtos/Serviços</span>
                                    </a>
                                    <ul class="ml-menu">
                                        @permission('tipo_produtos_adicionar')
                                        <li class="{!! (Request::is('tipoProdutos/create')) ? 'active' : '' !!}"><a href="{{url('tipoProdutos/create')}}">Adicionar</a></li>
                                        @endpermission
                                        @permission('tipo_produtos_listar')
                                        <li class="{!! (Request::is('tipoProdutos')) ? 'active' : '' !!}"><a href="{{url('tipoProdutos')}}">Listar</a></li>
                                        @endpermission
                                    </ul>
                                </li>    
                                @endpermission

                                @permission(['produto_tipo_produtos_listar','produto_tipo_produtos_adicionar','produto_tipo_produtos_editar','produto_tipo_produtos_deletar','produto_tipo_produtos_visualizar'])
                                <li class="treeview {!! (Request::is('produtoTipoProdutos') || Request::is('produtoTipoProdutos/*')) ? 'active' : '' !!}">
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">monetization_on</i>
                                        <span>Tabela de Preços</span>
                                    </a>
                                    <ul class="ml-menu">
                                        @permission('produto_tipo_produtos_adicionar')
                                        <li class="{!! (Request::is('produtoTipoProdutos/create')) ? 'active' : '' !!}"><a href="{{url('produtoTipoProdutos/create')}}">Adicionar</a></li>
                                        @endpermission
                                        @permission('produto_tipo_produtos_listar')
                                        <li class="{!! (Request::is('produtoTipoProdutos')) ? 'active' : '' !!}"><a href="{{url('produtoTipoProdutos')}}">Listar</a></li>
                                        @endpermission
                                    </ul>
                                </li>
                                @endpermission

                                @permission(['contratos_produtos_listar','contratos_produtos_adicionar','contratos_produtos_editar','contratos_produtos_deletar','contratos_produtos_visualizar'])
                                <li class="treeview {!! (Request::is('contratos') || Request::is('contratos/*')) ? 'active' : '' !!}">
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">insert_drive_file</i>
                                        <span>Contratos</span>
                                    </a>
                                    <ul class="ml-menu">
                                        @permission('contratos_produtos_adicionar')
                                        <li class="{!! (Request::is('contratos/create')) ? 'active' : '' !!}"><a href="{{url('contratos/create')}}">Adicionar</a></li>
                                        @endpermission
                                        @permission('contratos_produtos_listar')
                                        <li class="{!! (Request::is('contratos')) ? 'active' : '' !!}"><a href="{{url('contratos')}}">Listar</a></li>
                                        @endpermission
                                    </ul>
                                </li>
                                @endpermission
                            </ul>
                        </li>
                        
                        @permission(['cliente_listar','cliente_adicionar','cliente_editar','cliente_deletar','cliente_visualizar'])
                        <li class="treeview {!! (Request::is('clientes') || Request::is('clientes/*')) ? 'active' : '' !!}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">people</i>
                                <span>Clientes</span>
                            </a>
                            <ul class="ml-menu">
                                @permission('cliente_adicionar')
                                <li class="{!! (Request::is('clientes/create')) ? 'active' : '' !!}"><a href="{{url('clientes/create')}}">Adicionar</a></li>
                                @endpermission
                                @permission('cliente_listar')
                                <li class="{!! (Request::is('clientes')) ? 'active' : '' !!}"><a href="{{url('clientes')}}">Listar</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission(['fornecedores_listar','fornecedores_adicionar','fornecedores_editar','fornecedores_deletar','fornecedores_visualizar'])
                        <li class="treeview {!! ( Request::is('fornecedores') || Request::is('fornecedores/*') ) ? 'active' : '' !!}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">business</i>
                                <span>Fornecedores</span>
                            </a>
                            <ul class="ml-menu">
                                @permission('fornecedores_adicionar')
                                <li class="{!! (Request::is('fornecedores/create')) ? 'active' : '' !!}"><a href="{{url('fornecedores/create')}}">Adicionar</a></li>
                                @endpermission
                                @permission('fornecedores_listar')
                                <li class="{!! (Request::is('fornecedores')) ? 'active' : '' !!}"><a href="{{url('fornecedores')}}">Listar</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission(['especialidade_listar','especialidade_adicionar','especialidade_editar','especialidade_deletar','especialidade_visualizar'])
                        <li class="treeview {!! (Request::is('especialidades') || Request::is('especialidades/*')) ? 'active' : '' !!}">

                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">my_location</i>
                                <span>Especialidades</span>
                            </a>
                            <ul class="ml-menu">
                                @permission('especialidade_adicionar')
                                <li class="{!! (Request::is('especialidades/create')) ? 'active' : '' !!}"><a href="{{url('especialidades/create')}}">Adicionar</a></li>
                                @endpermission
                                @permission('especialidade_listar')
                                <li class="{!! (Request::is('especialidades')) ? 'active' : '' !!}"><a href="{{url('especialidades')}}">Listar</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission(['seguradoras_listar','seguradoras_adicionar','seguradoras_editar','seguradoras_deletar','seguradoras_visualizar'])
                        <li class="treeview {!! (Request::is('seguradoras') || Request::is('seguradoras/*')) ? 'active' : '' !!}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">business_center</i>
                                <span>Seguradora</span>
                            </a>
                            <ul class="ml-menu">
                                @permission('seguradoras_adicionar')
                                <li class="{!! (Request::is('seguradoras/create')) ? 'active' : '' !!}"><a href="{{url('seguradoras/create')}}">Adicionar</a></li>
                                @endpermission
                                @permission('seguradoras_listar')
                                <li class="{!! (Request::is('seguradoras')) ? 'active' : '' !!}"><a href="{{url('seguradoras')}}">Listar</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission(['novidades_listar','novidades_adicionar','novidades_editar','novidades_deletar','novidades_visualizar'])
                        <li class="treeview {!! (Request::is('novidades') || Request::is('novidades/*') ) ? 'active' : '' !!}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">new_releases</i>
                                <span>Novidades</span>
                            </a>
                            <ul class="ml-menu">
                                @permission('novidades_adicionar')
                                <li class="{!! (Request::is('novidades/create')) ? 'active' : '' !!}"><a href="{{url('novidades/create')}}">Adicionar</a></li>
                                @endpermission
                                @permission('novidades_listar')
                                <li class="{!! (Request::is('novidades')) ? 'active' : '' !!}"><a href="{{url('novidades')}}">Listar</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission(['novidades_listar','novidades_adicionar','novidades_editar','novidades_deletar','novidades_visualizar'])
                        <li class="treeview {!! (Request::is('categoriaTickets') || Request::is('categoriaTickets/*')) ? 'active' : '' !!}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">live_help</i>
                                <span>Categoria de Solicitações</span>
                            </a>
                            <ul class="ml-menu">
                                @permission('novidades_adicionar')
                                <li class="{!! (Request::is('categoriaTickets/*')) ? 'active' : '' !!}"><a href="{{url('categoriaTickets/create')}}">Adicionar</a></li>
                                @endpermission
                                @permission('novidades_listar')
                                <li class="{!! (Request::is('categoriaTickets')) ? 'active' : '' !!}"><a href="{{url('categoriaTickets')}}">Listar</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission(['material_listar','material_adicionar','material_editar','material_deletar','material_visualizar'])
                        <li class="treeview {!! (Request::is('materials') || Request::is('materials/*')) ? 'active' : '' !!}">

                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">card_travel</i>
                                <span>Materiais</span>
                            </a>
                            <ul class="ml-menu">
                                @permission('material_adicionar')
                                <li class="{!! (Request::is('materials/create')) ? 'active' : '' !!}"><a href="{{url('materials/create')}}">Adicionar</a></li>
                                @endpermission
                                @permission('material_listar')
                                <li class="{!! (Request::is('materials')) ? 'active' : '' !!}"><a href="{{url('materials')}}">Listar</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission(['medsafeBeneficio_listar','medsafeBeneficio_adicionar','medsafeBeneficio_editar','medsafeBeneficio_deletar','medsafeBeneficio_visualizar'])
                        <li class="treeview {!! (Request::is('medsafeBeneficios') || Request::is('medsafeBeneficios/*')) ? 'active' : '' !!}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">sentiment_very_satisfied</i>
                                <span>Benefícios MEDSafer</span>
                            </a>
                            <ul class="ml-menu">
                                @permission('medsafeBeneficio_adicionar')
                                <li class="{!! (Request::is('medsafeBeneficios/create')) ? 'active' : '' !!}"><a href="{{url('medsafeBeneficios/create')}}">Adicionar</a></li>
                                @endpermission
                                @permission('medsafeBeneficio_listar')
                                <li class="{!! (Request::is('medsafeBeneficios')) ? 'active' : '' !!}"><a href="{{url('medsafeBeneficios')}}">Listar</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission(['corretoradm_listar','corretoradm_editar','corretoradm_visualizar'])
                        <li class="treeview {!! (Request::is('corretoradms') || Request::is('corretoradms/*')) ? 'active' : '' !!}">

                        <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">nature_people</i>
                                <span>Corretores</span>
                            </a>
                            <ul class="ml-menu">
                                @permission('corretoradm_listar')
                                <li class="{!! (Request::is('corretoradms')) ? 'active' : '' !!}"><a href="{{url('corretoradms')}}">Listar</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission(['pergunta_listar','pergunta_adicionar','pergunta_editar','pergunta_deletar','pergunta_visualizar'])
                        <li class="treeview {!! (Request::is('perguntas') || Request::is('perguntas/*')) ? 'active' : '' !!}">

                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">help</i>
                                <span>Perguntas</span>
                            </a>
                            <ul class="ml-menu">
                                @permission('pergunta_adicionar')
                                <li class="{!! (Request::is('perguntas/create')) ? 'active' : '' !!}"><a href="{{url('perguntas/create')}}">Adicionar</a></li>
                                @endpermission
                                @permission('pergunta_listar')
                                <li class="{!! (Request::is('perguntas')) ? 'active' : '' !!}"><a href="{{url('perguntas')}}">Listar</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission
                        
                    </ul>    
                </li> 
                
                <li class="treeview {!! (Request::is('tickets') || Request::is('pedidos') || Request::is('negocios') || Request::is('negocios/*') || Request::is('transferir/negocios') || Request::is('pedidos/*') || Request::is('tickets/*')  || Request::is('transferir/pedidos')) ? 'active' : '' !!}">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">call_end</i>
                        <span>Atendimento</span>
                    </a>
                    <ul class="ml-menu">
                        @permission(['negocios_listar','negocios_adicionar','negocios_editar','negocios_deletar','negocios_visualizar'])
                        <li class="treeview {!! (Request::is('negocios') || Request::is('negocios/*') || Request::is('transferir/negocios')) ? 'active' : '' !!}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">business_center</i>
                                <span>Negócios</span>
                            </a>
                            <ul class="ml-menu">
                                @permission('negocios_adicionar')
                                <li class="{!! (Request::is('negocios/create')) ? 'active' : '' !!}"><a href="{{url('negocios/create')}}">Adicionar</a></li>
                                @endpermission
                                @permission('negocios_listar')
                                <li class="{!! (Request::is('negocios')) ? 'active' : '' !!}"><a href="{{url('negocios')}}">Listar</a></li>
                                @endpermission
                                <li class="{!! (Request::is('transferir/negocios')) ? 'active' : '' !!}"><a href="{{url('transferir/negocios')}}">Transferir</a></li>
                            </ul>
                        </li>
                        @endpermission

                        @permission(['pedidos_listar','pedidos_adicionar','pedidos_editar','pedidos_deletar','pedidos_visualizar'])
                        <li class="treeview {!! (Request::is('pedidos') || Request::is('checkouts') || Request::is('pedidos/*') || Request::is('checkouts/*') || Request::is('transferir/pedidos')) ? 'active' : '' !!}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">assignment</i>
                                <span>Pedidos</span>
                            </a>
                            <ul class="ml-menu">
                                 @permission('pedidos_adicionar')
                                <li class="{!! (Request::is('pedidos/create')) ? 'active' : '' !!}"><a href="{{url('pedidos/create')}}">Adicionar</a></li>
                                @endpermission
                                @permission('pedidos_listar')
                                <li class="{!! (Request::is('pedidos')) ? 'active' : '' !!}"><a href="{{url('pedidos')}}">Listar</a></li>
                                @endpermission
                                @permission('pedidos_adicionar')
                                <li class="{!! (Request::is('transferir/pedidos')) ? 'active' : '' !!}"><a href="{{url('transferir/pedidos')}}">Transferir</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission(['atendimento_visualizar'])
                        <li class="{!! (Request::is('tickets')) ? 'active' : '' !!}">
                            <a href="{{ url('tickets') }}">
                                <i class="material-icons">help</i>
                                <span>Atendimentos Solicitados</span>
                            </a>
                        </li>
                        @endpermission
                    </ul>
                    
                </li> 

                <li class="treeview {!! (Request::is('tesourarias') || Request::is('tesourarias/*') || Request::is('lancamentosPagar') || Request::is('lancamentosPagar/*') || Request::is('atendimento') || Request::is('lancamentoRecebers') || Request::is('lancamentoRecebers/*') || Request::is('baixareceber') || Request::is('baixareceber/*') || Request::is('baixapagar/*') || Request::is('baixapagar')) ? 'active' : '' !!}">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">monetization_on</i>
                        <span>Financeiro</span>
                    </a>
                    <ul class="ml-menu">
                        <li class="treeview {!! (Request::is('lancamentoRecebers') || Request::is('lancamentoRecebers/*') || Request::is('baixareceber') || Request::is('baixareceber/*')) ? 'active' : '' !!}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">local_grocery_store</i>
                                <span>Lançamento a Receber</span>
                            </a>
                            <ul class="ml-menu">
                                <li class="{!! (Request::is('lancamentoRecebers/create')) ? 'active' : '' !!}"><a href="{{url('lancamentoRecebers/create')}}">Adicionar</a></li>
                                <li class="{!! (Request::is('lancamentoRecebers')) ? 'active' : '' !!}"><a href="{{url('lancamentoRecebers')}}">Listar</a></li>
                                <li class="treeview {!! (Request::is('baixareceber') || Request::is('baixareceber/*')) ? 'active' : '' !!}">
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">attach_money</i>
                                        <span>Baixas</span>
                                    </a>
                                    <ul class="ml-menu">
                                        <li class="{!! (Request::is('baixareceber/create')) ? 'active' : '' !!}"><a href="{{url('baixareceber/create')}}">Adicionar</a></li>
                                        <li class="{!! (Request::is('baixareceber')) ? 'active' : '' !!}"><a href="{{url('baixareceber')}}">Listar</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview {!! (Request::is('lancamentosPagar') || Request::is('lancamentosPagar/*') || Request::is('baixapagar/*') || Request::is('baixapagar')) ? 'active' : '' !!}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">local_atm</i>
                                <span>Lançamento a Pagar</span>
                            </a>
                            <ul class="ml-menu">
                                <li class="{!! (Request::is('lancamentosPagar/create')) ? 'active' : '' !!}"><a href="{{url('lancamentosPagar/create')}}">Adicionar</a></li>
                                <li class="{!! (Request::is('lancamentosPagar')) ? 'active' : '' !!}"><a href="{{url('lancamentosPagar')}}">Listar</a></li>
                                <li class="treeview {!! (Request::is('baixapagar') || Request::is('baixapagar/*')) ? 'active' : '' !!}">
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">money_off</i>
                                        <span>Baixas</span>
                                    </a>
                                    <ul class="ml-menu">
                                        <li class="{!! (Request::is('baixapagar/create')) ? 'active' : '' !!}"><a href="{{url('baixapagar/create')}}">Adicionar</a></li>
                                        <li class="{!! (Request::is('baixapagar')) ? 'active' : '' !!}"><a href="{{url('baixapagar')}}">Listar</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview {!! (Request::is('tesourarias') || Request::is('tesourarias/*')) ? 'active' : '' !!}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">money</i>
                                <span>Tesouraria</span>
                            </a>
                            <ul class="ml-menu">
                                <li class="{!! (Request::is('tesourarias/create')) ? 'active' : '' !!}"><a href="{{url('tesourarias/create')}}">Adicionar</a></li>
                                <li class="{!! (Request::is('tesourarias')) ? 'active' : '' !!}"><a href="{{url('tesourarias')}}">Listar</a></li>
                            </ul>
                        </li>

                        <li class="treeview {!! (Request::is('comissaos') || Request::is('comissaos/*')) ? 'active' : '' !!}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">attach_money</i>
                                <span>Comissões</span>
                            </a>
                            <ul class="ml-menu">
                                <li class="{!! (Request::is('comissaos')) ? 'active' : '' !!}"><a href="{{url('comissaos')}}">Listar</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="treeview {!! (Request::is('relatorio') || Request::is('relatorio/*')) ? 'active' : '' !!}">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">assignment</i>
                        <span>Relatórios</span>
                    </a>
                    <ul class="ml-menu">
                        @permission('relatorio_contas_receber')
                        <li class="{!! (Request::is('relatorio/receber')) ? 'active' : '' !!}"><a href="{{url('relatorio/receber')}}">Lançamentos e Baixas de Contas a Receber</a></li>
                        @endpermission

                        @permission('relatorio_contas_pagar')
                        <li class="{!! (Request::is('relatorio/pagar')) ? 'active' : '' !!}"><a href="{{url('relatorio/pagar')}}">Lançamentos e Baixas de Contas a Pagar</a></li>
                        @endpermission

                        @permission('relatorio_negocio_periodo')
                        <li class="{!! (Request::is('relatorio/negociosPeriodo')) ? 'active' : '' !!}"><a href="{{url('relatorio/negociosPeriodo')}}">Negócios por Período</a></li>
                        @endpermission
                        
                        @permission('relatorio_plano_contas')
                        <li class="{!! (Request::is('relatorio/planocontas')) ? 'active' : '' !!}"><a href="{{url('relatorio/planocontas')}}">Plano de Contas</a></li>
                        @endpermission

                        @permission('relatorio_pedido_periodo')
                        <li class="{!! (Request::is('relatorio/pedidosPeriodo')) ? 'active' : '' !!}"><a href="{{url('relatorio/pedidosPeriodo')}}">Pedidos por Período</a></li>
                        @endpermission

                        @permission('relatorio_pedido_servico')
                        <li class="{!! (Request::is('relatorio/pedidosServico')) ? 'active' : '' !!}"><a href="{{url('relatorio/pedidosServico')}}">Pedidos por Serviço</a></li>
                        @endpermission
                        
                        @permission('relatorio_sumario_vendas')
                        <li class="{!! (Request::is('relatorio/negocioPedidosServico')) ? 'active' : '' !!}"><a href="{{url('relatorio/negocioPedidosServico')}}">Sumário de Vendas</a></li>
                        @endpermission
                        
                        @permission('relatorio_tesouraria')
                        <li class="{!! (Request::is('relatorio/tesouraria')) ? 'active' : '' !!}"><a href="{{url('relatorio/tesouraria')}}">Tesouraria</a></li>
                        @endpermission
                        
                    </ul>
                </li>
                <li class="treeview {!! ( Request::is('email') || Request::is('permissoes') || Request::is('permissoes/*') || Request::is('usuarios') || Request::is('usuarios/*') || Request::is('parametros') ) ? 'active' : '' !!}">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">brightness_high</i>
                        <span>Administração</span>
                    </a>
                    <ul class="ml-menu">
                        @permission(['usuario_listar','usuario_adicionar','usuario_editar','usuario_deletar','usuario_visualizar'])
                        <li class="treeview {!! (Request::is('usuarios') || Request::is('usuarios/*')) ? 'active' : '' !!}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">person</i>
                                <span>Usuários</span>
                            </a>
                            <ul class="ml-menu">
                                @permission('usuario_adicionar')
                                <li class="{!! (Request::is('usuarios/create')) ? 'active' : '' !!}"><a href="{{url('usuarios/create')}}">Adicionar</a></li>
                                @endpermission
                                @permission('usuario_listar')
                                <li class="{!! (Request::is('usuarios')) ? 'active' : '' !!}"><a href="{{url('usuarios')}}">Listar</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission(['parametro_editar','parametro_listar','parametro_visualizar'])
                        <li class="treeview {!! (Request::is('parametros') || Request::is('parametros/*')) ? 'active' : '' !!}">
                            <a href="{{ url('parametros') }}">
                                <i class="material-icons">list</i>
                                <span>Parâmetros</span>
                            </a>
                        </li>
                        @endpermission

                        @permission(['permissoes_adicionar','permissoes_editar','permissoes_deletar'])
                        <li class="treeview {!! (Request::is('permissoes') || Request::is('permissoes/*')) ? 'active' : '' !!}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">supervisor_account</i>
                                <span>Permissões</span>
                            </a>
                            <ul class="ml-menu">
                                @permission('permissoes_adicionar')
                                <li class="{!! (Request::is('permissoes/create')) ? 'active' : '' !!}"><a href="{{url('permissoes/create')}}">Adicionar</a></li>
                                <li class="{!! (Request::is('permissoes')) ? 'active' : '' !!}"><a href="{{url('permissoes')}}">Listar</a></li>
                                @endpermission
                            </ul>
                        </li>
                        @endpermission

                        @permission('config_email')
                        <li class="treeview {!! (Request::is('email')) ? 'active' : '' !!}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">email</i>
                                <span>Mensagens de E-mail</span>
                            </a>
                            <ul class="ml-menu">
                                <li class="{!! (Request::is('email')) ? 'active' : '' !!}"><a href="{{url('email')}}">Configurar</a></li>
                            </ul>
                        </li>
                        @endpermission
                    </ul>
                </li>
                @elseif (Auth::user()->hasRole('corretor_user'))
                <li class="{!!  (Request::is('novidades') || Request::is('novidades/*')) ? 'active' : '' !!}">
                    <a href="{{url('novidades/')}}" class="">
                        <i class="material-icons">new_releases</i>
                        <span>Novidades</span>
                    </a>
                </li>
                <li class="{!! (Request::is('apolices') || Request::is('apolices/*')) ? 'active' : '' !!}">
                    <a href="{{ url('apolices') }}">
                        <i class="material-icons">verified_user</i>
                        <span>Listar Ativação</span>
                    </a>
                </li>

                <li class="treeview {!! (Request::is('segurados') || Request::is('segurados/*')) ? 'active' : '' !!}">
                    <a href="{{ url('segurados') }}">
                        <i class="material-icons">accessibility_new</i>
                        <span>Segurados</span>
                    </a>
                </li>

                <li class="treeview {!! (Request::is('materialCorretors') || Request::is('materialCorretors/*')) ? 'active' : '' !!}">
                    <a href="{{ url('materialCorretors') }}">
                        <i class="material-icons">card_travel</i>
                        <span>Materiais</span>
                    </a>
                </li>

                <li class="treeview {!! (Request::is('renovacaos') || Request::is('renovacaos/*')) ? 'active' : '' !!}">
                    <a href="{{ url('renovacaos') }}">
                        <i class="material-icons">update</i>
                        <span>Renovações</span>
                    </a>
                </li>

                <li class="treeview {!! (Request::is('ocorrencias') || (Request::is('tickets') || Request::is('ocorrencias/create') || Request::is('tickets/*')) || Request::is('ocorrencias/*')) ? 'active' : '' !!}">
                    <a href="{{ url('ocorrencias') }}">
                        <i class="material-icons">announcement</i>
                        <span>Ocorrências</span>
                    </a>
                </li>

                <li class="treeview {!! (Request::is('atendimento')) ? 'active' : '' !!}">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">business</i>
                        <span>Cotações</span>
                    </a>
                    <ul class="ml-menu">
                        <li class="treeview {!! (Request::is('negocios') || Request::is('transferir/negocios') || Request::is('negocios/*')) ? 'active' : '' !!}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">business_center</i>
                                <span>Negócios</span>
                            </a>
                            <ul class="ml-menu">
                                <li class="{!! (Request::is('negocios/create')) ? 'active' : '' !!}"><a href="{{url('negocios/create')}}">Adicionar</a></li>
                                <li class="{!! (Request::is('negocios')) ? 'active' : '' !!}"><a href="{{url('negocios')}}">Listar</a></li>
                                <li class="{!! (Request::is('transferir/negocios')) ? 'active' : '' !!}"><a href="{{url('transferir/negocios')}}">Transferir</a></li>
                            </ul>
                        </li>
                    </ul>

                    <li class="treeview {!! (Request::is('relatorio') || Request::is('relatorio/*')) ? 'active' : '' !!}">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">assignment</i>
                        <span>Relatórios</span>
                    </a>
                    <ul class="ml-menu">
                        <li class="{!! (Request::is('relatorio/ativacoesPeriodo')) ? 'active' : '' !!}"><a href="{{url('relatorio/ativacoesPeriodo')}}">Ativações por Período</a></li>
                    </ul>
                </li>
                </li> 
                @else 
                <li class="treeview {!! (Request::is('apolices') || Request::is('beneficios') || Request::is('tickets')) ? 'active' : '' !!}">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">account_circle</i>
                        <span>Meu Medsafer</span>
                    </a>
                    <ul class="ml-menu">
                        <li class="treeview {!! (Request::is('apolices') || Request::is('apolices/create') || Request::is('apolices/*')) ? 'active' : '' !!}">
                            <a href="{{ url('apolices') }}">
                                <i class="material-icons">verified_user</i>
                                <span>Consultar Apólice</span>
                            </a>
                        </li>
                        <li class="treeview {!! (Request::is('beneficios') || Request::is('beneficios/create') || Request::is('beneficios/*')) ? 'active' : '' !!}">
                            <a href="{{ url('beneficios') }}">
                                <i class="material-icons">business_center</i>
                                <span>Consultar Benefícios</span>
                            </a>
                        </li>
                        <li class="treeview {!! (Request::is('tickets') || Request::is('tickets/create') || Request::is('tickets/*')) ? 'active' : '' !!}">
                            <a href="{{ url('tickets') }}">
                                <i class="material-icons">help</i>
                                <span>Solicitar Atendimento</span>
                            </a>
                        </li>
                    </ul>
                    
                </li> 
                
                <li class="treeview {!! (Request::is('pedidos') || Request::is('pedidos/*')) ? 'active' : '' !!}">
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">assignment</i>
                        <span>Pedidos</span>
                    </a>
                    <ul class="ml-menu">
                        
                        <li class="{!! (Request::is('pedidos/*')) ? 'active' : '' !!}"><a href="{{url('pedidos/create')}}">Adicionar</a></li>
                        
                        <li class="{!! (Request::is('pedidos')) ? 'active' : '' !!}"><a href="{{url('pedidos')}}">Listar</a></li>
                        
                    </ul>
                </li>
                @endif    
            </ul>
        </div>
        <div class="legal">
            <div class="copyright" style="text-align: center;">
                &copy; {{ date('Y') }} <a target="_blank" href="#">MedSafer</a> <br>
                <span style="font-size:11px;"> Desenvolvidor por: <a href="http://www.inhalt.com.br" target="_blank">Inhalt Soluções</a> </span>
            </div>
        </div>
    </aside>
    