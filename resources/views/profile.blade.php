@extends('layouts.app')

@section('content')
<div class="main-container" id="partner-register">
    <!-- <section id="partner-home-banner">
        <div class="page-title partner-page-title">
            <h1>ASPIRE TO PARTNER WITH US?</h1>
            <p>Bring beautiful smile to our seniors & let them always be happy.</p>
        </div>
    </section> -->
    <section id="myaccount-section">
        @include('partials.myaccount')
    </section>
    @include('partials.near-me-home-service')
</div>
@endsection