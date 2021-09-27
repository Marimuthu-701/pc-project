<div class="container login-container login-sticky-container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">{{ trans('auth.login') }}</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="custom_error alert alert-danger hide"></div>
                    <div class="form-group social-login-btns" style="margin-top: 20px;">
                        <a href="{{ url('auth/google') }}" class="btn btn-lg btn-block">
                            <img src="{{ asset('images/google-login-logo.png')}}">
                            <span> {{ trans('auth.login_with_google') }}</span>
                        </a>
                    </div>
                    <div class="form-group social-login-btns" style="margin-bottom: 25px;">
                        <a href="{{ url('auth/facebook') }}" class="btn btn-lg btn-block">
                            <img src="{{ asset('images/fb-login-logo.png')}}">
                            <span>{{ trans('auth.login_with_fb') }}</span>
                        </a>
                    </div>
                    <div class="social-or-seperator">
                        <i>{{ trans('messages.or') }}</i>
                    </div>
                    <form method="POST" action="{{ route('login') }}" id="login_form">
                        @csrf
                        <input type="hidden" name="previous_url" value="{{ isset($previousUrl) ? $previousUrl : null }}">
                        <div class="form-group row">
                            <label for="username" class="col-md-12 col-form-label text-md-right required">{{ trans('auth.email_or_mobile') }}</label>

                            <div class="col-md-12">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" autocomplete="off" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-12 col-form-label text-md-right required">{{ trans('auth.password') }}</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="off">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ trans('auth.remember_me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary login_btn">
                                    {{ trans('auth.login') }} <i class="fas fa-long-arrow-alt-right"></i>
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link reset_url_btn" href="{{ route('password.request') }}">
                                        {{ trans('auth.forgot_password') }}
                                    </a>
                                    <hr>
                                @endif
                                <a class="btn btn-link register_url_btn" href="{{ route('register') }}">
                                    {{ trans('auth.have_not_account') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('script')
<script>
    $(document).ready(function() {
        $("#login_form").validate({
            errorElement: 'span',
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true,
                    minlength: 5
                },
            },
            messages: {
                password: {
                    required: "{{ trans('auth.login_password_required_msg') }}",
                    minlength: "{{ trans('auth.login_password_length_msg') }}"
                },
                username: "{{ trans('auth.login_valid_email_msg') }}",
            }
        });

        $('#login_form').ajaxForm({
            url: base_url + 'login',
            beforeSend: function() {
                $('span.error').remove();
                $('#login_form .error').removeClass('error');
            },
            success: function(response) {
                $('.login-container .custom_error').addClass('hide');
                if (response.success) {
                    window.location.href = response.redirect_url;
                } else {
                    if (response.errors) {
                        $.each(response.errors, function(key, val) {
                            $("input[name="+key+"]").addClass('error');
                            $("input[name="+key+"]").after('<span for="'+key+'" generated="true" class="error">'+val[0]+'</span>');
                        });
                    } else {
                        $('.login-container .custom_error').text(response.message).removeClass('hide');
                    }
                }
            }
        });
    });
</script>
@endpush