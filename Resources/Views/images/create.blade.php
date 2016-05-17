@extends($theme_back)


{{-- Web site Title --}}
@section('title')
{{ Lang::choice('kotoba::cms.image', 2) }} :: @parent
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('inline-scripts')
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
	{{ trans('kotoba::general.command.create') }}
	<hr>
</h1>
</div>


<div class="row">
<div class="alert alert-danger alert-dismissible fade in" role="alert">
	<p>
		{{ trans('kotoba::files.default_file_zize') }}:&nbsp;{{ $default_file_size }}


	</p>
</div>
</div>


<div class="row">
{!! Form::open([
	'url' => 'admin/images',
	'method' => 'POST',
	'class' => 'form',
	'files' => true
]) !!}


	<div class="form-group">
		<label for="title">{{ Lang::choice('kotoba::cms.image', 1) }}</label>
		{!! Form::file('image') !!}
		{{-- Form::file('images[]', ['multiple']) --}}
	</div>


<hr>


<div class="row">
<div class="col-sm-12">
	<input class="btn btn-success btn-block" type="submit" value="{{ trans('kotoba::button.save') }}">
</div>
</div>

<br>

<div class="row">
<div class="col-sm-6">
	<a href="/admin/images" class="btn btn-default btn-block" title="{{ trans('kotoba::button.cancel') }}">
		<i class="fa fa-times fa-fw"></i>
		{{ trans('kotoba::button.cancel') }}
	</a>
</div>

<div class="col-sm-6">
	<input class="btn btn-default btn-block" type="reset" value="{{ trans('kotoba::button.reset') }}">
</div>
</div>

{!! Form::close() !!}


</div> <!-- ./ row -->


@stop
