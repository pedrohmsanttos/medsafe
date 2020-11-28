<div class="row">
    <!-- Produto Id Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('produto_id', 'Produto/Serviço*:') !!}
        <div class="form-line {{$errors->has('produto_id') ? 'focused error' : '' }}">

            <select id="produto_id" name="produto_id" class="form-control show-tick" data-live-search="true" required>
                <option disabled selected value="">Selecione o Produto/Serviço</option>
                @if(!empty($produtos))
                    @foreach($produtos as $produto)
                        <option value="{{$produto->id}}" {{ ($produto->id == $medsafeBeneficio->produto_id) ? 'selected' : '' }}>{{$produto->descricao}}</option>
                    @endforeach
                @endif
            </select>


        </div>
        <label class="error">{{$errors->first('produto_id')}}</label>
    </div>
</div>
<!-- ./Produto Id Field -->

<!-- Nome Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('nome', 'Nome*:') !!}
        <div class="form-line {{$errors->has('nome') ? 'focused error' : '' }}">
            {!! Form::text('nome', null, ['class' => 'form-control' , 'required' => 'required']) !!}
        </div>
        <label class="error">{{$errors->first('nome')}}</label>
    </div>
</div>
<!-- ./Nome Field -->

<!-- Valor Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('valor', 'Valor*:') !!}
        <div class="form-line {{$errors->has('valor') ? 'focused error' : '' }}">
            {!! Form::text('valor', null, ['class' => 'form-control dinheiro', 'required' => 'required']) !!}
        </div>
        <label class="error">{{$errors->first('valor')}}</label>
    </div>
</div>
<!-- ./Valor Field -->
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('medsafeBeneficios.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
