<div class="row">

<!-- Status Aprovacao Field -->
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('status_aprovacao', 'Status da aprovação*:') !!}
        <div class="form-line {{$errors->has('status_aprovacao') ? 'focused error' : '' }}">
            @if(!empty($comissao->status_aprovacao))
                <select id="status_aprovacao" name="status_aprovacao" class="form-control show-tick" required>
                    <option disabled selected value="">Selecione uma opção</option>
                    <option value="aprovado" {{$comissao->status_aprovacao=='aprovado' ? 'selected' : ''}}>Aprovado</option>
                    <option value="reprovado" {{$comissao->status_aprovacao=='reprovado' ? 'selected' : ''}}>Reprovado</option>
                </select>
            @else
                <select id="status_aprovacao" name="status_aprovacao" class="form-control show-tick" required>
                    <option disabled selected value="">Selecione uma opção</option>
                    <option value="aprovado" {{ (old('status_aprovacao')=='aprovado') ? 'selected' : ''}}>Aprovado</option>
                    <option value="reprovado" {{ (old('status_aprovacao')=='reprovado') ? 'selected' : ''}}>Reprovado</option>
                </select>
            @endif
        </div>
    </div>
</div>
<!-- ./Status Aprovacao Field -->
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('comissaos.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
