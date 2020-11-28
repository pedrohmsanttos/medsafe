@extends('layouts.app')

@section('css')
    <style>
            @media print {
                .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
                  float: left;
                }
                .col-sm-12 {
                  width: 100%;
                }
                .col-sm-11 {
                  width: 91.66666667%;
                }
                .col-sm-10 {
                  width: 83.33333333%;
                }
                .col-sm-9 {
                  width: 75%;
                }
                .col-sm-8 {
                  width: 66.66666667%;
                }
                .col-sm-7 {
                  width: 58.33333333%;
                }
                .col-sm-6 {
                  width: 50%;
                }
                .col-sm-5 {
                  width: 41.66666667%;
                }
                .col-sm-4 {
                  width: 33.33333333%;
                }
                .col-sm-3 {
                  width: 25%;
                }
                .col-sm-2 {
                  width: 16.66666667%;
                }
                .col-sm-1 {
                  width: 8.33333333%;
                }
                .col-sm-pull-12 {
                  right: 100%;
                }
                .col-sm-pull-11 {
                  right: 91.66666667%;
                }
                .col-sm-pull-10 {
                  right: 83.33333333%;
                }
                .col-sm-pull-9 {
                  right: 75%;
                }
                .col-sm-pull-8 {
                  right: 66.66666667%;
                }
                .col-sm-pull-7 {
                  right: 58.33333333%;
                }
                .col-sm-pull-6 {
                  right: 50%;
                }
                .col-sm-pull-5 {
                  right: 41.66666667%;
                }
                .col-sm-pull-4 {
                  right: 33.33333333%;
                }
                .col-sm-pull-3 {
                  right: 25%;
                }
                .col-sm-pull-2 {
                  right: 16.66666667%;
                }
                .col-sm-pull-1 {
                  right: 8.33333333%;
                }
                .col-sm-pull-0 {
                  right: auto;
                }
                .col-sm-push-12 {
                  left: 100%;
                }
                .col-sm-push-11 {
                  left: 91.66666667%;
                }
                .col-sm-push-10 {
                  left: 83.33333333%;
                }
                .col-sm-push-9 {
                  left: 75%;
                }
                .col-sm-push-8 {
                  left: 66.66666667%;
                }
                .col-sm-push-7 {
                  left: 58.33333333%;
                }
                .col-sm-push-6 {
                  left: 50%;
                }
                .col-sm-push-5 {
                  left: 41.66666667%;
                }
                .col-sm-push-4 {
                  left: 33.33333333%;
                }
                .col-sm-push-3 {
                  left: 25%;
                }
                .col-sm-push-2 {
                  left: 16.66666667%;
                }
                .col-sm-push-1 {
                  left: 8.33333333%;
                }
                .col-sm-push-0 {
                  left: auto;
                }
                .col-sm-offset-12 {
                  margin-left: 100%;
                }
                .col-sm-offset-11 {
                  margin-left: 91.66666667%;
                }
                .col-sm-offset-10 {
                  margin-left: 83.33333333%;
                }
                .col-sm-offset-9 {
                  margin-left: 75%;
                }
                .col-sm-offset-8 {
                  margin-left: 66.66666667%;
                }
                .col-sm-offset-7 {
                  margin-left: 58.33333333%;
                }
                .col-sm-offset-6 {
                  margin-left: 50%;
                }
                .col-sm-offset-5 {
                  margin-left: 41.66666667%;
                }
                .col-sm-offset-4 {
                  margin-left: 33.33333333%;
                }
                .col-sm-offset-3 {
                  margin-left: 25%;
                }
                .col-sm-offset-2 {
                  margin-left: 16.66666667%;
                }
                .col-sm-offset-1 {
                  margin-left: 8.33333333%;
                }
                .col-sm-offset-0 {
                  margin-left: 0%;
                }
              }
    </style>
@endsection

@section('content')
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Nº {{ $apolice->id}}
                    </h2>
                </div>
                <div class="body">
                    <div id="apolice" class="row" style="padding-left: 20px">
                        @include('apolices.show_fields')
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{!! route('apolices.index') !!}" class="btn btn-default">Voltar</a>
                                </div>
                                <div class="col-md-6">
                                    <a id="print" style="float:right;" href="#print" class="btn btn-default waves-effect">
                                        <i class="material-icons">print</i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/printThis.js')}}"></script>
    <script>
        $('#print').on("click", function () {
            $("#apolice").printThis({
                importCSS: true,
                importStyle: true,
            });
        });
    </script>
@endsection
