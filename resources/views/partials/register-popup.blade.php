<div class="col-lg-12">
    <div class="card">
        <div class="card-header register-title">{{ trans('auth.customer_registration') }}</div>
        <div class="text-center register-sub-title">Register with us for free</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="login-form-content register-form-content">
                        <div class="custom_error alert alert-danger hide"></div>
                        <div class="custom_success alert alert-success hide"></div>
                        <form method="POST" action="{{ route('register') }}" class="register_form" id="register_popup_form">
                            @csrf
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" autocomplete="first_name" placeholder="{{ trans('auth.name') }} *" autofocus>
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group hide">
                                <div class="col-lg-12">
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" autocomplete="last_name" placeholder="{{ trans('auth.last_name') }}" autofocus>
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{ trans('auth.email_address') }} *">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <input type="text" class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number" value="{{ old('mobile_number') }}" placeholder="{{ trans('auth.mobile_number') }} *" autocomplete="mobile_number" maxlength="10">
                                    @error('mobile_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <input id="psw-new" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ trans('auth.password') }} *" autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <input id="psw-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ trans('auth.confirm_password') }} *">
                                </div>
                            </div>
                           <div class="row form-group">
                               <label for="city" class="col-lg-12 col-form-label text-md-right hide required">{{ trans('messages.state') }}</label>
                               <div class="col-lg-12">
                                   <select class="form-control search-state @error('state') is-invalid @enderror" name="user_state">
                                        <option value="">{{ trans('auth.select_state') }} *</option>
                                        @if(isset($states) && !empty($states))
                                            @foreach($states as $key => $state)
                                                <option value="{{ $state->code }}">{{ $state->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                               </div>
                           </div>
                           <div class="row form-group">
                                <div class="col-lg-12">
                                    <select class="form-control city-drop-list @error('city') is-invalid @enderror" name="user_city" disabled="disabled">
                                        <option value="">{{ trans('messages.select_city') }} *</option>
                                        @if(isset($cities) && !empty($states))
                                            @foreach($cities as $key => $citie)
                                                <option value="{{ $citie->name }}">{{ $citie->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <input  type="text" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" value="{{ old('postal_code') }}" placeholder="{{ trans('auth.postal_code') }} *"maxlength="6">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <div class="checkbox terms-conditions">
                                        <label for="terms-con">
                                            <input type="checkbox" id="terms-con" name="terms_conditions" class="@error('terms_conditions') is-invalid @enderror" required="required">
                                            <span class="cr"><i class="fa fa-check cr-icon" aria-hidden="true"></i></span> {{ trans('auth.i_agree') }} <a href="{{ route('terms.conditions') }}" target="_blank"> {{ trans('messages.terms_conditions') }}</a>
                                        </label>
                                    </div>
                                </div>
                                <div class="terms-contion-error" id="terms-error"></div>
                            </div>
                            <div class="form-group row mb-0 form-group">
                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="btn btn-primary register_btn common-btn">
                                        {{ trans('auth.register') }} <i class="fas fa-long-arrow-alt-right"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 text-center dont-have-account">
                                    <a class="btn btn-link login-popup-btn" href="javascript:void(0)">
                                        <span>{{ trans('auth.already_login') }}</span> {{trans('auth.login')}}
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
@push('script')
<script type="text/javascript">
    $(document).ready(function() {
        $.validator.addMethod("mobileValidation",
            function(value, element) { return !value.match(/^(\d)\1+$/g); },
        "Mobile number is invalid");

        $.validator.addMethod("alpha", function(value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z\s\.\&\_\/\'\-]+$/);
        },"Letters and space &./_'- only please");

        $("#register_popup_form").validate({
            ignore: [],
            errorElement: 'span',
            rules: {
                first_name:{
                    required: true,
                    alpha: true,
                    maxlength:50,  
                },
                /*last_name: "required",*/
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                password_confirmation: {
                    required: true,
                    minlength : 6,
                    equalTo: '#psw-new',
                },
                mobile_number: {
                    required: true,
                    minlength:10,
                    maxlength:10,
                    number: true,
                    mobileValidation: true
                },
                user_state:{
                    required:true,
                },
                user_city:{
                    required:true,
                },
                postal_code:{
                    required:true,
                    minlength: 6,
                    digits: true,
                },
                terms_conditions :{
                    required:true,
                },
            },
            messages: {
                first_name:{
                   required: "{{ trans('auth.user_name_msg') }}",
                }, 
                password: {
                    required: "{{ trans('auth.password_required_msg') }}",
                    minlength: "{{ trans('auth.password_lengh_msg') }}"
                },
                password_confirmation:{
                   equalTo :"{{ trans('auth.confirm_psw_not_match') }}" 
                },
                email: "{{ trans('auth.user_email_msg') }}",
                mobile_number: {
                    number: "{{ trans('auth.mobile_number_formate') }}",
                    numberRange: "{{ trans('auth.mobile_number_range') }}",
                },
                terms_conditions : "{{ trans('auth.terms_condition_error') }}",
            },
            errorPlacement: function(error, element) {
                var terms = element.attr("name");
                if (terms == 'terms_conditions') {
                    error.insertAfter('#terms-error');
                }else {
                    error.insertAfter(element);
                }
            }
        });
        $('#register_popup_form').ajaxForm({
            url: base_url + 'register',
            beforeSend: function() {
                $('.register_btn i').removeClass('fa-long-arrow-alt-right');
                $('.register_btn i').addClass('fa-spinner fa-spin');
                $('.register_btn').prop('disabled', true);
                $('span.error').remove();
                $('#register_popup_form .error').removeClass('error');
            },
            success: function(response) {
                $('.register_btn i').removeClass('fa-spinner fa-spin');
                $('.register_btn i').addClass('fa-long-arrow-alt-right');
                $('.register-form-content .custom_error').addClass('hide');
                if (response.success) {
                    $('.register_btn').addClass('hide');
                    $('.register-form-content .custom_success').text(response.message).removeClass('hide');
                    setTimeout(function(){
                        $('.custom_success').addClass('hide'); 
                        window.location.href = response.redirect_url;
                    }, 2000);
                } else {
                    $('.register_btn').prop('disabled', false);
                    if (response.errors) {
                        $.each(response.errors, function(key, val) {
                            $("input[name="+key+"], select[name="+key+"]").addClass('error');
                            $("input[name="+key+"], select[name="+key+"]").after('<span for="'+key+'" generated="true" class="error">'+val[0]+'</span>');
                        });
                    } else {
                        $('.register-form-content .custom_error').text(response.message).removeClass('hide');
                    }
                }
            }
        });
    });
</script>
@endpush