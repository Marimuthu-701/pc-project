<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('meta_title', config('app.name'))</title>
    <meta name="description" content="@yield('meta_description', config('app.meta_description'))" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    @yield('meta')
    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800&display=swap" rel="stylesheet">

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{ asset(mix('css/style-min.css', '')) }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css?v=3') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css?v=2') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bpopup.css') }}">
    <!-- This style bootstrap datepicker css version 1.9.0 -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
    <!-- This style using for otp input field -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pincode_input/bootstrap-pincode-input.css') }}">
    <!-- This style using for rating start -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/star-rating.css') }}">
    <!-- This style using for without login do some action confirm popup css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-confirm.min.css') }}">

    <script type="text/javascript" src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset('vendor/bootstrap/js/bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-migrate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bpopup.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/Jquery_validation/jquery.validate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/Jquery_validation/additional-methods.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/Jquery_validation/jquery.form.min.js') }}"></script>
    <!-- This script using to bootstrap date picker version 1.9.0 -->
    <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <!-- This script using for otp input field -->
    <script type="text/javascript" src="{{ asset('js/pincode_input/bootstrap-pincode-input.js') }}"></script>
    <!-- This script using for sign in login popup position fixing in sticky-->
    <script type="text/javascript" src="{{ asset('js/jquery.sticky.js') }}"></script>
    <!-- This script using for rating stars -->
    <script type="text/javascript" src="{{ asset('js/star-rating.js') }}"></script>
    <!-- This style using for without login do some action confirm popup js -->
    <script type="text/javascript" src="{{ asset('js/jquery-confirm.min.js') }}"></script>
    
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
    @yield('script')
    @stack('script')
</body>
</html>
