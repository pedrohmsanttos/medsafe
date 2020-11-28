

<div class="row">
    <!-- Razaosocial Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('razaoSocial', 'Razão Social*:') !!}
            <div class="form-line {{$errors->has('razaoSocial') ? 'focused error' : '' }}">
                @if(!empty($fornecedor->razaoSocial))
                    <input type="text" name="razaoSocial", class="form-control" value="{!! !empty($fornecedor->razaoSocial) ? $fornecedor->razaoSocial : ''  !!}">
                @else
                    <input type="text" name="razaoSocial", class="form-control" value="{!! (old('razaoSocial')) !!}">
                @endif
            </div>
            <label class="error">{{$errors->first('razaoSocial')}}</label>
        </div>
    </div>

    <!-- Nomefantasia Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('nomeFantasia', 'Nome Fantasia*:') !!}
            <div class="form-line {{$errors->has('nomeFantasia') ? 'focused error' : '' }}">
                @if(!empty($fornecedor->nomeFantasia))
                    <input type="text" name="nomeFantasia", class="form-control" value="{!! !empty($fornecedor->nomeFantasia) ? $fornecedor->nomeFantasia : ''  !!}">
                @else
                    <input type="text" name="nomeFantasia", class="form-control" value="{!! (old('nomeFantasia')) !!}">
                @endif           
            </div>
            <label class="error">{{$errors->first('nomeFantasia')}}</label>
        </div>
    </div>
</div>

<div class="row">
    <!-- Classificacao Field -->
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('classificacao', 'Classificação*:') !!}
            <div class="form-line {{$errors->has('classificacao') ? 'focused error' : '' }}">
                @if(!empty($fornecedor->classificacao))
                    {!! Form::text('classificacao', null, ['class' => 'form-control classificacao']) !!}
                @else
                    {!! Form::text('classificacao', old('classificacao'), ['class' => 'form-control classificacao']) !!}
                @endif
            </div>
            <label class="error">{{$errors->first('classificacao')}}</label>
        </div>
    </div>

    <!-- Tipopessoa Field -->
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('tipoPessoa', 'Tipo Pessoa*:') !!}
            <div class="form-line {{$errors->has('tipoPessoa') ? 'focused error' : '' }}">
                @if(!empty($fornecedor->tipoPessoa))
                    <select id="tipoPessoa" name="tipoPessoa" class="form-control show-tick">
                        <option disabled selected value="">Selecione o tipo</option>
                        <option value="pf" {{$fornecedor->tipoPessoa=='pf' ? 'selected' : ''}}>Pessoa Fisica</option>
                        <option value="pj" {{$fornecedor->tipoPessoa=='pj' ? 'selected' : ''}}>Pessoa Juridica</option>
                    </select>
                @else
                    <select id="tipoPessoa" name="tipoPessoa" class="form-control show-tick">
                        <option disabled selected value="">Selecione o tipo</option>
                        <option value="pf" {{ (old('tipoPessoa')=='pf') ? 'selected' : ''}}>Pessoa Fisica</option>
                        <option value="pj" {{ (old('tipoPessoa')=='pj') ? 'selected' : ''}}>Pessoa Juridica</option>
                    </select>
                @endif
            </div>
            <label class="error">{{$errors->first('tipoPessoa')}}</label>
        </div>
    </div>

    <!-- Cnpjcpf Field -->
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('CNPJCPF', 'CNPJ/CPF*:') !!}
            <div class="form-line {{$errors->has('CNPJCPF') ? 'focused error' : '' }}">
                @if(!empty($fornecedor->CNPJCPF))
                    {!! Form::text('CNPJCPF', null, ['class' => 'form-control cpfcnpj']) !!}
                @else
                    {!! Form::text('CNPJCPF', old('CNPJCPF'), ['class' => 'form-control cpfcnpj']) !!}
                @endif
            </div>
            <label class="error">{{$errors->first('CNPJCPF')}}</label>
        </div>
    </div>
</div>

