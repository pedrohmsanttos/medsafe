@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap.min.css')}}">
@endsection

@section('content')
    @foreach($emails as $email)
    <div class="card">
        <div class="header bg-blue-grey">
          <h2>{{$email->tipo}}</h2>
        </div><!-- /.box-header -->
        <div class="body">
            <form method="post" action="{{url('/email/'.$email->id)}}">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label>Assunto</label>
                    <div class="form-line">
                        <input type="text" class="form-control" name="assunto" id="assunto" placeholder="Assunto..." value="{{$email->assunto}}">
                    </div>
                </div>
                <div class="form-group">
                    <label>Conteudo</label>
                    <textarea required class="form-control" rows="5" name="conteudo" id="email_{{$email->id}}"> {{$email->conteudo}} </textarea>
                </div>
                <button type="submit" class="btn btn-cetene-blue btn-block btn-flat">Salvar</button>
            </form>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
      @endforeach
@endsection

@section('scripts')
	<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
    <script>
        $var = 'email_';
        @foreach($emails as $email)
            CKEDITOR.replace( $var + {{$email->id}} );
        @endforeach
    </script>
@endsection