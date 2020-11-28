<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="body bg-blue-grey">
                <div class="row">
                    <!-- User Id Field -->
                    <div class="col-md-4">
                        {!! Form::label('user_id', 'Solicitante:') !!}
                        <p>{!! $ticket->user->name !!}</p>
                    </div>

                    <!-- Titulo Field -->
                    <div class="col-md-4">
                        {!! Form::label('titulo', 'Título:') !!}
                        <p>{!! $ticket->titulo !!}</p>
                    </div>

                    <!-- Category Id Field -->
                    <div class="col-md-4">
                        {!! Form::label('category_id', 'Categoria:') !!}
                        <p>{!! $ticket->category->descricao !!}</p>
                    </div>
                </div>

                <!-- Mensagem Field -->
                <div class="form-group">
                    <h4>Mensagem:</h4>
                    <p>{!! $ticket->mensagem !!}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div role="tabpanel" class="tab-pane fade active in" id="home">
    @foreach ($ticket->comments()->get() as $comment)
        <div class="panel panel-default panel-post">
            <div class="panel-heading" style="{{ ($comment->user_id == Auth::user()->id) ? 'background: #ccc;' : '' }}" >
                <div class="media">
                    <div class="media-body">
                        <h4 class="media-heading">
                            <a href="#">{!! $comment->user->name !!}</a>
                        </h4>
                        {!! dateSqlToBR($comment->created_at) !!}
                    </div>
                </div>
            </div>
            <div class="panel-body" style="{{ ($comment->user_id == Auth::user()->id) ? 'background: #f4f4f4;' : '' }}">
                <div class="post">
                    <div class="post-heading">
                        {!! $comment->comment !!}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

@if($ticket->status < 2)
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="body">
                @include('adminlte-templates::common.errors')
                {!! Form::open(['route' => 'commentTickets.store']) !!}
                    <input type="hidden" id="ticket_id" name="ticket_id" value="{{ $ticket->id }}">
                    @if(!\Entrust::ability('cliente_user', ''))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('status', 'Status:') !!}
                                    <div class="form-line {{$errors->has('status') ? 'focused error' : '' }}">
                                        @if(isset($ticket->status))
                                        <select id="status" name="status">
                                            <option value="">Status</option>
                                            <option {{ (old('status',$ticket->status) == '0') ? 'selected':'' }} value="0">Aguardando Atendimento</option>
                                            <option {{ (old('status',$ticket->status) == '1') ? 'selected':'' }} value="1">Em Atendimento</option>
                                            <option {{ (old('status',$ticket->status) == '2') ? 'selected':'' }} value="2">Fechado</option>
                                        </select>
                                        @else
                                        <select id="status" name="status">
                                            <option value="">Status</option>
                                            <option {{ (old('status') == '0') ? 'selected':'' }} value="0">Aguardando Atendimento</option>
                                            <option {{ (old('status') == '1') ? 'selected':'' }} value="1">Em Atendimento</option>
                                            <option {{ (old('status') == '2') ? 'selected':'' }} value="2">Fechado</option>
                                        </select>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @include('comment_tickets.fields')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endif