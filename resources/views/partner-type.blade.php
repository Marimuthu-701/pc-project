@extends('layouts.app')

@section('content')
<div class="main-container" id="partner-register">
	<section id="partner-home-banner">
		<div class="page-title partner-page-title">
            <h1>{{ trans('messages.partner_banner_heading') }}</h1>
            <p>{{ trans('messages.partner_banner_subtitle') }}</p>
        </div>
    </section>
    <section id="partner-register">
        @if(App\Models\Partner::TYPE_SERVICE == $type)
    	   @include('partials.partner-service')
        @else
            @include('partials.partner-home')
        @endif
    </section>
    <section id="homes-services">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <img src="{{ asset('images/home_near_me.png') }}" alt="#">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <img src="{{ asset('images/services_near_me.png') }}" alt="#">
                </div>
            </div>
        </div>
    </section>
</div>
@endsection