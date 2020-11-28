<div class="row">
    <!-- Titulo Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('titulo', 'Titulo*:') !!}
            <div class="form-line {{$errors->has('titulo') ? 'focused error' : '' }}">
                {!! Form::text('titulo', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('titulo')}}</label>
        </div>
    </div>
    <!-- ./Titulo Field -->

    <!-- Category Id Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('category_id', 'Categoria*:') !!}
            <div class="form-line {{$errors->has('category_id') ? 'focused error' : '' }}">
                @if(!empty($tickets->category_id))
                    <select id="category_id" name="category_id" class="form-control show-tick" disabled>
                        <option disabled selected value="">Selecione a categoria</option>
                        @foreach($categorias as $cat)
                            <option value="{{$cat->id}}" {{ ($cat->id == $tickets->category_id) ? 'selected' : ''}}  'disabled' >{{$cat->descricao}}</option>
                        @endforeach
                    </select>
                @else
                    <select id="category_id" name="category_id" class="form-control show-tick">
                        <option disabled selected value="">Selecione a categoria</option>
                        @foreach($categorias as $cat)
                            <option value="{{$cat->id}}" {{ (old('category_id')==$cat->id) ? 'selected' : ''}} >{{$cat->descricao}}</option>
                        @endforeach
                    </select>
                @endif
            </div>
            <label class="error">{{$errors->first('category_id')}}</label>
        </div>
    </div>
    <!-- ./Category Id Field -->

    <!-- Mensagem Field -->
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('mensagem', 'Mensagem*:') !!}
            <div class="form-line {{$errors->has('mensagem') ? 'focused error' : '' }}">
                {!! Form::textarea('mensagem', null, ['class' => 'form-control mensagem']) !!}
            </div>
            <label class="error">{{$errors->first('mensagem')}}</label>
        </div>
    </div>
    <!-- ./Mensagem Field -->

</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('tickets.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
