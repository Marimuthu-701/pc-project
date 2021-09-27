@extends('layouts.app')

@section('meta_title')
{{ metaTitle('Contact Us') }}
@stop

@section('content')
<div class="main-container" id="partner-register">
	<!-- <section id="partner-home-banner">
                <div class="page-title partner-page-title">
                        <h1>Contact US?</h1>
                        <p>Bring beautiful smile to our seniors & let them always be happy.</p>
                    </div>
        </section>  -->
    <section id="partner-register" class="contact-form-page">
    	@include('partials.contact-form')
    </section>
    @include('partials.near-me-home-service')
</div>
@endsection