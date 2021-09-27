@extends('layouts.app')

@section('meta_title')
{{ metaTitle('Services') }}
@stop

@section('meta_description')
Theparentscare.com offers families and individuals looking for elder care, a safe way to connect with a network of compassionate Care providers offering Home Nursing, Trained Attendants, Physiotherapists, Medical Equipment Rentals, Old Age Paid Homes and other Elder support services.
@stop

@section('content')
<div class="main-container" id="services-list">
    @include('pages.services.services-list')
</div>
@endsection