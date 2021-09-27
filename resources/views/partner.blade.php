@extends('layouts.app')

@section('meta_title')
{{ metaTitle('Care Provider Registration') }}
@stop

@section('content')
<div class="main-container" id="partner-register">
	<section id="partner-home-banner">
		<div class="page-title partner-page-title">
            <h1>{{ trans('messages.partner_banner_heading') }}</h1>
            <p>{{ trans('messages.partner_banner_subtitle') }}</p>
        </div>
    </section>
    <section id="partner-register">
    	@include('partials.provider-register')
    </section>
    @include('partials.near-me-home-service')
</div>
@endsection