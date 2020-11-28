@extends('layouts.app')

@push('style')
	<link rel="stylesheet" type="text/css" href="{{url('css/jquery.tree-multiselect.css')}}">
    <style>
    .show-tick{
        display: none !important;
    }
    </style>
@endpush

@section('content')
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Informe os dados para editar o cadastro 
                    </h2>
                </div>

                <div class="body">
                    <br>
                    @include('adminlte-templates::common.errors')
                    {!! Form::model($permissoes, ['route' => ['permissoes.update', $permissoes->id], 'method' => 'patch']) !!}

                        @include('permissoes.fields')

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

    <script src="{{url('js/jquery.tree-multiselect.js')}}"></script>
    <script>

       

        var avl = $("#tree").treeMultiselect({
            enableSelectAll: true, 
            sortable: false, 
            hideSidePanel: true, 
            onChange: changetree, 
            searchable: true, 
            startCollapsed: true 
        });
        
        function changetree(objetos){
            console.log(objetos);
            $("input[name='permissoes']").val(JSON.stringify(objetos));
        }
    </script>
@endsection