<div class="col-md-3">
    <!-- Corretor Id Field -->
    <div class="form-group">
        {!! Form::label('corretor_id', 'Corretor:') !!}
        <p>{!! $apolice->corretor->nome !!}</p>
    </div>
</div>

<div class="col-md-3">
    <!-- Pedido Id Field -->
    <div class="form-group">
        {!! Form::label('pedido_id', 'Pedido Nº:') !!}
        <p>{!! $apolice->pedido_id !!}</p>
    </div>
</div>

<div class="col-md-3">
    <!-- Numero Field -->
    <div class="form-group">
        {!! Form::label('numero', 'Número:') !!}
        <p>{!! $apolice->numero !!}</p>
    </div>
</div>

<div class="col-md-3">
    <!-- Endosso Field -->
    <div class="form-group">
        {!! Form::label('endosso', 'Endosso:') !!}
        <p>{!! $apolice->endosso !!}</p>
    </div>
</div>

<div class="col-md-3">
    <!-- Ci Field -->
    <div class="form-group">
        {!! Form::label('ci', 'CI:') !!}
        <p>{!! $apolice->ci !!}</p>
    </div>
</div>

<div class="col-md-3">
    <!-- Classe Bonus Field -->
    <div class="form-group">
        {!! Form::label('classe_bonus', 'Classe Bônus:') !!}
        <p>{!! $apolice->classe_bonus !!}</p>
    </div>
</div>

<div class="col-md-3">
    <!-- Proposta Field -->
    <div class="form-group">
        {!! Form::label('proposta', 'Proposta:') !!}
        <p>{!! $apolice->proposta !!}</p>
    </div>
</div>

<div class="col-md-6">
    <h3>
        Beneficios
    </h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apolice->beneficios()->get() as $key => $item)
                    <tr>
                        <th scope="row">{{ ++$key }}</th>
                        <td>{{ $item->nome }}</td>
                        <td>{{ $item->valor }}</td>
                    </tr>
                @endforeach     
            </tbody>
        </table>
    </div>
</div>

<div class="col-md-6">
        <h3>
            Coberturas
        </h3>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apolice->coberturas()->get() as $key => $item)
                        <tr>
                            <th scope="row">{{ ++$key }}</th>
                            <td>{{ $item->nome }}</td>
                            <td>{{ $item->valor }}</td>
                        </tr>
                    @endforeach    
                </tbody>
            </table>
        </div>
    </div>