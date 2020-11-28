@extends('layouts.app')

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
                    @foreach($material->itens()->get() as  $materialItem)
                        @php
                            $url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'];
                            $url =  str_replace($_SERVER['APP_URL'], $url, Storage::url($materialItem->arquivo));
                        @endphp
                        <div class="row">
                            <div class="col-md-4">
                                <a href="{!! $url !!}" class="">{!! $materialItem->arquivo !!}</a>
                            </div>
                            <div class="col-md-6">
                            <i class="material-icons delete-item" style="cursor:pointer;" data-iditem="{!! $materialItem->id !!}">delete</i>
                            </div>
                        </div>
                        <br/>
                        
                    @endforeach
                    <br/><br/>

                    @include('adminlte-templates::common.errors')
                    {!! Form::model($material, ['route' => ['materials.update', $material->id], 'method' => 'patch', 'enctype' => 'multipart/form-data']) !!}

                        @include('materials.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
    </script>
    <script>
        function myFunction(){
            console.log("oii");
        }
    </script>
    <script src="{{asset('js/bootstrap-material-datetimepicker.js')}}"></script>
    <script src="{{asset('js/jquery.mask.js')}}"></script>
    <script src="{{asset('js/jquery.maskMoney.min.js')}}"></script>
    <script src="{{asset('js/mask.js')}}"></script>
    <script src="{{asset('js/cep.js')}}"></script>
@endsection