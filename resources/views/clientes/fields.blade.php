<div class="row">
    <div class="col-md-12" style="margin-bottom:0 !important">
        <div class="form-group" style="margin-bottom:0 !important">
            @if(!empty($cliente->tipoPessoa))
            <label class="radio-inline">
                <input id="radio_pj" type="radio" class="radio-col-blue" name="tipoPessoa" value="pj" {{old('tipoPessoa',$cliente->tipoPessoa)=="pj" ? "checked" : ""}}
                {{$cliente->tipoPessoa=="pj" ? "checked" : ""}}> 
                <label for="radio_pj">Pessoa Jurídica &emsp;</label>
            </label>
            <label class="radio-inline">
                <input id="radio_pf" type="radio" class="radio-col-blue" name="tipoPessoa" value="pf" {{old('tipoPessoa',$cliente->tipoPessoa)=="pf" ? "checked" : ""}}
                {{$cliente->tipoPessoa=="pf" ? "checked" : ""}}> 
                <label for="radio_pf">Pessoa Física</label>
            </label>
            @else
            <label class="radio-inline">
                <input id="radio_pj" type="radio" class="radio-col-blue" name="tipoPessoa" value="pj" {{old('tipoPessoa')=="pj" ? "checked" : ""}}>
                <label for="radio_pj">Pessoa Jurídica &emsp;</label>
            </label>
            <label class="radio-inline">
                <input id="radio_pf" type="radio" class="radio-col-blue" name="tipoPessoa" value="pf" {{old('tipoPessoa')=="pf" ? "checked" : ""}}> 
                <label for="radio_pf">Pessoa Física</label>
            </label>
            @endif
            <label class="error">{{$errors->first('tipoPessoa')}}</label>
        </div>
    </div>
    
    <div class="pj">
        <h2 class="card-inside-title">Dados da empresa</h2>
        <div class="row">
            <!-- Razaosocial Field -->
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('razaoSocial', 'Razão Social*:') !!}
                    <div class="form-line {{$errors->has('razaoSocial') ? 'focused error' : '' }}">
                        @if(!empty($cliente->razaoSocial))
                            <input type="text" name="razaoSocial" id="razaoSocial" class="form-control" value="{!! !empty($cliente->razaoSocial) ? $cliente->razaoSocial : ''  !!}">
                        @else
                            <input type="text" name="razaoSocial" id="razaoSocial" class="form-control" value="{!! (old('razaoSocial')) !!}">
                        @endif
                    </div>
                    <label class="error">{{$errors->first('razaoSocial')}}</label>
                </div>
            </div>

            <!-- Nomefantasia Field -->
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('nomeFantasia_pj', 'Nome Fantasia*:') !!}
                    <div class="form-line {{$errors->has('nomeFantasia_pj') ? 'focused error' : '' }}">
                        @if(!empty($cliente->nomeFantasia))
                            <input type="text" name="nomeFantasia_pj" id="nomeFantasia" class="form-control" value="{!! !empty($cliente->nomeFantasia) ? $cliente->nomeFantasia : ''  !!}">
                        @else
                            <input type="text" name="nomeFantasia_pj" id="nomeFantasia" class="form-control" value="{!! (old('nomeFantasia')) !!}">
                        @endif           
                    </div>
                    <label class="error">{{$errors->first('nomeFantasia_pj')}}</label>
                </div>
            </div>

           
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('dia_vencimento_pj', 'Dia do vencimento:') !!}
                    <div class="form-line {{$errors->has('dia_vencimento_pj') ? 'focused error' : '' }}">
                        @if(!empty($cliente->dia_vencimento))
                        <select id="dia_vencimento" name="dia_vencimento_pj">
                            <option value="">Selecione o dia</option>
                            <option {{ (old('dia_vencimento',$cliente->dia_vencimento) == '5') ? 'selected':'' }} value="5">5</option>
                            <option {{ (old('dia_vencimento',$cliente->dia_vencimento) == '10') ? 'selected':'' }} value="10">10</option>
                            <option {{ (old('dia_vencimento',$cliente->dia_vencimento) == '15') ? 'selected':'' }} value="15">15</option>
                            <option {{ (old('dia_vencimento',$cliente->dia_vencimento) == '20') ? 'selected':'' }} value="20">20</option>
                            <option {{ (old('dia_vencimento',$cliente->dia_vencimento) == '25') ? 'selected':'' }} value="25">25</option>
                        </select>
                        @else
                        <select id="dia_vencimento" name="dia_vencimento_pj">
                            <option value="">Selecione o dia</option>
                            <option {{ (old('dia_vencimento') == '5') ? 'selected':'' }} value="5">5</option>
                            <option {{ (old('dia_vencimento') == '10') ? 'selected':'' }} value="10">10</option>
                            <option {{ (old('dia_vencimento') == '15') ? 'selected':'' }} value="15">15</option>
                            <option {{ (old('dia_vencimento') == '20') ? 'selected':'' }} value="20">20</option>
                            <option {{ (old('dia_vencimento') == '25') ? 'selected':'' }} value="25">25</option>
                        </select>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Classificacao Field -->
            <!-- <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('classificacao', 'Classificação:') !!}
                    <div class="form-line {{$errors->has('classificacao') ? 'focused error' : '' }}">
                        @if(!empty($cliente->classificacao))
                            {!! Form::text('classificacao', $cliente->classificacao, ['class' => 'form-control classificacao']) !!}
                        @else
                            {!! Form::text('classificacao', old('classificacao'), ['class' => 'form-control classificacao']) !!}
                        @endif
                    </div>
                    <label class="error">{{$errors->first('classificacao')}}</label>
                </div>
            </div> -->

            <!-- Cnpjcpf Field -->
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('CNPJCPF_pj', 'CNPJ*:') !!}
                    <div class="form-line {{$errors->has('CNPJCPF_pj') ? 'focused error' : '' }}">
                        @if(!empty($cliente->CNPJCPF))
                            {!! Form::text('CNPJCPF_pj', old('CNPJCPF_pj',$cliente->CNPJCPF), ['class' => 'form-control cnpj']) !!}
                        @else
                            {!! Form::text('CNPJCPF_pj', old('CNPJCPF_pj'), ['class' => 'form-control cnpj']) !!}
                        @endif
                    </div>
                    <label class="error">{{$errors->first('CNPJCPF_pj')}}</label>
                </div>
            </div>

            <!-- Inscricaoestadual Field -->
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('inscricaoEstadual', 'Inscrição Estadual:') !!}
                    <div class="form-line {{$errors->has('inscricaoEstadual') ? 'focused error' : '' }}">
                        @if(!empty($cliente->inscricaoEstadual))
                            {!! Form::text('inscricaoEstadual', $cliente->inscricaoEstadual, ['class' => 'form-control']) !!}
                        @else
                            {!! Form::text('inscricaoEstadual', old('inscricaoEstadual'), ['class' => 'form-control']) !!}
                        @endif
                    </div>
                    <label class="error">{{$errors->first('inscricaoEstadual')}}</label>
                </div>
            </div>

            <!-- Inscricaomunicipal Field -->
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('inscricaoMunicipal', 'Inscrição Municipal:') !!}
                    <div class="form-line {{$errors->has('inscricaoMunicipal') ? 'focused error' : '' }}">
                        @if(!empty($cliente->inscricaoMunicipal))
                            {!! Form::text('inscricaoMunicipal', $cliente->inscricaoMunicipal, ['class' => 'form-control']) !!}
                        @else
                            {!! Form::text('inscricaoMunicipal', old('inscricaoMunicipal'), ['class' => 'form-control']) !!}
                        @endif
                    </div>
                    <label class="error">{{$errors->first('inscricaoMunicipal')}}</label>
                </div>
            </div>
        </div>

        <h2 class="card-inside-title">Dados do Titular</h2>
        <div class="row">
            <!-- Nometitular Field -->
            <div class="col-md-9">
                <div class="form-group">
                    {!! Form::label('nomeTitular', 'Nome do titular*:') !!}
                    <div class="form-line {{$errors->has('nomeTitular') ? 'focused error' : '' }}">
                        @if(!empty($cliente->nomeTitular))
                            <input type="text" name="nomeTitular", class="form-control" value="{!! !empty($cliente->nomeTitular) ? $cliente->nomeTitular : ''  !!}">
                        @else
                            <input type="text" name="nomeTitular", class="form-control" value="{!! old('nomeTitular') !!}">
                        @endif
                    </div>
                    <label class="error">{{$errors->first('nomeTitular')}}</label>
                </div>
            </div>

            <!-- Cpf Field -->
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('CPF', 'CPF*:') !!}
                    <div class="form-line {{$errors->has('CPF') ? 'focused error' : '' }}">
                        @if(!empty($cliente->CPF))
                            <input type="text" name="CPF", class="form-control cpf" value="{!! !empty($cliente->CPF) ? $cliente->CPF : ''  !!}">
                        @else
                            <input type="text" name="CPF", class="form-control cpf" value="{!! (old('CPF')) !!}">
                        @endif
                    </div>
                    <label class="error">{{$errors->first('CPF')}}</label>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Telefone Field -->
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('telefone_pj', 'Telefone*:') !!}
                    <div class="form-line {{$errors->has('telefone_pj') ? 'focused error' : '' }}">
                        @if(!empty($cliente->telefone))
                            <input type="text" name="telefone_pj", class="form-control fone" value="{!! !empty($cliente->telefone) ? $cliente->telefone : ''  !!}">
                        @else
                            <input type="text" name="telefone_pj", class="form-control fone" value="{!! (old('telefone_pj')) !!}">
                        @endif
                    </div>
                    <label class="error">{{$errors->first('telefone_pj')}}</label>
                </div>
            </div>

            <!-- Email Field -->
            <div class="col-md-5">
                <div class="form-group">
                    {!! Form::label('email_pj', 'E-mail*:') !!}
                    <div class="form-line {{$errors->has('email_pj') ? 'focused error' : '' }}">
                        @if(!empty($cliente->email))
                            <input {{ (!empty($cliente->CPF)) ? 'disabled' : ''}} type="text" name="email_pj", class="form-control email" value="{!! !empty($cliente->email) ? $cliente->email : ''  !!}">
                        @else
                            <input {{ (!empty($cliente->CPF)) ? 'disabled' : ''}} type="text" name="email_pj", class="form-control email" value="{!! (old('email')) !!}">
                        @endif
                        @if(!empty($cliente->CPF))
                            <input type="hidden" id="email_pj" name="email_pj" value="{{ $cliente->email }}">
                        @endif
                    </div>
                    <label class="error">{{$errors->first('email_pj')}}</label>
                </div>
            </div>

            <!-- Função Field -->
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('funcao_pj', 'Profissão*:') !!}
                    <div class="form-line {{$errors->has('funcao_pj') ? 'focused error' : '' }}">
                        @if(!empty($cliente->funcao))
                            {!! Form::text('funcao_pj', $cliente->funcao, ['class' => 'form-control']) !!}
                        @else
                            {!! Form::text('funcao_pj', old('funcao_pj'), ['class' => 'form-control']) !!}
                        @endif    
                    </div>
                    <label class="error">{{$errors->first('funcao_pj')}}</label>
                </div>
            </div>
        </div>
    </div>

    <div class="pf">
        <h2 class="card-inside-title">Dados da pessoa</h2>
        <div class="row">
            <!-- Nomefantasia Field -->
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('nomeFantasia', 'Nome*:') !!}
                    <div class="form-line {{$errors->has('nomeFantasia') ? 'focused error' : '' }}">
                        @if(!empty($cliente->nomeFantasia))
                            <input type="text" name="nomeFantasia" id="nomeFantasia" class="form-control" value="{{ $cliente->nomeFantasia  }}">
                            <input type="hidden" id="id" name="id" value="{{ $cliente->id }}">
                        @else
                            <input type="text" name="nomeFantasia" id="nomeFantasia" class="form-control" value="{!! (old('nomeFantasia')) !!}">
                        @endif           
                    </div>
                    <label class="error">{{$errors->first('nomeFantasia')}}</label>
                </div>
            </div>

            <!-- Cliente Id Field -->
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('especialidade_id', 'Especialidade:') !!}
                        <div class="form-line {{$errors->has('especialidade_id') ? 'focused error' : '' }}">

                            <select id="especialidade_id" name="especialidade_id" class="form-control show-tick" data-live-search="true">
                                <option disabled selected value="">Selecione a Especialidade</option>
                                @if(!empty($especialidades))
                                    @foreach($especialidades as $especialidade)
                                        <option value="{{$especialidade->id}}" {{ ( isset($cliente) && $especialidade->id == $cliente->especialidade_id) ? 'selected' : '' }}>{{$especialidade->descricao}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <label class="error">{{$errors->first('cliente_id')}}</label>
                    </div>
                </div>
                <!-- ./Cliente Id Field -->

            <!-- Cnpjcpf Field -->
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('CNPJCPF', 'CPF*:') !!}
                    <div class="form-line {{$errors->has('CNPJCPF') ? 'focused error' : '' }}">
                        @if(!empty($cliente->CNPJCPF))
                            {!! Form::text('CNPJCPF', old('CNPJCPF', $cliente->CNPJCPF), ['class' => 'form-control cpf']) !!}
                        @else
                            {!! Form::text('CNPJCPF', old('CNPJCPF'), ['class' => 'form-control cpf']) !!}
                        @endif
                    </div>
                    <label class="error">{{$errors->first('CNPJCPF')}}</label>
                </div>
            </div>

            
        </div>
        <div class="row">
            <!-- Dia vencimento-->
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('dia_vencimento', 'Dia do vencimento:') !!}
                    <div class="form-line {{$errors->has('dia_vencimento') ? 'focused error' : '' }}">
                        @if(!empty($cliente->dia_vencimento))
                        <select id="dia_vencimento" name="dia_vencimento">
                            <option value="">Selecione o dia</option>
                            <option {{ (old('dia_vencimento',5) == $cliente->dia_vencimento) ? 'selected':'' }} value="5">5</option>
                            <option {{ (old('dia_vencimento',10) == $cliente->dia_vencimento) ? 'selected':'' }} value="10">10</option>
                            <option {{ (old('dia_vencimento',15) == $cliente->dia_vencimento) ? 'selected':'' }} value="15">15</option>
                            <option {{ (old('dia_vencimento',20) == $cliente->dia_vencimento) ? 'selected':'' }} value="20">20</option>
                            <option {{ (old('dia_vencimento',25) == $cliente->dia_vencimento) ? 'selected':'' }} value="25">25</option>
                        </select>
                        @else
                        <select id="dia_vencimento" name="dia_vencimento">
                            <option value="">Selecione o dia</option>
                            <option {{ (old('dia_vencimento') == '5') ? 'selected':'' }} value="5">5</option>
                            <option {{ (old('dia_vencimento') == '10') ? 'selected':'' }} value="10">10</option>
                            <option {{ (old('dia_vencimento') == '15') ? 'selected':'' }} value="15">15</option>
                            <option {{ (old('dia_vencimento') == '20') ? 'selected':'' }} value="20">20</option>
                            <option {{ (old('dia_vencimento') == '25') ? 'selected':'' }} value="25">25</option>
                        </select>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Telefone Field -->
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('telefone', 'Telefone*:') !!}
                    <div class="form-line {{$errors->has('telefone') ? 'focused error' : '' }}">
                        @if(!empty($cliente->telefone))
                            <input type="text" name="telefone", class="form-control fone" value="{!! !empty($cliente->telefone) ? $cliente->telefone : ''  !!}">
                        @else
                            <input type="text" name="telefone", class="form-control fone" value="{!! (old('telefone')) !!}">
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
                        @if(!empty($cliente->email))
                            <input {{ (!empty($cliente->CPF)) ? 'disabled' : ''}} type="text" name="email", class="form-control email" value="{!! !empty($cliente->email) ? $cliente->email : ''  !!}">
                        @else
                            <input {{ (!empty($cliente->CPF)) ? 'disabled' : ''}} type="text" name="email", class="form-control email" value="{!! (old('email')) !!}">
                        @endif
                        @if(!empty($cliente->CPF))
                            <input type="hidden" id="email" name="email" value="{{ $cliente->email }}">
                        @endif
                    </div>
                    <label class="error">{{$errors->first('email')}}</label>
                </div>
            </div>

            <!-- Função Field -->
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('funcao', 'Profissão*:') !!}
                    <div class="form-line {{$errors->has('funcao') ? 'focused error' : '' }}">
                        @if(!empty($cliente->funcao))
                            {!! Form::text('funcao', old('funcao', $cliente->funcao), ['class' => 'form-control']) !!}
                        @else
                            {!! Form::text('funcao', old('funcao'), ['class' => 'form-control']) !!}
                        @endif    
                    </div>
                    <label class="error">{{$errors->first('funcao')}}</label>
                </div>
            </div>
        </div>
    </div>
</div>
<h2 class="card-inside-title" style="margin-top:0 !important">Endereço</h2>
@include('enderecos.fields')

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        @if(Request::segment(1) == 'clientes')
            <a href="{!! route('clientes.index') !!}" class="btn btn-default">Cancelar</a>
        @else
            <a href="{!! route('negocios.index') !!}" class="btn btn-default">Cancelar</a>
        @endif
    </div>
</div>