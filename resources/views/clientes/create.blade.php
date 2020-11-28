@extends('layouts.app')

@section('content')
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Informe os dados para o cadastro 
                    </h2>
                </div>

                <div class="body">
                    @include('adminlte-templates::common.errors')
                    {!! Form::open(['route' => 'clientes.store']) !!}

                        @include('clientes.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/bootstrap-material-datetimepicker.js')}}"></script>
    <script src="{{asset('js/jquery.mask.js')}}"></script>
    <script src="{{asset('js/jquery.maskMoney.min.js')}}"></script>
    <script src="{{asset('js/mask.js')}}"></script>
    <script src="{{asset('js/cep.js')}}"></script>
    <script>
        $( document ).ready(function() {
            var request = '{{ old('tipoPessoa')}}';
            if(request != ''){
                camposTipo(request);
            }else{
                camposTipo('pj');
            }
        });

        $("input[name='tipoPessoa']").on('change', function(event){
			camposTipo($('input[name="tipoPessoa"]:checked').val());
            console.log('a');
		});

        function camposTipo(tipo){
			if(tipo=="pf"){
	    		$('.pf').show();
	    		$('.pj').hide();    		
	    	} else if(tipo=="pj") {
	    		$('.pf').hide();
	    		$('.pj').show();
	    	}
	    }
    </script>
@endsection
