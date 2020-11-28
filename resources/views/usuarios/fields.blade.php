<div class="row">
    @if(isset($usuario))
        <input type="hidden" id="id" name="id" value="{{ $usuario->id }}">
    @endif
    <!-- Login Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('login', 'Login*:') !!}
            <div class="form-line {{$errors->has('login') ? 'focused error' : '' }}">
                {!! Form::text('login', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('login')}}</label>
        </div>
    </div>
    <!-- ./Login Field -->

    <!-- Name Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('name', 'Nome*:') !!}
            <div class="form-line {{$errors->has('name') ? 'focused error' : '' }}">
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('name')}}</label>
        </div>
    </div>
    <!-- ./Name Field -->

    <!-- Email Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('email', 'E-mail*:') !!}
            <div class="form-line {{$errors->has('email') ? 'focused error' : '' }}">
                {!! Form::email('email', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('email')}}</label>
        </div>
    </div>
    <!-- ./Email Field -->

    <!-- Password Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('password', 'Senha*:') !!}
            <div class="form-line {{$errors->has('password') ? 'focused error' : '' }}">
                {!! Form::password('password', ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('password')}}</label>
        </div>
    </div>
    <!-- ./Password Field -->

    <!-- Groups -->
    @role('super_user')
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('roles', 'Grupos*:') !!}
            <div class="form-line {{$errors->has('roles') ? 'focused error' : '' }}">
                <select name="roles[]" class="form-control" title="- Permissões -" multiple>
                @if(isset($usuario))
                    @foreach($roles as $role)
                        <option value="{{$role->id}}" {{ in_array_field($role->id,'id', $usuario->roles()->get()) ? "selected" : ""}}>{{$role->display_name}}</option>
                    @endforeach
                @else
                    @foreach($roles as $role)
                        <option value="{{$role->id}}">{{$role->display_name}}</option>
                    @endforeach
                @endif
                </select>
            </div>
            <label class="error">{{$errors->first('role')}}</label>
        </div>
    </div>
    @endrole
    <!-- ./Groups -->

</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('usuarios.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
