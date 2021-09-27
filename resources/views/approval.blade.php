@extends('layouts.app')

@section('meta_title')
{{ metaTitle('Providers Approval') }}
@stop

@section('content')
<div class="main-container" id="search-container">
    <section id="search-section">
    	<div class="container approval-contanier" style="margin-top: 50px;min-height: 500px;">
    	@if($status)
	       <div class="alert alert-success awaiting-message" role="alert">
			    <h4 class="alert-heading">Well done!</h4>
			    <p>{{$message}}</p>
			</div>
		@else
			<div class="alert alert-danger awaiting-message" role="alert">
			    <p>{{$message}}</p>
			</div>
		@endif
		</div>
    </section>
</div>
@endsection