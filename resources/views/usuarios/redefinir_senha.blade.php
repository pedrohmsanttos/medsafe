<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Cadastro MedSafe</title>
    <!-- Favicon-->
    <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{asset('plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{asset('plugins/node-waves/waves.css')}}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{asset('plugins/animate-css/animate.css')}}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
</head>

<body class="signup-page">

    <div class="signup-box">
        <div class="logo">
            <a href="javascript:void(0);">MED<b>Safe</b></a>
            <small>LTDA</small>
        </div>
        <div class="card">
            <div class="body">
                @include('flash::message')
                <form action="{{url('redefinirsenha')}}" id="authentication" method="post">
                    {!! csrf_field() !!}
                    <div class="msg">Este é seu primeiro acesso, redefina sua senha!</div>
                    <div class="input-group">
                       
                        @if ($errors->has('senha') || $errors->has('confirmar_senha'))
                        <div style="background-color: #dd4b39; color: white;" class="alert">
                            <strong>Senha com menos de 8 caracteres ou Confirmação de Senha não confere!</strong>
                            
                        </div>
                        @endif
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="senha" placeholder="Senha" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                        <input type="password" class="form-control" name="confirmar_senha" placeholder="Confirmar Senha">
                        </div>
                    </div>
                        
                    </div>
                    

                    <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">Redefinir Senha</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{asset('plugins/bootstrap/js/bootstrap.js')}}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{asset('plugins/node-waves/waves.js')}}"></script>

    <!-- Validation Plugin Js -->
    <script src="{{asset('plugins/jquery-validation/jquery.validate.js')}}"></script>

    <!-- Custom Js -->
    <script src="{{asset('js/admin.js')}}"></script>
    <script src="{{asset('js/pages/examples/sign-up.js')}}"></script>

    <script src="{{asset('js/jquery.mask.js')}}"></script>
    <script src="{{asset('js/jquery.maskMoney.min.js')}}"></script>
    <script src="{{asset('js/mask.js')}}"></script>
</body>

</html>