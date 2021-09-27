<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('meta_title', config('app.meta_title'))</title>
    <meta itemprop="name" content="@yield('meta_name', config('app.meta_name'))">
    <meta name="description" content="@yield('meta_description', config('app.meta_description'))" />
    <meta name="keywords" content="@yield('meta_keyword', config('app.meta_keyword'))">
    <meta itemprop="image" content="{{ asset('images/parents-care-image.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">

    <!-- Open Graph (Facebook) -->
    <meta property="og:title" content="{{ config('app.meta_title') }}">
    <meta property="og:description" content="{{ config('app.meta_description') }}">
    <meta property="og:image" content="{{ asset('images/parents-care-image.png') }}">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:type" content="website">

    @yield('meta')
    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800&display=swap" rel="stylesheet">

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{ asset(mix('css/styles.min.css', '')) }}" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">

    <script type="text/javascript">
        var base_url = "{{ url('/') }}/";
        var isMobile = false;
    </script>

    @yield('style')
    @stack('style')
    @include('partials.analytics')
</head>
<body>
    <div id="app">   
        @include('partials.header')
        <main class="py-4">
            @yield('content')
        </main>
        @include('partials.footer')
    </div>
    
    <script src="{{ asset(mix('js/scripts.min.js', '')) }}" ></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    @yield('script')
    @stack('script')
</body>
</html>
