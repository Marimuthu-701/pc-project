@extends('layouts.app')

@section('content')
<div class="main-container" id="mobile_number_verification">
    <section id="partner-register">
        <div class="container mobile-verification-container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card" id="mobile_no_verify">
                        <div class="card-header">
                            <h3 class="text-center mobile-verification">{{ trans('messages.email_verification') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="custom_success alert alert-success hide"></div>
                            <div class="custom_error alert alert-danger hide"></div>
                            <h2>{{ trans('messages.email_verification_info') }}</h2>
                            <form method="POST" action="{{ route('email.verify') }}" id="email-verification" class="form-group" name="mobile-verification">
                                @csrf
                                <div class="col-md-6  col-md-offset-3 col-xs-12 register-form-input">
                                    <input type="text" class="form-control" name="email"  placeholder="{{ trans('messages.enter_your_email')}} *" value="{{ isset($authEmail) ? $authEmail : null }}" readonly="readonly">
                                </div><i data-toggle="tooltip" data-placement="top" title="Edit" class='fas fa-pencil-alt email-verify-edit-option'></i>
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
    @include('partials.near-me-home-service')
</div>
@push('script')
<script>
    $(document).ready(function() {
        $(document).on('click', '.email-verify-edit-option', function() {
            $('[name="email"]').removeAttr('readonly');
        });

        // Mobile number verification function
        $("#email-verification").validate({
            errorElement: 'span',
            rules: {
                email:{
                    required: true,
                    email:true,
                }
            }
        });
        $('#email-verification').ajaxForm({
            beforeSend: function() {
                $('.mobile-submit i').removeClass('fa-long-arrow-alt-right');
                $('.mobile-submit i').addClass('fa-spinner fa-spin');
                $('.mobile-submit').prop('disabled', true);
                $('span.error').remove();
                $('#email-verification .error').removeClass('error');
            },
            success: function(response) {
                $('.mobile-submit i').removeClass('fa-spinner fa-spin');
                $('.mobile-submit i').addClass('fa-long-arrow-alt-right');
                $('.mobile-verification-container .custom_error').addClass('hide');
                if (response.success) {
                    $('.mobile-submit').addClass('hide');
                    $('.mobile-verification-container .custom_success').text(response.message).removeClass('hide');
                    setTimeout(function(){ 
                        $('.custom_success').addClass('hide');
                        window.location.href = response.redirect_url;
                    }, 1500);
                }else if (response.errors) {
                    $('.mobile-submit').prop('disabled', false);
                    $.each(response.errors, function(key, val) {
                        $("input[name="+key+"]").addClass('error');
                        $("input[name="+key+"]").after('<span for="'+key+'" generated="true" class="error">'+val[0]+'</span>');
                    });
                }else {
                    $('.mobile-submit').prop('disabled', false);
                    $('.mobile-verification-container .custom_error').text(response.message).removeClass('hide');
                    setTimeout(function(){ $('.custom_error').addClass('hide'); }, 3000);
                }
            }
        });
    });
</script>
@endpush

@endsection