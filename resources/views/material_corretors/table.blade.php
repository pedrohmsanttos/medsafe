<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover dataTable" id="materialCorretors-table">
        <thead>
            <tr>
                <th>Titulo</th>
            </tr>
        </thead>
        <tbody class="gridBody">
        @foreach($materialCorretors as $materialCorretor)
            <tr data-id="{!! $materialCorretor->id !!}">
                <td>{!! $materialCorretor->titulo !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>