<div class="row">
    <!-- Título Field -->
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('titulo', 'Título*:') !!}
            <div class="form-line {{$errors->has('titulo') ? 'focused error' : '' }}">
                {!! Form::text('titulo', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('titulo')}}</label>
        </div>
    </div>
</div>

<div class="row">
    <!-- SubTítulo Field -->
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('subtitle', 'SubTítulo*:') !!}
            <div class="form-line {{$errors->has('subtitle') ? 'focused error' : '' }}">
                {!! Form::text('subtitle', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('subtitle')}}</label>
        </div>
    </div>
</div>


<div class="row">
    <!-- Texto Field -->
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('texto', 'Texto*:') !!}
            <div class="form-line {{$errors->has('titulo') ? 'focused error' : '' }}">
                {!! Form::textarea('texto', null, ['class' => 'form-control no-resize']) !!}
            </div>
            <label class="error">{{$errors->first('titulo')}}</label>
        </div>
    </div>
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::submit('Salvar', ['class' => 'btn btn btn-block btn-lg bg-blue waves-effect']) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <a href="{!! route('novidades.index') !!}" class="btn btn-block btn-default btn-lg">Cancelar</a>
        </div>
    </div>
</div>
