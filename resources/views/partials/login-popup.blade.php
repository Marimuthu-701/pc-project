<div class="modal fade login-popup" id="login-popup" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="approval-message" aria-hidden="true">
    <div class="modal-dialog login-popup-dialog" role="document">
      <div class="modal-content login-popup-content">
            <div class="modal-body">
                <button type="button" class="close signup-close-btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="row" id="login-form-container">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header login-title">{{ trans('auth.customer_login') }}</div>
                            <div class="card-body">
                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                <div class="custom_error alert alert-danger hide"></div>
                                <div class="row social-login-row">
                                    <div class="form-group col-md-6">
                                        <div class="social-login-btns">
                                            <a href="{{ url('auth/google') }}" class="btn btn-lg btn-block">
                                                <img src="{{ asset('images/google-login-logo.png')}}">
                                                <span> {{ trans('auth.login_with_google') }}</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="social-login-btns">
                                            <a href="{{ url('auth/facebook') }}" class="btn btn-lg btn-block">
                                                <img src="{{ asset('images/fb-login-logo.png')}}">
                                                <span>{{ trans('auth.login_with_fb') }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="social-or-seperator">
                                    <hr><i>OR</i>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="login-form-content">
                                            <form method="POST" action="{{ route('login') }}" id="login_popup_form">
                                                @csrf
                                                <input type="hidden" name="previous_url" value="{{ isset($previousUrl) ? $previousUrl : null }}">
                                                <div class="form-group row">
                                                    <label for="username" class="col-md-12 col-form-label text-md-right required">{{ trans('auth.email_or_mobile') }}</label>
                                                    <div class="col-md-12">
                                                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" autocomplete="off" autofocus>
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
                                                        <input  type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="off">
                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="checkbox remember-checkbox">
                                                            <label for="popup-remember">
                                                                <input type="checkbox" type="checkbox" name="remember" id="popup-remember" {{ old('remember') ? 'checked' : '' }}>

                                                                <span class="cr"><i class="fa fa-check cr-icon" aria-hidden="true"></i></span>{{ trans('auth.remember_me') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 reser-password-btn">
                                                        <a class="btn btn-link password-reset-btn" href="javascript:void(0);">
                                                            {{ trans('auth.forgot_password') }}
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-0">
                                                    <div class="col-md-12 text-center">
                                                        <button type="submit" class="btn btn-primary login_btn common-btn">
                                                            {{ trans('auth.login') }} <i class="fas fa-long-arrow-alt-right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12 text-center dont-have-account">
                                                        <a class="btn btn-link register-popup" href="javascript:void(0);">
                                                            <span>{{ trans('auth.dont_have') }}</span> {{ trans('auth.register') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row hide" id="signup-form-container">
                    @include('partials.register-popup')
                </div>
                <div class="row hide password-reset-email" id="password-reset-container">
                   @include('partials.password-reset-popup')
                </div>
            </div>
        </div>
    </div>
</div>
@push('script')
<script>
    $(document).ready(function() {
        $('body').on('click', '.register-popup', function() {
            $('#login-form-container').addClass('hide');
            $('#password-reset-container').addClass('hide');
            $('#register_popup_form').trigger('reset');
            $('#signup-form-container').removeClass('hide');
        });
        $('body').on('click', '.login-popup-btn', function(){
            $('#login_popup_form').trigger('reset');
            $('#signup-form-container').addClass('hide');
            $('#password-reset-container').addClass('hide');
            $('#login-form-container').removeClass('hide');
        });
        $('body').on('click', '.password-reset-btn', function() {
            $('#password-reset-form').trigger('reset');
            $('#login-form-container').addClass('hide');
            $('#password-reset-container').removeClass('hide');
        });
        $("#login_popup_form").validate({
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

        $('#login_popup_form').ajaxForm({
            url: base_url + 'login',
            beforeSend: function() {
                $('.login_btn i').removeClass('fa-long-arrow-alt-right');
                $('.login_btn i').addClass('fa-spinner fa-spin');
                $('.login_btn').prop('disabled', true);
                $('span.error').remove();
                $('#login-popup').removeClass('error');
            },
            success: function(response) {
                $('.login_btn i').removeClass('fa-spinner fa-spin');
                $('.login_btn i').addClass('fa-long-arrow-alt-right');
                $('#login-popup .custom_error').addClass('hide');
                $('.login_btn').prop('disabled', false);
                if (response.success) {
                    window.location.href = response.redirect_url;
                } else {
                    if (response.errors) {
                        $.each(response.errors, function(key, val) {
                            $("input[name="+key+"]").addClass('error');
                            $("input[name="+key+"]").after('<span for="'+key+'" generated="true" class="error">'+val[0]+'</span>');
                        });
                    } else {
                        $('#login-popup .custom_error').text(response.message).removeClass('hide');
                    }
                }
            }
        });
        $(document).keydown(function(event) {
            if (event.keyCode == 27) {
                $('.login-popup').modal('hide');
            }
        });
    });
</script>
@endpush