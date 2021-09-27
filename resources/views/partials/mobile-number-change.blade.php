<!-- Mobile Number Change popup -->
<div class="modal fade" id="mobile-no-change" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="mobileNoChange" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close equipment-close-btn mobile-pop-close-btn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="error-reponse-message">
                <div class="alert alert-success custom_success hide"></div>
                <div class="alert alert-danger custom_error hide"></div>
            </div>
            <div class="mobile_first_step_verify">
                <h2 class="text-center mobile-verify-head">{{ trans('messages.mobile_no_change_title') }}</h2>
                <h4>{{ trans('messages.mobile_no_change_msg') }}</h4>
                <form name="mobile_no_change_form" id="mobile_no_change_form" method="post" action="{{ route('mobile.number.change') }}">
                    @csrf
                    <div class="col-md-8  col-md-offset-2 col-xs-12 register-form-input">
                        <div class="input-group">
                          <span class="input-group-addon"> +91</span>
                            <input type="text" class="form-control" name="change_mobile_no" maxlength="10"  placeholder="{{ trans('messages.enter_mobile_number')}} *" maxlength="10" value="">
                        </div>
                        <div class="" id="mobile-validation-error"></div>
                    </div>
                    <div class="col-md-12 col-xs-12 text-center">
                        <button type="submit" class="btn btn-primary common-btn">
                            {{ trans('auth.submit') }}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="mobile_otp_second_step_vefiy hide">
                <h2 class="text-center mobile-verify-head">{{ trans('messages.verify_otp') }}</h2>
                <h4>{{ trans('messages.please_enter_otp') }}</h4>
                 <div class="text-center send_mobile_no"></div>
                <form method="POST" action="{{ route('change.phone.otp.verify') }}" id="my_verify_otp_form" class="form-group" name="verify_otp_form">
                    @csrf
                    <input type="hidden" name="mobile_number" value="" id="my_otp_mobile_number">
                        <div class="col-md-10 col-xs-12 col-md-offset-1">
                            <div class="otp-number-box">
                                <input  type="text" class="form-control otp-input-box @error('otp_number') is-invalid @enderror" name="otp_number" value="{{ old('otp_number') }}" maxlength="6">
                            </div>
                        </div>
                    
                        <div class="col-md-12 col-xs-12 text-center verify-btn-div">
                            <button type="submit" class="btn btn-primary common-btn">
                                {{ trans('messages.verify_btn') }}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i>
                            </button>
                        </div>
                </form>
                <form method="POST" class="form-group" name="resend-otp" id="resend-otp-form" action="{{ route('mobile.number.verification', ['type' => 'resend']) }}">
                    @csrf
                    <input type="hidden" class="form-control" name="mobile_number" id="my_resend_mobile_number">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12 form-group text-center">
                            Didn't receive the code? <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="Your verification code is on its way! It may take a few minutes to deliver depending on your service provider."></i>
                        </div>
                        <div class="col-lg-12 col-md-12 col-xs-12 form-group text-center resend-btn-div">
                            <button type="submit" class="btn btn-primary common-btn">
                                {{ trans('messages.re_send_btn') }}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i>
                            </button>
                        </div>
                    </div>   
                </form>
            </div>
        </div>
    </div>
  </div>