<div class="row">
    <!-- Inscricaoestadual Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('inscricaoEstadual', 'Inscrição Estadual*:') !!}
            <div class="form-line {{$errors->has('inscricaoEstadual') ? 'focused error' : '' }}">
                @if(!empty($fornecedor->inscricaoEstadual))
                    {!! Form::text('inscricaoEstadual', null, ['class' => 'form-control']) !!}
                @else
                    {!! Form::text('inscricaoEstadual', old('inscricaoEstadual'), ['class' => 'form-control']) !!}
                @endif
            </div>
            <label class="error">{{$errors->first('inscricaoEstadual')}}</label>
        </div>
    </div>

    <!-- Inscricaomunicipal Field -->
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('inscricaoMunicipal', 'Inscrição Municipal*:') !!}
            <div class="form-line {{$errors->has('inscricaoMunicipal') ? 'focused error' : '' }}">
                @if(!empty($fornecedor->inscricaoMunicipal))
                    {!! Form::text('inscricaoMunicipal', null, ['class' => 'form-control']) !!}
                @else
                    {!! Form::text('inscricaoMunicipal', old('inscricaoMunicipal'), ['class' => 'form-control']) !!}
                @endif
            </div>
            <label class="error">{{$errors->first('inscricaoMunicipal')}}</label>
        </div>
    </div>
</div>

<div class="row">
    <!-- Nometitular Field -->
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('nomeTitular', 'Nome Titular*:') !!}
            <div class="form-line {{$errors->has('nomeTitular') ? 'focused error' : '' }}">
                @if(!empty($fornecedor->nomeTitular))
                    <input type="text" name="nomeTitular", class="form-control" value="{!! !empty($fornecedor->nomeTitular) ? $fornecedor->nomeTitular : ''  !!}">
                @else
                    <input type="text" name="nomeTitular", class="form-control" value="{!! old('nomeTitular') !!}">
                @endif
            </div>
            <label class="error">{{$errors->first('nomeTitular')}}</label>
        </div>
    </div>

    <!-- Cpf Field -->
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::label('CPF', 'CPF*:') !!}
            <div class="form-line {{$errors->has('CPF') ? 'focused error' : '' }}">
                {!! Form::text('CPF', null, ['class' => 'form-control cpf']) !!}
            </div>
            <label class="error">{{$errors->first('CPF')}}</label>
        </div>
    </div>

    <!-- Telefone Field -->
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::label('telefone', 'Telefone*:') !!}
            <div class="form-line {{$errors->has('telefone') ? 'focused error' : '' }}">
                @if(!empty($fornecedor->telefone))
                    <input type="text" name="telefone", class="form-control telefone fone" value="{!! !empty($fornecedor->telefone) ? $fornecedor->telefone : ''  !!}">
                @else
                    <input type="text" name="telefone", class="form-control telefone fone" value="{!! (old('telefone')) !!}">
                @endif
            </div>
            <label class="error">{{$errors->first('telefone')}}</label>
        </div>
    </div>

    <!-- Email Field -->
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('email', 'E-mail*:') !!}
            <div class="form-line {{$errors->has('email') ? 'focused error' : '' }}">
                @if(!empty($fornecedor->email))
                    <input type="text" name="email", class="form-control email" value="{!! !empty($fornecedor->email) ? $fornecedor->email : ''  !!}">
                @else
                    <input type="text" name="email", class="form-control email" value="{!! (old('email')) !!}">
                @endif
            </div>
            <label class="error">{{$errors->first('email')}}</label>
        </div>
    </div>

    <!-- Função Field -->
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::label('funcao', 'Função*:') !!}
            <div class="form-line {{$errors->has('funcao') ? 'focused error' : '' }}">
                @if(!empty($fornecedor->funcao))
                    {!! Form::text('funcao', null, ['class' => 'form-control']) !!}
                @else
                    {!! Form::text('funcao', old('funcao'), ['class' => 'form-control']) !!}
                @endif    
            </div>
            <label class="error">{{$errors->first('funcao')}}</label>
        </div>
    </div>
</div>

@include('enderecos.fields')

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('fornecedores.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>