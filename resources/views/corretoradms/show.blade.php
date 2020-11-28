@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Corretoradm
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('corretoradms.show_fields')
                    <a href="{!! route('corretoradms.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
