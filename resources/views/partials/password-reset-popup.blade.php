 <div class="col-lg-12">
    <div class="card" id="password-reset-email">
        <div class="card-header register-title">{{ trans('auth.reeset_password') }}</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="login-form-content register-form-content">
                        <div class="custom_error alert alert-danger hide"></div>
                        <div class="custom_success alert alert-success hide"></div>
                        <form method="POST" action="{{ route('password.email') }}" id="password-reset-form">
                            @csrf
                            <div class="form-group row">
                                <label for="reset_mobile_number" class="col-lg-12 col-form-label text-md-right required">
                                    <!-- {{ trans('auth.email_address') }} -->
                                    {{ trans('auth.email_address') }}
                                </label>
                                <div class="col-lg-12">
                                    <input id="reset_mobile_number" type="text" class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number" value="{{ old('mobile_number') }}" autocomplete="mobile_number" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0 text-center">
                                <div class="col-lg-12 offset-md-4">
                                    <button type="submit" class="btn btn-primary common-btn">
                                        <!-- {{ trans('auth.send_password_reset_link') }} --> 
                                        {{ trans('auth.submit') }} <i class="fas fa-long-arrow-alt-right"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12 text-center dont-have-account">
                                    <a class="btn btn-link login-popup-btn" href="javascript:void(0)">
                                        <span>{{ trans('auth.already_login') }}</span> {{trans('auth.login')}}
                                    </a>
                                    <hr>
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
    <!-- Verify Otp  -->
    <div class="card hide" id="verify-otp-form">
        @include('partials.verify-otp')
    </div>

    <!-- ResetPasswr -->
    <div class="card hide" id="reset_password_form_div">
        @include('partials.reset-mobile')
    </div>
</div>
@push('script')
<script>
    $(document).ready(function() {
        localStorage.removeItem("resentCount");
        $.validator.addMethod("mobileValidation",
            function(value, element) { return !value.match(/^(\d)\1+$/g); },
        "Mobile number is invalid");

        // Password Reset
        $("#password-reset-form").validate({
            errorElement: 'span',
            rules: {
                mobile_number: {
                    required: true,
                    email: true,
                    /*minlength:10,
                    maxlength:10,
                    number: true,
                    mobileValidation:true*/
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

        $('#password-reset-form').ajaxForm({
            beforeSend: function() {
                $('.common-btn i').removeClass('fa-long-arrow-alt-right');
                $('.common-btn i').addClass('fa-spinner fa-spin');
                $('.common-btn').prop('disabled', true);
                $('span.error').remove();
                $('#password-reset-form .error').removeClass('error');
            },
            success: function(response) {
                $('.common-btn i').removeClass('fa-spinner fa-spin');
                $('.common-btn i').addClass('fa-long-arrow-alt-right');
                $('.password-reset-email .alert').addClass('hide');
                $('.common-btn').prop('disabled', false);
                if (response.success) {
                    $('.password-reset-email .custom_success').text(response.message).removeClass('hide');
                    $('#otp_mobile_number').val(response.data);
                    $('#resend_mobile_number').val(response.data);
                    if(response.via_email){
                        $('.send_otp_mobile_no').html(response.data);
                        $('.otp-resend-div').addClass('hide');
                    } else {
                        $('.send_otp_mobile_no').html('+91 - '+response.data);
                    }
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
                $('.reset_password_btn').prop('disabled', true);
                $('span.error').remove();
                $('#verify_otp_form .error').removeClass('error');
            },
            success: function(response) {
                $('.reset_password_btn i').removeClass('fa-spinner fa-spin');
                $('.reset_password_btn i').addClass('fa-long-arrow-alt-right');
                $('.password-reset-email .alert').addClass('hide');
                $('.reset_password_btn').prop('disabled', false);
                if (response.success) {
                    $('.password-reset-email .custom_success').text(response.message).removeClass('hide');
                    $('#reset_mobile').val(response.data.email);
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
                $('.reset_password_btn').prop('disabled', true);
                $('span.error').remove();
                $('#reset_password_form .error').removeClass('error');
            },
            success: function(response) {
                $('.reset_password_btn i').removeClass('fa-spinner fa-spin');
                $('.reset_password_btn i').addClass('fa-long-arrow-alt-right');
                $('.password-reset-email .alert').addClass('hide');
                $('.reset_password_btn').prop('disabled', false);
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
        var existing = localStorage.getItem('resentCount');
        $('body').on('click', '.resend-btn', function() {
            var setcount = existing ? 2 : 1;
            localStorage.setItem("resentCount", setcount);
        });
        $('#resend-otp').ajaxForm({
            beforeSend: function() {
                $('.resend-btn i').removeClass('fa-long-arrow-alt-right');
                $('.resend-btn i').addClass('fa-spinner fa-spin');
                $('span.error').remove();
                $('#resend-otp .error').removeClass('error');
            },
            success: function(response) {
                var getResent = localStorage.getItem('resentCount');
                $('.resend-btn i').removeClass('fa-spinner fa-spin');
                $('.resend-btn i').addClass('fa-long-arrow-alt-right');
                $('.password-reset-email .custom_error').addClass('hide');
                if (response.success) {
                    $('.password-reset-email .custom_success').text(response.message).removeClass('hide');
                    setTimeout(function(){ 
                        $('.custom_success').addClass('hide');
                        if (getResent == 1) {
                            $('.resend-btn-div').addClass('hide')
                            localStorage.removeItem("resentCount");
                        }
                    }, 2000);
                }else {
                    $('.password-reset-email .custom_error').text(response.message).removeClass('hide');
                    setTimeout(function(){
                        $('.custom_error').addClass('hide');
                    }, 2000);
                }
            }
        });
    });
</script>
@endpush