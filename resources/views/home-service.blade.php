@extends('layouts.app')

@section('meta_title')
{{ metaTitle($serviceInfo->name . ' - ' . $serviceName->name) }}
@stop

@section('content')
<div class="main-container" id="home-service-detail">
    <section id="wish-list-info">
        @include('partials.home-service-detail')
    </section>
    <!-- <section id="homes-services">
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
    </section> -->
</div>
@endsection