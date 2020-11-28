

@section('css')
    <link href="{{asset('plugins/dropzone/dropzone.css')}}" rel="stylesheet" />
@endsection

<div class="row">
    <!-- Titulo Field -->
<!-- Classificacao Field -->
<div class="col-md-12"> 
                <div class="form-group">
                    {!! Form::label('titulo', 'Titulo:') !!}
                    <div class="form-line {{$errors->has('titulo') ? 'focused error' : '' }}">
                        @if(!empty($material->titulo))
                            {!! Form::text('titulo', $material->titulo, ['class' => 'form-control titulo']) !!}
                        @else
                            {!! Form::text('titulo', old('titulo'), ['class' => 'form-control titulo']) !!}
                        @endif
                    </div>
                    <label class="error">{{$errors->first('titulo')}}</label>
                </div>
            </div>
<!-- ./Titulo Field -->

<!-- Arquivo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('arquivo', 'Arquivo*:') !!}
    <input name="arquivo[]" type="file" id="arquivo" multiple="multiple" class="dropzone">
    <label class="error">{{$errors->first('arquivo')}}</label>
</div>
<!-- ./Arquivo Field -->
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('materials.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>


@section('scripts')
    <script src="{{asset('plugins/dropzone/dropzone.js')}}"></script>
    
    <script>

        $(".delete-item").on("click", function() {
            id = $(this).attr('data-iditem');
            window.location = id+'/delete';
        });
        Dropzone.autoDiscover = false;
        $(function () {
            $("#frmFileUpload").dropzone({
                paramName: "file",
                maxFilesize: 20,
                maxFiles: 20,
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