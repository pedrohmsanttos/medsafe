@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Organizacao
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($organizacao, ['route' => ['organizacaos.update', $organizacao->id], 'method' => 'patch']) !!}

                        @include('organizacaos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection