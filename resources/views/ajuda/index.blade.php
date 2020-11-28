@extends('layouts.app')

@section('content')
        <div class="card">
            <div class="header">
                <h2>
                    Perguntas frequentes
                </h2>
            </div>
            <div class="body">
                <div class="form-group">
                    <div>{!! (isset($ajuda->value)) ? $ajuda->value : ""; !!}</div>
                </div>
            </div>
        </div>
@endsection