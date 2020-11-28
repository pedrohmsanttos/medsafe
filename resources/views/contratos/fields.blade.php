

@section('css')
    <link href="{{asset('plugins/dropzone/dropzone.css')}}" rel="stylesheet" />
@endsection

<div class="row">
    <!-- Titulo Field -->
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
    <!-- Titulo Field -->
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('descricao', 'Descrição*:') !!}
            <div class="form-line {{$errors->has('descricao') ? 'focused error' : '' }}">
                {!! Form::text('descricao', null, ['class' => 'form-control']) !!}
            </div>
            <label class="error">{{$errors->first('descricao')}}</label>
        </div>
    </div>
</div>


@php 

    if(isset($contrato)):

    $url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'];
    $url =  str_replace($_SERVER['APP_URL'], $url, Storage::url($contrato->arquivo));
@endphp


    <a href="{!! $url !!}" class="">{!! $contrato->arquivo !!}</a>
    <br>
@php 
    endif;
@endphp
<!-- Arquivo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('arquivo', 'Arquivo*:') !!}
    <input name="arquivo" type="file" id="arquivo" class="dropzone">
    <label class="error">{{$errors->first('arquivo')}}</label>
</div>




<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('contratos.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>

@section('scripts')
    <script src="{{asset('plugins/dropzone/dropzone.js')}}"></script>
    
    <script>
        Dropzone.autoDiscover = false;
        $(function () {
            $("#frmFileUpload").dropzone({
                paramName: "file",
                maxFilesize: 1,
                maxFiles: 1,
                url: "upload.php",
                addRemoveLinks : true,
                acceptedFiles:"image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document",
                success: function (file, response) {
                    //console.log(response);
                    //console.log(JSON.stringify(file.upload.filename));
                    //alert("1: "+file);
                    $('#Url_Arquivo').val(file.upload.filename);
                }
                //,complete: function(file, dataUrl) {
                    // Display the image in your file.previewElement
                //    console.log(JSON.stringify(file.upload.filename));
                //}
            });
        });
    </script>

@endsection

