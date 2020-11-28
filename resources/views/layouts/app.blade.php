<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="theme-color" content="#006599">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>MedSafer | {{ isset($title) ? $title : ''}} @yield ('page')</title>
    <link rel="icon" href="{{asset('img/icone.png')}}">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet"
        type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/waves.min.css')}}" rel="stylesheet" />
    <link href="{{asset('css/animate.min.css')}}" rel="stylesheet" />
    <link href="{{asset('css/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('css/bootstrap-datepicker/bootstrap-datepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('css/admin.min.css')}}" rel="stylesheet">
    @stack('style')
    <link href="{{asset('css/style.css')}}" rel="stylesheet" />
    <link href="{{asset('css/all-themes.min.css')}}" rel="stylesheet" />
    @yield('css')
    <style>
        .sidebar .user-info {
            background: url("{{asset('imgs/perfil_bg.png')}}") top center / 100% 100% no-repeat;
        }
    </style>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-110057381-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'UA-110057381-2');
    </script>
</head>

<body class="theme-blue">
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Aguarde um momento...</p>
        </div>
    </div>
    <div class="overlay"></div>
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="{{url('/')}}">MEDSafer</a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                <span><a href="{{url('/sair')}}"><button type="button" class="btn btn-danger button-header"><i
                                class="material-icons">input</i>&nbsp;&nbsp;Sair</button></a></span>
                <ul class="nav navbar-nav navbar-right">
                    @if(Auth::user()->hasRole('cliente_user'))
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">
                            <i class="material-icons">notifications</i>
                            <span class="label-count">{{ count(Auth::user()->cliente()->first()->getCheckouts()) }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">Checkout</li>
                            <li class="body">
                                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 254px;"><ul class="menu" style="overflow: hidden; width: auto; height: 254px;">
                                    @foreach (Auth::user()->cliente()->first()->getCheckouts() as $record)
                                        <li>
                                            <a href="{{ url('checkouts/'.$record->id.'/edit') }}" class=" waves-effect waves-block">
                                                <div class="icon-circle bg-light-green">
                                                    <i class="material-icons">shopping_cart</i>
                                                </div>
                                                <div class="menu-info">
                                                    <h4>Pedidod N° {{ $record->pedido_id }}</h4>
                                                    <p>
                                                        <i class="material-icons">access_time</i> {{ $record->created_at }}
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul><div class="slimScrollBar" style="background: rgba(0, 0, 0, 0.5); width: 4px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 0px; z-index: 99; right: 1px; height: 181.225px;"></div><div class="slimScrollRail" style="width: 4px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 0px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if(Auth::user()->_hasRole('cliente_user') && count(Auth::user()->roles()->get()) > 1 )
                    <li class="dropdown">
                        <a href="javascript:void(0);" style="margin-right: 20px;" class="dropdown-toggle"
                            data-toggle="dropdown" role="button" aria-expanded="true">
                            <i class="material-icons">people</i>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">Trocar Perfil</li>
                            <li class="body">
                                <div class="slimScrollDiv"
                                    style="position: relative; overflow: hidden; width: auto;">
                                    <ul class="menu" style="overflow: hidden; width: auto;">
                                        <li style="background:{{ (auth()->user()->role_current=='cliente_user') ? '#ccc;' : '#fff;' }}">
                                            <form method='post' id='cliente' action="{{url('trocarperfil')}}">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="role" value="cliente_user">
                                                <a onclick='document.getElementById("cliente").submit();'
                                                    class=" waves-effect waves-block">
                                                    <div class="icon-circle {{ (auth()->user()->role_current=='cliente_user') ? 'bg-light-green' : 'bg-light-blue'}}">
                                                        <i class="material-icons">person_add</i>
                                                    </div>
                                                    <div class="menu-info">
                                                        <h4>Cliente</h4>
                                                        <p>
                                                            <i class="material-icons">description</i> Perfil destinado aos clientes
                                                        </p>
                                                    </div>
                                                </a>
                                            </form>
                                        </li>
                                        <li style="background:{{ (auth()->user()->role_current!='cliente_user') ? '#ccc;' : '#fff;' }}">
                                            <form method='post' id='colaborador' action="{{url('trocarperfil')}}">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="role" value="colaborador_user">
                                                <a onclick='document.getElementById("colaborador").submit();'
                                                    class=" waves-effect waves-block">
                                                    <div class="icon-circle {{ (auth()->user()->role_current!='cliente_user') ? 'bg-light-green' : 'bg-light-blue' }}">
                                                        <i class="material-icons">person_add</i>
                                                    </div>
                                                    <div class="menu-info">
                                                        <h4>Colaborador</h4>
                                                        <p>
                                                            <i class="material-icons">description</i> Perfil destinado aos funcionários
                                                        </p>
                                                    </div>
                                                </a>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
                <!-- <span><a href="{{url('/ajuda')}}"><button type="button" class="btn btn-info button-header"><i class="material-icons">help</i>&nbsp;&nbsp;Ajuda</button></a></span> -->
            </div>
        </div>
    </nav>
    <section>
        @include('layouts.sidebar')
    </section>

    <section class="content">
        <div class="container-fluid" style="    float: unset;">
            <div class="block-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h1>{{isset($title) ? $title : 'MedSafer'}}&ensp;<small>{{isset($subtitle) ? $subtitle : ''}}</small>
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        {!! isset($breadcrumb) ? Breadcrumbs::render($breadcrumb->nome, $breadcrumb) : '' !!}
                    </div>
                </div>
            </div>
            @yield('content')
        </div>
    </section>

    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('js/jquery.slimscroll.js')}}"></script>
    <script src="{{asset('js/waves.min.js')}}"></script>
    <script src="{{asset('js/moment.js')}}"></script>
    <script src="{{asset('js/moment-pt.js')}}"></script>
    <script src="{{asset('js/admin.js')}}"></script>
    <script src="{{asset('js/bootstrap-tagsinput.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('js/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min.js')}}"></script>
    <script src="{{asset('plugins/jquery-inputmask/jquery.inputmask.bundle.js')}}"></script>
    <script src="{{asset('plugins/angular/angular.min.js')}}"></script>
    @yield('scripts')
    @yield('footer')
    <script>
        $(function () {
            setTimeout(function () { $('.page-loader-wrapper').fadeOut(); }, 50);
        });
    </script>

</body>

</html>