@extends($theme_back)


{{-- Web image Title --}}
@section('title')
{{ Lang::choice('kotoba::cms.image', 2) }} :: @parent
@stop

@section('styles')
@stop

@section('scripts')
	<script src="{{ asset('assets/js/pdf_viewer.js') }}"></script>
@stop

@section('inline-scripts')
$(function(){
	$('.view-pdf').on('click',function(){
		var pdf_link = $(this).attr('href');
		var text = <?php echo json_encode($js_lang) ?>;
		var iframe = '<div class="iframe-container"><iframe src="'+pdf_link+'"></iframe></div>'
		$.createModal({
		title: text.TITLE,
		close: text.CLOSE,
		message: iframe,
		closeButton:true,
		scrollable:false
		});
		return false;
	});
})
@stop


{{-- Content --}}
@section('content')


<div class="row">
<h1>
	<p class="pull-right">
	<a href="/admin/images" class="btn btn-default" title="{{ trans('kotoba::button.back') }}">
		<i class="fa fa-chevron-left fa-fw"></i>
		{{ trans('kotoba::button.back') }}
	</a>
	</p>
	<i class="fa fa-edit fa-lg"></i>
	{{ trans('kotoba::general.command.edit') }}
	<hr>
</h1>
</div>

<div class="row">
{!! Form::model(
	$image,
	[
		'route' => ['admin.images.update', $image->id],
		'method' => 'PATCH',
		'class' => 'form',
		'files' => 'true'
	]
) !!}


<div class="row">
<div class="col-sm-12">
<table id="" class="table table-striped table-hover">
	<tbody>
		<tr>
			<td>
				{{ Lang::choice('kotoba::table.user', 1) }}
			</td>
			<td>
				{{ $image->user_id }}
			</td>
		</tr>
		<tr>
			<td>
				{{ Lang::choice('kotoba::table.image', 1) }}
			</td>
			<td>
				{{ $image->image_file_name }}
			</td>
		</tr>
		<tr>
			<td>
				{{ trans('kotoba::table.size') }}
			</td>
			<td>
				{{ $image->image_file_size }}
			</td>
		</tr>
		<tr>
			<td>
				{{ Lang::choice('kotoba::table.type', 1) }}
			</td>
			<td>
				{{ $image->image_content_type }}
			</td>
		</tr>
		<tr>
			<td>
				{{ trans('kotoba::table.url') }}
			</td>
			<td>
				{{ $image->image->url() }}
			</td>
		</tr>
		<tr>
			<td>
				{{ trans('kotoba::table.updated') }}
			</td>
			<td>
				{{ $image->image_updated_at }}
			</td>
		</tr>
	</tbody>
</table>
</div>
</div>


{{--
<a href="/admin/images/{{ $image->id }}/edit" class="btn btn-success" title="{{ trans('kotoba::button.edit') }}">
	<i class="fa fa-pencil fa-fw"></i>
	{{ trans('kotoba::button.edit') }}
</a>

<div class="form-group padding-bottom-xl">
	<label for="inputLogo" class="col-sm-1 control-label">{{ trans('kotoba::account.logo') }}:</label>
	<div class="col-sm-11">
		<div class="row margin-bottom-lg">
		<div class="col-sm-8">

			@if($logo != NULL)
				{!! Form::hidden('logo', $image->logo) !!}
				{!! Html::image($logo, '', ['class' => 'img-thumbnail']) !!}
			@else
				<div class="alert alert-danger">
					{{ trans('kotoba::account.error.logo') }}
				</div>
			@endif

		</div>

		<div class="col-sm-4">
			{!! Form::file('newImage') !!}
		</div>

		</div>
	</div>
</div>
--}}


<hr>


<div class="form-group margin-top-xl">
	@if ( $extension == "pdf" )
		<a class="btn btn-primary btn-block view-pdf" href="{{ $image->image->url() }}">{{ trans('kotoba::button.view') }}</a>
	@else
		<a class="btn btn-primary btn-block" href="{{ $image->image->url() }}">{{ trans('kotoba::button.download') }}</a>
	@endif
</div>

<div class="row">
<div class="col-sm-6">
	<a href="/admin/images" class="btn btn-default btn-block" title="{{ trans('kotoba::button.back') }}">
		<i class="fa fa-times fa-fw"></i>
		{{ trans('kotoba::button.back') }}
	</a>
</div>

<div class="col-sm-6">
<!-- Button trigger modal -->
	<a data-toggle="modal" data-target="#myModal" class="btn btn-default btn-block" title="{{ trans('kotoba::button.delete') }}">
		<i class="fa fa-trash-o fa-fw"></i>
		{{ trans('kotoba::general.command.delete') }}
	</a>
</div>
</div>


{!! Form::close() !!}


</div> <!-- ./ row -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	@include($activeTheme . '::' . '_partials.modal')
</div>


@stop
