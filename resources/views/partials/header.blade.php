<header>
    <nav class="navbar navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">              
                <button type="button" class="navbar-toggle uarr collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('images/parents_care_logo.svg') }}?v=1" alt="#"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right login">
                    <li>
                        @guest
                            <a href="{{ route('provider.register') }}" title="Are you a Care Provider? List your service for Free"><i><img src="{{ asset('images/login_icon.png') }}" alt="#"></i>Are you a Care Provider?</a>
                        @else
                            <a href="{{ route('profile.edit') }}" class="my-account-btn"><i><img src="{{ asset('images/login_icon.png') }}" alt="#"></i>My Account</a>
                        @endguest
                    </li>
                    <li>
                        @guest
                        <a id="my-button" href="javascript:void(0);"><i><img src="{{ asset('images/login_icon.png') }}" alt="#"></i>Sign in / Sign up</a>
                        @else
                        <a href="#" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i><img src="{{ asset('images/login_icon.png') }}" alt="#"></i>Logout</a>
                        <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        @endguest
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right bottom">
                    <li>
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('services') }}">Services</a>
                    </li>
                    <li>
                        <a href="https://blog.theparentscare.com/" target="_blank">Blog</a>
                    </li>
                    <li>
                        <a href="{{ route('faq') }}">FAQs</a>
                    </li>
                    <li>
                        <a href="{{ route('testimonial') }}">Testimonials</a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}">Contact</a>
                    </li>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
</header>

@if (session('logout'))
    @include('partials.logout')
@endif

@push('script')
<script type="text/javascript">
    $(document).ready(function() {
        var current_slug = "{{ Request::segment(1) }}";
        if(current_slug) {
            openLoginRegister(current_slug, false);
        }
    });
</script>
@endpush