@extends('module_info')

{{-- Web site Title --}}
@section('title')
{{ Config::get('core.title') }} :: @parent
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('inline-scripts')
@stop

{{-- News --}}
@section('content')

	<div class="container">
		<div class="content">
			<a href="/">
				<img src="/assets/images/himwari_2.png" class="img-responsive">
			</a>
			<div class="title">
				<a href="/">
					Records
				</a>
			</div>
			<div class="quote">
				Records is a document, file and image management system module for Rakko
			</div>
		</div>
	</div>

@stop
