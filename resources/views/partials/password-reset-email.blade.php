<div class="container password-reset-email password-sticky-container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <!-- Password reset -->
            <div class="card" id="password-reset-email">
                <div class="card-header">{{ trans('auth.reeset_password') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="alert alert-success custom_success hide"></div>
                    <div class="alert alert-danger custom_error hide"></div>
                    <form method="POST" action="{{ route('password.email') }}" id="reset_email_form">
                        @csrf
                        <div class="form-group row">
                            <label for="reset_mobile_number" class="col-lg-12 col-form-label text-md-right required">
                                <!-- {{ trans('auth.email_address') }} -->
                                {{ trans('auth.mobile_number') }}
                            </label>
                            <div class="col-lg-12">
                                <input id="reset_mobile_number" type="text" class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number" value="{{ old('mobile_number') }}" autocomplete="mobile_number" autofocus maxlength="10">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0 text-center">
                            <div class="col-lg-12 offset-md-4">
                                <button type="submit" class="btn btn-primary reset_email_btn">
                                    <!-- {{ trans('auth.send_password_reset_link') }} --> 
                                    {{ trans('auth.submit') }} <i class="fas fa-long-arrow-alt-right"></i>
                                </button>
                                <a class="btn btn-link login_url_btn" href="{{ route('login') }}">
                                     {{ trans('auth.user_have_account') }}
                                </a>
                                <hr>
                                <a class="btn btn-link register_url_btn" href="{{ route('register') }}">
                                    {{ trans('auth.have_not_account') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Verify Otp  -->
            <div class="card hide" id="verify-otp-form">
                @include('partials.verify-otp')
            </div>

            <!-- ResetPasswr -->
            <div class="card hide" id="reset_password_form_div">
                @include('partials.reset-mobile')
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
    $(document).ready(function() {
        $.validator.addMethod("mobileValidation",
            function(value, element) { return !value.match(/^(\d)\1+$/g); },
        "Mobile number is invalid");

        // Password Reset
        $("#reset_email_form").validate({
            errorElement: 'span',
            rules: {
                mobile_number: {
                    required: true,
                    email: false,
                    minlength:10,
                    maxlength:10,
                    number: true,
                    mobileValidation:true
                },
            },
            messages: {
                mobile_number:{
                    required:"{{trans('auth.partner_mobile_number_required') }}",
                    number: "{{trans('auth.partner_mobile_number_number') }}",
                    numberRange: "{{trans('auth.partner_mobile_number_length') }}",
                }
            }
        });

        $('#reset_email_form').ajaxForm({
            beforeSend: function() {
                $('.reset_email_btn i').removeClass('fa-long-arrow-alt-right');
                $('.reset_email_btn i').addClass('fa-spinner fa-spin');
                $('span.error').remove();
                $('#reset_email_form .error').removeClass('error');
            },
            success: function(response) {
                $('.reset_email_btn i').removeClass('fa-spinner fa-spin');
                $('.reset_email_btn i').addClass('fa-long-arrow-alt-right');
                $('.password-reset-email .alert').addClass('hide');
                if (response.success) {
                    $('.password-reset-email .custom_success').text(response.message).removeClass('hide');
                    $('#otp_mobile_number').val(response.data);
                    $('#resend_mobile_number').val(response.data);
                    $('.send_otp_mobile_no').html('+91 - '+response.data);
                    setTimeout(function(){
                        $('.custom_success').addClass('hide');
                        $('#password-reset-email').addClass('hide');
                        $('#verify-otp-form').removeClass('hide');
                    },1500);
                } else {
                    $('.password-reset-email .custom_error').text(response.message).removeClass('hide');
                }
            }
        });

        // Verify OTP
        $("#verify_otp_form").validate({
            errorElement: 'span',
            ignore: [],
            rules: {
                otp_number: {
                    required: true,
                    minlength:6,
                    maxlength:6,
                    number: true,
                },
            }
        });

        $('#verify_otp_form').ajaxForm({
            beforeSend: function() {
                $('.reset_password_btn i').removeClass('fa-long-arrow-alt-right');
                $('.reset_password_btn i').addClass('fa-spinner fa-spin');
                $('span.error').remove();
                $('#verify_otp_form .error').removeClass('error');
            },
            success: function(response) {
                $('.reset_password_btn i').removeClass('fa-spinner fa-spin');
                $('.reset_password_btn i').addClass('fa-long-arrow-alt-right');
                $('.password-reset-email .alert').addClass('hide');
                if (response.success) {
                    $('.password-reset-email .custom_success').text(response.message).removeClass('hide');
                    $('#reset_mobile').val(response.data.mobile_number);
                    setTimeout(function(){
                        $('.custom_success').addClass('hide');
                        $('#verify-otp-form').addClass('hide');
                        $('#reset_password_form_div').removeClass('hide');
                    },1500);
                } else {
                    $('.password-reset-email .custom_error').text(response.message).removeClass('hide');
                }
            }
        });

        // Password Reset
        $("#reset_password_form").validate({
            errorElement: 'span',
            rules: {
                email: {
                    required: true,
                    //email: true
                },
                password: {
                    required:true,
                    minlength: 6
                },
                password_confirmation: {
                    required:true,
                    minlength : 6,
                    equalTo: '#reset-password-new',
                },
            },
            messages: {
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 6 characters long"
                },
                password_confirmation: {
                    equalTo :"{{ trans('auth.confirm_psw_not_match') }}"
                },
                email: "Please enter a valid email address",
            }
        });

        $('#reset_password_form').ajaxForm({
            beforeSend: function() {
                $('.reset_password_btn i').removeClass('fa-long-arrow-alt-right');
                $('.reset_password_btn i').addClass('fa-spinner fa-spin');
                $('span.error').remove();
                $('#reset_password_form .error').removeClass('error');
            },
            success: function(response) {
                $('.reset_password_btn i').removeClass('fa-spinner fa-spin');
                $('.reset_password_btn i').addClass('fa-long-arrow-alt-right');
                $('.password-reset-email .alert').addClass('hide');
                if (response.success) {
                    $('.password-reset-email .custom_success').text(response.message).removeClass('hide');
                    setTimeout(function(){
                        $('#reset_password_form_div').addClass('hide');
                        $('#password-reset-email').removeClass('hide');
                        window.location.href = response.redirect_url;
                    }, 1500);
                } else {
                    if (response.errors) {
                        $.each(response.errors, function(key, val) {
                            $("input[name="+key+"]").addClass('error');
                            $("input[name="+key+"]").after('<span for="'+key+'" generated="true" class="error">'+val[0]+'</span>');
                        });
                    } else {
                        $('.password-reset-email .custom_error').text(response.message).removeClass('hide');
                    }
                }
            }
        });

        $('#resend-otp').ajaxForm({
            beforeSend: function() {
                $('.resend-btn i').removeClass('fa-long-arrow-alt-right');
                $('.resend-btn i').addClass('fa-spinner fa-spin');
                $('span.error').remove();
                $('#resend-otp .error').removeClass('error');
            },
            success: function(response) {
                $('.resend-btn i').removeClass('fa-spinner fa-spin');
                $('.resend-btn i').addClass('fa-long-arrow-alt-right');
                $('.password-reset-email .custom_error').addClass('hide');
                if (response.success) {
                    $('.password-reset-email .custom_success').text(response.message).removeClass('hide');
                    setTimeout(function(){ $('.custom_success').addClass('hide'); $('.resend-btn-div').addClass('hide') }, 2000);
                }else {
                    $('.password-reset-email .custom_error').text(response.message).removeClass('hide');
                    setTimeout(function(){
                        $('.custom_error').addClass('hide');
                    }, 2000);
                }
            }
        });

        var counter = 60;
        var interval = setInterval(function() {
            counter--;
            // Display 'counter' wherever you want to display it.
            if (counter <= 0) {
                clearInterval(interval);
                $('.countdown-text').addClass('hide');
                $('.resend-btn').prop('disabled', false);
                return;
            }else{
                $('.countdown-text').html("<span>This options below will activate in "+counter+" seconds</span>");
              //console.log("Timer --> " + counter);
            }
        }, 1000);
    });
</script>
@endpush