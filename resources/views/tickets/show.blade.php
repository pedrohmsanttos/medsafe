@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('tickets.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
    <script>
        CKEDITOR.replace('comment');
    </script>
    <script>
        $(function () {
            setTimeout(function () { $('.page-loader-wrapper').fadeOut(); }, 50);
        });
    </script>
@endsection