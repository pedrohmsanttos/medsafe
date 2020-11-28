@extends('layouts.app')

@section('content')
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Detalhes 
                    </h2>
                </div>

                <div class="body">
                    <br>
                    @include('adminlte-templates::common.errors')
                    {!! Form::model($materialCorretor, ['route' => ['materialCorretors.update', $materialCorretor->id], 'method' => 'patch']) !!}

                        @include('material_corretors.fields')

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
@endsection