</div>
<!-- End Mobile Number Change popup -->
@push('script')
    <script type="text/javascript">
        var resendLimt = "{{ $resendLimit }}";
        $(document).ready(function() {

            $('body').on('click', '.change-mobile-number', function() {
                $('#mobile_no_change_form').trigger("reset");
                $('mobile_first_step_verify').removeClass('hide');
                $('#mobile-no-change').modal('show');
            });
            $('body').on('click', '.mobile-pop-close-btn', function() {
                location.reload();
            });

            $.validator.addMethod("mobileValidation",
            function(value, element) { return !value.match(/^(\d)\1+$/g); },
            "Mobile number is invalid");

            // Mobile number verification function
            $("#mobile_no_change_form").validate({
                errorElement: 'span',
                rules: {
                    change_mobile_no:{
                        required: true,
                        minlength:10,
                        maxlength:10,
                        number: true,
                        mobileValidation:true
                    }
                },
                errorPlacement: function(error, element) {
                    var terms = element.attr("name");
                    if (terms == 'change_mobile_no') {
                        error.insertAfter('#mobile-validation-error');
                    }else {
                        error.insertAfter(element);
                    }
                }
            });
            $('#mobile_no_change_form').ajaxForm({
                beforeSend: function() {
                    $('.common-btn i').removeClass('fa-long-arrow-alt-right');
                    $('.common-btn i').addClass('fa-spinner fa-spin');
                    $('span.error').remove();
                    $('#mobile-verification .error').removeClass('error');
                },
                success: function(response) {
                    $('.common-btn i').removeClass('fa-spinner fa-spin');
                    $('.common-btn i').addClass('fa-long-arrow-alt-right');
                    $('.error-reponse-message .custom_error').addClass('hide');
                    if (response.success) {
                        $('.error-reponse-message .custom_success').text(response.message).removeClass('hide');
                        setTimeout(function(){
                            $('.custom_success').addClass('hide');
                            $('.mobile_first_step_verify').addClass('hide');
                            $('.mobile_otp_second_step_vefiy').removeClass('hide');
                            $('.send_mobile_no').text('+91 '+response.data);
                            $('#my_otp_mobile_number').val(response.data);
                            $('#my_resend_mobile_number').val(response.data);
                        }, 1500);
                    }else if (response.errors) {
                        $.each(response.errors, function(key, val) {
                            $("input[name="+key+"]").addClass('error');
                            $("#mobile-validation-error").after('<span for="'+key+'" generated="true" class="error">'+val[0]+'</span>');
                        });
                    }else {
                        $('.error-reponse-message .custom_error').text(response.message).removeClass('hide');
                        setTimeout(function(){ $('.custom_error').addClass('hide'); }, 3000);
                    }
                }
            });
            //mobilenumberverifyotp
            $("#my_verify_otp_form").validate({
                errorElement: 'span',
                ignore: [],
                rules: {
                    otp_number:{
                        required: true,
                        minlength:6,
                        maxlength:6,
                        number: true,
                    }
                },
            });

            $('#my_verify_otp_form').ajaxForm({
                beforeSend: function() {
                    $('.common-btn i').removeClass('fa-long-arrow-alt-right');
                    $('.common-btn i').addClass('fa-spinner fa-spin');
                    $('span.error').remove();
                    $('#my_verify_otp_form .error').removeClass('error');
                },
                success: function(response) {
                    $('.common-btn i').removeClass('fa-spinner fa-spin');
                    $('.common-btn i').addClass('fa-long-arrow-alt-right');
                    $('.otp-verification-container .custom_error').addClass('hide');
                    if (response.success) {
                        $('.error-reponse-message .custom_success').text(response.message).removeClass('hide');
                        setTimeout(function(){
                            $('.custom_success').addClass('hide');
                            $('#mobile-no-change').modal('hide');
                            location.reload();
                        }, 2000);
                    }else {
                        $('.error-reponse-message .custom_error').text(response.message).removeClass('hide');
                        setTimeout(function(){
                            $('.custom_error').addClass('hide');
                        }, 2000);
                    }
                }
            });

            $('#resend-otp-form').ajaxForm({
                beforeSend: function() {
                    $('.common-btn i').removeClass('fa-long-arrow-alt-right');
                    $('.common-btn i').addClass('fa-spinner fa-spin');
                    $('span.error').remove();
                    $('#resend-otp-form .error').removeClass('error');
                },
                success: function(response) {
                    $('.common-btn i').removeClass('fa-spinner fa-spin');
                    $('.common-btn i').addClass('fa-long-arrow-alt-right');
                    $('.otp-verification-container .custom_error').addClass('hide');
                    if (response.success) {
                        $('.error-reponse-message .custom_success').text(response.message).removeClass('hide');
                        if (response.resendCount == resendLimt) {
                            $('.resend-btn-div').addClass('hide');
                        }
                        setTimeout(function(){ $('.custom_success').addClass('hide'); }, 2000);
                    }else {
                        $('.error-reponse-message .custom_error').text(response.message).removeClass('hide');
                        setTimeout(function(){
                            $('.custom_error').addClass('hide');
                        }, 2000);
                    }
                }
            });
    });
    </script>
@endpush