@extends($theme_back)


{{-- Web site Title --}}
@section('title')
{{ Lang::choice('kotoba::files.document', 2) }} :: @parent
@stop

@section('styles')
	<link href="{{ asset('assets/vendors/DataTables-1.10.7/plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}" rel="stylesheet">
@stop

@section('scripts')
	<script src="{{ asset('assets/vendors/DataTables-1.10.7/media/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('assets/vendors/DataTables-1.10.7/plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') }}"></script>
@stop

@section('inline-scripts')
$(document).ready(function() {
oTable =
	$('#table').DataTable({
	});
});
@stop


{{-- Content --}}
@section('content')


<div class="row">
<h1>
	<p class="pull-right">
	<a href="/admin/documents/create" class="btn btn-primary" title="{{ trans('kotoba::button.new') }}">
		<i class="fa fa-plus fa-fw"></i>
		{{ trans('kotoba::button.new') }}
	</a>
	</p>
	<i class="fa fa-angle-double-right fa-lg"></i>
		{{ Lang::choice('kotoba::files.document', 2) }}
	<hr>
</h1>
</div>


@if (count($documents))


<div class="row">
<table id="table" class="table table-striped table-hover">
	<thead>
		<tr>
			<th>{{ Lang::choice('kotoba::table.user', 1) }}</th>
			<th>{{ Lang::choice('kotoba::table.document', 1) }}</th>
			<th>{{ trans('kotoba::table.size') }}</th>
			<th>{{ Lang::choice('kotoba::table.type', 1) }}</th>
			<th>{{ trans('kotoba::table.updated') }}</th>

			<th>{{ Lang::choice('kotoba::table.action', 2) }}</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($documents as $document)
			<tr>
				<td>{{ $document->user_id }}</td>
				<td>{{ $document->document_file_name }}</td>
				<td>{{ $document->document_file_size }}</td>
				<td>{{ $document->document_content_type }}</td>
				<td>{{ $document->document_updated_at }}</td>
				<td>
					<a href="/admin/documents/{{ $document->id }}/edit" class="btn btn-info" title="{{ trans('kotoba::button.view') }}">
						<i class="fa fa-search fa-fw"></i>
						{{ trans('kotoba::button.view') }}
					</a>
					@if ( Auth::user()->is('super_admin') )
						<a href="/admin/documents/{{ $document->id }}/edit" class="btn btn-danger" title="{{ trans('kotoba::button.delete') }}">
							<i class="fa fa-trash fa-fw"></i>
							{{ trans('kotoba::button.delete') }}
						</a>
					@endif
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
</div>


@else
<div class="alert alert-info">
</div>
	{{ trans('kotoba::general.error.not_found') }}
@endif


</div>


@stop
