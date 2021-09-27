<div class="container register-container register-sticky-container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header register-title">{{ trans('auth.customer_registration') }}</div>
                <div class="text-center register-sub-title">Register with us for free</div>
                <div class="card-body">
                    <div class="custom_error alert alert-danger hide"></div>
                    <div class="custom_success alert alert-success hide"></div>
                    <form method="POST" action="{{ route('register') }}" class="register_form" id="register_form">
                        @csrf
                        <div class="row user-register-form">
                            <label for="first-name" class="col-lg-12 col-form-label text-md-right required hide">{{ trans('auth.first_name') }}</label>

                            <div class="col-lg-12">
                                <input id="first-name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" autocomplete="first_name" placeholder="{{ trans('auth.name') }} *" autofocus>

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row user-register-form hide">
                            <label for="last-name" class="col-lg-12 col-form-label text-md-right ">{{ trans('auth.last_name') }}</label>

                            <div class="col-lg-12">
                                <input id="last-name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" autocomplete="last_name" placeholder="{{ trans('auth.last_name') }}" autofocus>

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row user-register-form hide">
                            <label for="email" class="col-lg-12 col-form-label text-md-right">{{ trans('auth.email_address') }}</label>

                            <div class="col-lg-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{ trans('auth.email_address') }}" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row user-register-form">
                            <label for="usesr_mobile_number" class="col-lg-12 col-form-label text-md-right hide required">{{ trans('auth.mobile_number') }}</label>

                            <div class="col-lg-12">
                                <input id="usesr_mobile_number" type="text" class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number" value="{{ old('mobile_number') }}" placeholder="{{ trans('auth.mobile_number') }} *" autocomplete="mobile_number" maxlength="10">

                                @error('mobile_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row user-register-form">
                            <label for="password" class="col-lg-12 col-form-label text-md-right required hide">{{ trans('auth.password') }}</label>

                            <div class="col-lg-12">
                                <input id="password-new" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ trans('auth.password') }} *" autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row user-register-form">
                            <label for="password-confirm" class="col-lg-12 col-form-label text-md-right hide required">{{ trans('auth.confirm_password') }}</label>

                            <div class="col-lg-12">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ trans('auth.confirm_password') }} *">
                            </div>
                        </div>

                       <!-- <div class="form-group row">
                           <label for="address" class="col-lg-12 col-form-label text-md-right required">{{ trans('auth.address') }}</label>
                           <div class="col-lg-12">
                               <textarea id="address" row="5" class="form-control @error('address') is-invalid @enderror" name="address"></textarea>
                           </div>
                       </div> -->
                       <div class="row user-register-form">
                           <label for="city" class="col-lg-12 col-form-label text-md-right hide required">{{ trans('messages.state') }}</label>
                           <div class="col-lg-12">
                               <select class="form-control search-state @error('state') is-invalid @enderror" name="user_state" id="state">
                                    <option value="">{{ trans('auth.select_state') }} *</option>
                                    @if(isset($states) && !empty($states))
                                        @foreach($states as $key => $state)
                                            <option value="{{ $state->code }}">{{ $state->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                           </div>
                       </div>
                       <div class="row user-register-form">
                            <label for="city" class="col-lg-12 col-form-label text-md-right hide required">{{ trans('messages.city')}} </label>
                            <div class="col-lg-12">
                                <select class="form-control city-drop-list @error('city') is-invalid @enderror" name="user_city" id="city" disabled="disabled">
                                    <option value="">{{ trans('messages.select_city') }} *</option>
                                    @if(isset($cities) && !empty($states))
                                        @foreach($cities as $key => $citie)
                                            <option value="{{ $citie->name }}">{{ $citie->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row user-register-form">
                            <label for="city" class="col-lg-12 col-form-label text-md-right hide required">{{ trans('auth.postal_code') }}</label>
                            <div class="col-lg-12">
                                <input id="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" value="{{ old('postal_code') }}" placeholder="{{ trans('auth.postal_code') }} *"maxlength="6">
                            </div>
                        </div>
                        <div class="row user-register-form">
                            <div class="col-md-12">
                                <div class="checkbox terms-conditions">
                                    <label for="terms-conditions">
                                        <input type="checkbox" id="terms-conditions" name="terms_conditions" class="@error('terms_conditions') is-invalid @enderror" required="required">
                                        <span class="cr"><i class="fa fa-check cr-icon" aria-hidden="true"></i></span> {{ trans('auth.i_agree') }} <a href="{{ route('terms.conditions') }}" target="_blank"> {{ trans('messages.terms_conditions') }}</a>
                                    </label>
                                </div>
                            </div>
                            <div class="terms-contion-error" id="terms-contion-error"></div>
                        </div>
                        <div class="form-group row mb-0 user-register-form">
                            <div class="col-lg-12 text-center">
                                <button type="submit" class="btn btn-primary register_btn">
                                    {{ trans('auth.register') }} <i class="fas fa-long-arrow-alt-right"></i>
                                </button>
                                <a class="btn btn-link login_url_btn" href="{{ route('register') }}">
                                    {{ trans('auth.user_have_account') }}
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
        //Similarly for mobile number
        $.validator.addMethod("mobileValidation",
            function(value, element) { return !value.match(/^(\d)\1+$/g); },
        "Mobile number is invalid");

        $("#register_form").validate({
            ignore: [],
            errorElement: 'span',
            rules: {
                first_name: "required",
                /*last_name: "required",*/
                email: {
                    //required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                password_confirmation: {
                    required: true,
                    minlength : 6,
                    equalTo: '#password-new',
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
                first_name: "{{ trans('auth.first_name_msg') }}",
                last_name: "{{ trans('auth.last_name_msg') }}",
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
                    error.insertAfter('#terms-contion-error');
                }else {
                    error.insertAfter(element);
                }
            }
        });

        $('#register_form').ajaxForm({
            url: base_url + 'register',
            beforeSend: function() {
                $('span.error').remove();
                $('#register_form .error').removeClass('error');
            },
            success: function(response) {
                $('.register-container .custom_error').addClass('hide');
                if (response.success) {
                    $('.register-container .custom_success').text(response.message).removeClass('hide');
                    setTimeout(function(){
                        $('.custom_success').addClass('hide'); 
                        window.location.href = response.redirect_url;
                    }, 2000);
                } else {
                    if (response.errors) {
                        $.each(response.errors, function(key, val) {
                            $("input[name="+key+"], select[name="+key+"]").addClass('error');
                            $("input[name="+key+"], select[name="+key+"]").after('<span for="'+key+'" generated="true" class="error">'+val[0]+'</span>');
                        });
                    } else {
                        $('.register-container .custom_error').text(response.message).removeClass('hide');
                    }
                }
            }
        });
    });
</script>
@endpush