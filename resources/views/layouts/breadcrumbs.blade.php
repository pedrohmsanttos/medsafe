@if ($breadcrumbs)
	<ol class="breadcrumb align-right">
		@foreach ($breadcrumbs as $key => $breadcrumb)
			@if (!$breadcrumb->last)
                <li>
                	<a href="{{ $breadcrumb->url }}">
                		@if($key==0)
                		<i class="material-icons">home</i>
                		@endif
                		{{$breadcrumb->title}}
                	</a>
                </li>
            @else
                <li class="active">
                @if($key==0)
                    <i class="material-icons">home</i>
                @endif
                    {{$breadcrumb->title}}
                </li>
            @endif
    	@endforeach
  	</ol>
@endif