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


{{-- Content --}}
@section('content')

	<div class="container">
		<div class="content">
			<a href="/">
				<img src="/assets/images/origami.jpg" class="img-responsive">
			</a>
			<div class="title">
				<a href="/">
					Records
				</a>
			</div>
			<div class="quote">
				Records is a Rakko module that provides the ability to manage documents, files and images
			</div>
		</div>
	</div>

@stop
