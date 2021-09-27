@php
    $resendLimit = config('textlocal.resend_limit');
@endphp

@extends('layouts.app')
@section('content')
<div class="main-container" id="mobile_number_verification">
    <section id="partner-register">
        <div class="container otp-verification-container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="text-center verify-head">{{ trans('messages.verify_otp') }} </h1>
                        </div>
                        <div class="card-body">
                            <div class="custom_success alert alert-success hide"></div>
                            <div class="custom_error alert alert-danger hide"></div>
                            <div class="row form-group">
                                <div class="col-lg-12 col-md-12 col-xs-12 text-center">
                                    <div class="otp-user-message">
                                        {{ trans('messages.please_enter_otp') }}<br/>
                                        @if($via_email)
                                            <label>{{ $authUserMobile }}</label>
                                        @else
                                            <label>+91 - {{ $authUserMobile }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @guest
                                <form method="POST" action="{{ route('otp.verification') }}" id="mobile-verification-otp" class="form-group" name="otp-verify">
                            @else
                                <form method="POST" action="{{ route('user.opt.verify') }}" id="mobile-verification-otp" class="form-group" name="otp-verify">
                            @endguest
                                @csrf
                                <input type="hidden" class="form-control"  name="mobile_number"  value="{{ isset($authUserMobile) ? $authUserMobile : null }}">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="otp-number-box">
                                            <input type="text" class="form-control otp-input-box" name="otp_number" maxlength="6" placeholder="{{ trans('messages.enter_otp')}} *" maxlength="6">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12 text-center">
                                        <button type="submit" class="btn btn-primary verify-btn">
                                            {{ trans('messages.verify_btn') }}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            @if(!$via_email)
                            <form method="POST" class="form-group" name="resend-otp" id="register-resend-otp" action="{{ route('mobile.number.verification', ['type' => 'resend']) }}">
                                @csrf
                                <input type="hidden" class="form-control"  name="mobile_number"  value="{{ isset($authUserMobile) ? $authUserMobile : null }}">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-xs-12 form-group text-center did-not-receive">
                                        Didn't receive the code? <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="Your verification code is on its way! It may take a few minutes to deliver depending on your service provider."></i>
                                    </div>
                                    @if($btnEnable)
                                        <div class="col-lg-12 col-md-12 col-xs-12 form-group text-center resend-btn-div">
                                            <button type="submit" class="btn btn-primary resend-btn">
                                                {{ trans('messages.re_send_btn') }}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i>
                                            </button>
                                        </div>
                                    @endif
                                </div>   
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('partials.near-me-home-service')
</div>
@push('script')
<script>
    $(document).ready(function() {
        var resendLimt = "{{ $resendLimit }}";
        //mobilenumberverifyotp
        $("#mobile-verification-otp").validate({
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
        $('#mobile-verification-otp').ajaxForm({
            beforeSend: function() {
                $('.verify-btn i').removeClass('fa-long-arrow-alt-right');
                $('.verify-btn i').addClass('fa-spinner fa-spin');
                $('.verify-btn').prop('disabled', true);
                $('span.error').remove();
                $('#mobile-verification-otp .error').removeClass('error');
            },
            success: function(response) {
                $('.verify-btn i').removeClass('fa-spinner fa-spin');
                $('.verify-btn i').addClass('fa-long-arrow-alt-right');
                $('.otp-verification-container .custom_error').addClass('hide');
                if (response.success) {
                    $('.verify-btn').addClass('hide');
                    $('.otp-verification-container .custom_success').text(response.message).removeClass('hide');
                    setTimeout(function(){
                        $('.custom_success').addClass('hide');
                        window.location.href = response.redirect_url;
                    }, 2000);
                }else {
                    $('.verify-btn').prop('disabled', false);
                    $('.otp-verification-container .custom_error').text(response.message).removeClass('hide');
                    setTimeout(function(){
                        $('.custom_error').addClass('hide');
                    }, 2000);
                }
            }
        });

        $('#register-resend-otp').ajaxForm({
            beforeSend: function() {
                $('.resend-btn i').removeClass('fa-long-arrow-alt-right');
                $('.resend-btn i').addClass('fa-spinner fa-spin');
                $('span.error').remove();
                $('#mobile-verification-otp .error').removeClass('error');
            },
            success: function(response) {
                $('.resend-btn i').removeClass('fa-spinner fa-spin');
                $('.resend-btn i').addClass('fa-long-arrow-alt-right');
                $('.otp-verification-container .custom_error').addClass('hide');
                if (response.success) {
                    $('.otp-verification-container .custom_success').text(response.message).removeClass('hide');
                    if (response.resendCount == resendLimt) {
                        $('.resend-btn-div').addClass('hide');
                    }
                    setTimeout(function(){ $('.custom_success').addClass('hide'); }, 2000);
                }else {
                    $('.otp-verification-container .custom_error').text(response.message).removeClass('hide');
                    setTimeout(function(){
                        $('.custom_error').addClass('hide');
                    }, 2000);
                }
            }
        });

        /*var counter = 60;
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
        }, 1000);*/
    });
</script>
@endpush
@endsection