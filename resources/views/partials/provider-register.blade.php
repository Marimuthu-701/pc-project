<div class="container partner-register-form">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="partner-form-title">{{ trans('auth.partner_registration') }}</h3>
                </div>
                <div class="card-body">
                    <div class="custom_error alert alert-danger hide"></div>
                    <div class="custom_success alert alert-success hide"></div>
                    <form method="POST" action="{{ route('provider.register') }}" class="register_form" id="provider_register_form">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                  <input type="email" class="form-control @error('partner_email') is-invalid @enderror" name="email" value="{{ old('partner_email') }}" placeholder="{{ trans('auth.email_address') }} *">
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <input type="text" class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number" value="{{ old('mobile_number') }}" placeholder="{{ trans('auth.mobile_number') }} *" maxlength="10">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <input id="password_new" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="partner_password_new" placeholder="{{ trans('auth.password') }} *">
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <input type="password" class="form-control" name="password_confirm" placeholder="{{ trans('auth.confirm_password') }} *">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <button type="submit" class="btn btn-primary register_btn">
                                    &nbsp;&nbsp;&nbsp;{{ trans('auth.register') }}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i>
                                </button>
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <a href="{{ route('login')}}" class="have-account pull-right">{{ trans('auth.user_have_account') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('script')
<script type="text/javascript">
    $(document).ready(function(){
        $("#provider_register_form").validate({
            errorElement: 'span',
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required:true,
                    minlength: 6
                },
                password_confirm: {
                    required:true,
                    minlength : 6,
                    equalTo: '#password_new',
                },
                mobile_number: {
                    required: true,
                    minlength:10,
                    maxlength:10,
                    number: true,
                    mobileValidation:true
                },
                
            },
            messages: {
                password: {
                    required: "{{trans('auth.partner_psw_required') }}",
                    minlength: "{{trans('auth.partner_psw_length') }}",
                },
                password_confirm:{
                  required: "{{trans('auth.partner_password_confirm') }}",
                  equalTo : "{{ trans('auth.confirm_psw_not_match') }}"
                },
                email: "{{trans('auth.partner_email') }}",
                mobile_number: {
                    required:"{{trans('auth.partner_mobile_number_required') }}",
                    number: "{{trans('auth.partner_mobile_number_number') }}",
                    numberRange: "{{trans('auth.partner_mobile_number_length') }}",
                },
            }
        });
        $('#provider_register_form').ajaxForm({
            beforeSend: function() {
                $('.register_btn i').removeClass('fa-long-arrow-alt-right');
                $('.register_btn i').addClass('fa-spinner fa-spin');
                $('.register_btn').prop('disabled', true);
                $('span.error').remove();
                $('#provider_register_form .error').removeClass('error');
            },
            success: function(response) {
                $('.register_btn i').removeClass('fa-spinner fa-spin');
                $('.register_btn i').addClass('fa-long-arrow-alt-right');
                $('.partner-register-form .custom_error').addClass('hide');
                if (response.success) {
                    $('.register_btn').addClass('hide');
                    $('.partner-register-form .custom_success').text(response.message).removeClass('hide');
                    setTimeout(function(){
                        $('.custom_success').addClass('hide');
                        window.location.href = response.redirect_url;
                    },2000);
                } else if (response.errors) {
                    $('.register_btn').prop('disabled', false);
                    $.each(response.errors, function(key, val) {
                        $("input[name="+key+"], select[name="+key+"]").addClass('error');
                        $("input[name="+key+"], select[name="+key+"]").after('<span for="'+key+'" generated="true" class="error">'+val[0]+'</span>');
                    });
                } else {
                    $('.register_btn').prop('disabled', false);
                    $('.partner-register-form .custom_error').text(response.message).removeClass('hide');
                }
            }
        });
    });
</script>
@endpush