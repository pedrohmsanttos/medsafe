@extends('layouts.app')

@section('content')
    <div class="row clearfix" ng-app="MedSafer">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Informe os dados para editar o cadastro 
                    </h2>
                </div>

                <div class="body" ng-controller="Checkout">
                    <br>
                    @include('adminlte-templates::common.errors')
                    {!! Form::model($checkout, ['route' => ['checkouts.update', $checkout->id], 'method' => 'patch']) !!}

                        @include('checkouts.fields')

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
    <script src="{{asset('plugins/ngCart/ngCart.min.js')}}"></script>
    <script src="{{asset('app/app.js')}}"></script>
    <script src="{{asset('app/controllers.js')}}"></script>
    <script src="{{asset('app/services.js')}}"></script>
    <script>
        $(document).ready(function() {
            var request = '{{ old('paymentMethod')}}';
            if(request != ''){
                camposTipo(request);
            }else{
                camposTipo('po');
            }
        });

        document.getElementById('desconto').onchange = function() {
            document.getElementById('valor_desconto').disabled = !this.checked;
            document.getElementById('valor_desconto').value = 0;
        };

        $("input[name='paymentMethod']").on('change', function(event){
			camposTipo($('input[name="paymentMethod"]:checked').val());
		});

        function camposTipo(tipo){
			if(tipo=="po"){
	    		$('.po').show();
	    		$('.pc').hide();    		
	    	} else {
	    		$('.po').hide();
	    		$('.pc').show();
	    	}
	    }
    </script>
@endsection