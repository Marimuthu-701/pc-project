@extends('layouts.app')

@section('meta_title')
{{ metaTitle('Search Providers') }}
@stop

@section('content')
<div class="main-container" id="search-container">
    <section id="search-banner" style="display: none;">
        <div class="page-title">
            <h1>Find Elderly Care & Senior Care Providers Near Me</h1>
        </div>
    </section>
    <section id="search-section">
       @include('partials.search-left-right-panel')
    </section>
</div>
@endsection