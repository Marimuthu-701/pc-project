@extends('layouts.app')

@section('content')
<div class="main-container" id="mobile_number_verification">
    <!-- <section id="partner-home-banner">
        <div class="page-title partner-page-title">
            <h1>{{ trans('messages.partner_banner_heading') }}</h1>
            <p>{{ trans('messages.partner_banner_subtitle') }}</p>
        </div>
    </section> -->
    <section id="partner-register">
        <div class="container mobile-verification-container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card" id="mobile_no_verify">
                        <div class="card-header">
                            <h3 class="text-center mobile-verification">{{ trans('messages.mobile_verification') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="custom_success alert alert-success hide"></div>
                            <div class="custom_error alert alert-danger hide"></div>
                            <h2>{{ trans('messages.mobile_verification_info') }}</h2>
                            <form method="POST" action="{{ route('mobile.number.verification') }}" id="mobile-verification" class="form-group" name="mobile-verification">
                                @csrf
                                <div class="col-md-6  col-md-offset-3 col-xs-12 register-form-input">
                                    <div class="input-group">
                                      <span class="input-group-addon"> +91</span>
                                        <input type="text" class="form-control" id="mobile_number" name="mobile_number" maxlength="10"  placeholder="{{ trans('messages.enter_mobile_number')}} *" maxlength="10" value="{{ isset($authUserMobile) ? $authUserMobile : null }}">
                                    </div>
                                    <div class="" id="mobile-validation-error"></div>
                                </div>
                                <div class="col-md-12 col-xs-12 text-center">
                                    <button type="submit" class="btn btn-primary mobile-submit">
                                        {{ trans('auth.submit') }}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="homes-services">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <img src="{{ asset('images/home_near_me.png') }}" alt="#">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <img src="{{ asset('images/services_near_me.png') }}" alt="#">
                </div>
            </div>
        </div>
    </section>
</div>
@push('script')
<script>
    $(document).ready(function() {
        //Similarly for mobile number
        $.validator.addMethod("mobileValidation",
            function(value, element) { return !value.match(/^(\d)\1+$/g); },
        "Mobile number is invalid");

        // Mobile number verification function
        $("#mobile-verification").validate({
            errorElement: 'span',
            rules: {
                mobile_number:{
                    required: true,
                    minlength:10,
                    maxlength:10,
                    number: true,
                    mobileValidation:true
                }
            },
            errorPlacement: function(error, element) {
                var terms = element.attr("name");
                if (terms == 'mobile_number') {
                    error.insertAfter('#mobile-validation-error');
                }else {
                    error.insertAfter(element);
                }
            }
        });
        $('#mobile-verification').ajaxForm({
            beforeSend: function() {
                $('.mobile-submit i').removeClass('fa-long-arrow-alt-right');
                $('.mobile-submit i').addClass('fa-spinner fa-spin');
                $('span.error').remove();
                $('#mobile-verification .error').removeClass('error');
            },
            success: function(response) {
                $('.mobile-submit i').removeClass('fa-spinner fa-spin');
                $('.mobile-submit i').addClass('fa-long-arrow-alt-right');
                $('.mobile-verification-container .custom_error').addClass('hide');
                if (response.success) {
                    $('.mobile-verification-container .custom_success').text(response.message).removeClass('hide');
                    setTimeout(function(){ 
                        $('.custom_success').addClass('hide');
                        window.location.href = response.redirect_url;
                    }, 1500);
                }else if (response.errors) {
                    $.each(response.errors, function(key, val) {
                        $("input[name="+key+"]").addClass('error');
                        $("#mobile-validation-error").after('<span for="'+key+'" generated="true" class="error">'+val[0]+'</span>');
                    });
                }else {
                    $('.mobile-verification-container .custom_error').text(response.message).removeClass('hide');
                    setTimeout(function(){ $('.custom_error').addClass('hide'); }, 3000);
                }
            }
        });
    });
</script>
@endpush
@endsection