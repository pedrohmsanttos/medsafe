@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Produto Tipo Produto
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('produto_tipo_produtos.show_fields')
                    <a href="{!! route('produtoTipoProdutos.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
