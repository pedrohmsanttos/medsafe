<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('produto_id', 'Produto/Serviço*:') !!}
            <select data-live-search="true" id="produto_id" name="produto_id" class="form-control show-tick" required>
                <option disabled selected value="">Selecione o Produto</option>
                @if(!empty($produtos))
                    @foreach($produtos as $produto)
                        <option value="{{$produto->id}}" {{ ($produto->id == $produtoTipoProdutos->produto_id) ? 'selected' : '' }}>{{$produto->descricao}}</option>
                    @endforeach
                @endif
            </select>
            <label class="error">{{$errors->first('produto_id')}}</label>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('categoria_produto_id', 'Categoria do Produto*:') !!}
            <select data-live-search="true" id="categoria_produto_id" name="categoria_produto_id" class="form-control show-tick" required>
                <option disabled selected value="">Selecione o Categoria do Produto</option>
                @if(!empty($categorias))
                    @foreach($categorias as $categoria)
                        <option value="{{$categoria->id}}" {{ ($categoria->id == $produtoTipoProdutos->categoria_produto_id) ? 'selected' : '' }}>{{$categoria->descricao}}</option>
                    @endforeach
                @endif
            </select>
            <label class="error">{{$errors->first('categoria_produto_id')}}</label>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('tipo_produto_id', 'Tipo do Produto*:') !!}
            <select data-live-search="true" id="tipo_produto_id" name="tipo_produto_id" class="form-control show-tick" required>
                <option disabled selected value="">Selecione o Tipo do Produto</option>
                @if(!empty($tipos))
                    @foreach($tipos as $tipo)
                        <option value="{{$tipo->id}}" {{ ($tipo->id == $produtoTipoProdutos->tipo_produto_id) ? 'selected' : '' }}>{{$tipo->descricao}}</option>
                    @endforeach
                @endif
            </select>
            <label class="error">{{$errors->first('tipo_produto_id')}}</label>
        </div>
    </div>

    <!-- Descricao Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('valor', 'Valor*:') !!}
            <div class="form-line {{$errors->has('valor') ? 'focused error' : '' }}">
                @if(!empty($produtoTipoProdutos->valor))
                {!! Form::text('valor', number_format((float) old('valor',$produtoTipoProdutos->valor), 2, ',', '.'), ['class' => 'form-control dinheiro', 'required' => 'required']) !!}
                @else
                {!! Form::text('valor', null, ['class' => 'form-control dinheiro', 'required' => 'required']) !!}
                @endif
            </div>
            <label class="error">{{$errors->first('valor')}}</label>
        </div>
    </div>


</div>

<div class="row">
    <!-- Submit Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::submit('Salvar', ['class' => 'btn btn-primary waves-effect']) !!}
            <a href="{!! route('produtoTipoProdutos.index') !!}" class="btn btn-default waves-effect">Cancelar</a>
        </div>
    </div>
</div>
<script>
    function codQtd(num) {
        var er = /[0-9]+$/;
        
        er.lastIndex = 0;
        var campo = num;
        
        if (!er.test(campo.value) || (campo.value.match(/,/) ) ) {
            //console.log("entrou");
            campo.value = "";
        }
        
    }
</script>

