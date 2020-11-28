<div class="row">
    <!-- Name Field -->
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('name', 'Nome Abreviado*:') !!}
            <div class="form-line {{$errors->has('name') ? 'focused error' : '' }}">
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('name')}}</label>
        </div>
    </div>
    <!-- ./Name Field -->

    <!-- Display Name Field -->
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('display_name', 'Nome*:') !!}
            <div class="form-line {{$errors->has('display_name') ? 'focused error' : '' }}">
                {!! Form::text('display_name', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('display_name')}}</label>
        </div>
    </div>
    <!-- ./Display Name Field -->

    <!-- Description Field -->
    <div class="col-md-5">
        <div class="form-group">
            {!! Form::label('description', 'Descrição*:') !!}
            <div class="form-line {{$errors->has('description') ? 'focused error' : '' }}">
                {!! Form::text('description', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('description')}}</label>
        </div>
    </div>
    <!-- ./Description Field -->

    <input type="hidden" name="permissoes">
</div>

<div class="row">
    <div class="col-md-12">
        <select id="tree" multiple="multiple" style="display: none">
            @foreach($permissions as $perm)
                <option value="{{$perm->id}}" data-section="{{$perm->description}}" {{ in_array_field($perm->id,'id', $permissoes->perms()->get()) ? "selected" : ""}}>{{$perm->display_name}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('permissoes.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
