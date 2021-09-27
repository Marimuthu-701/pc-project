@php
    $resendLimit = config('textlocal.resend_limit');
@endphp
<div class="container partner-register-form">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="partner-form-title my-account-title">{{ trans('messages.my_account') }}</h3>
                </div>
                <div class="card-body">
                    <div class="custom_error alert alert-danger hide"></div>
                    <div class="custom_success alert alert-success hide"></div>
                    <form method="POST" action="{{ route('profile.update') }}" class="register_form" id="partner_register_form">
                        <input type="hidden" name="user_id" value="{{ $userInfo->id}}">
                        <input type="hidden" name="user_type" value="{{ $userInfo->type}}">
                        @csrf
                        @if($userType == App\Models\User::TYPE_PARTNER)
                            @if($serviceInfo)
                                <div class="form-group row">
                                    <div class="col-lg-12 col-xs-12 register-form-input profile-avatar">
                                        <div class="text-center avatar">
                                            <img src="{{ $avatar_url }}" alt="Avatar" class="avatar-img">
                                            <div class="middle">
                                                <div class="change-avatar">
                                                    <label for="profile_avatar">
                                                        <i class="fa fa-camera" aria-hidden="true"></i>&nbsp;Change Avatar
                                                        <input type="file" name="profile_avatar" id="profile_avatar" accept="image/x-png,image/jpeg">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else 
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="first_name" class="col-lg-6 col-form-label my-account-lable required">{{ trans('auth.first_name')}} </label>
                                  <input id="first_name" type="text" class="form-control @error('partner_email') is-invalid @enderror" name="first_name" value="{{ isset($userInfo->first_name) ? $userInfo->first_name : old('first_name') }}" autocomplete="first_name" placeholder="{{ trans('auth.first_name')}}">
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="last_name" class="col-lg-6 col-form-label my-account-lable">{{ trans('auth.last_name') }} </label>
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ isset($userInfo->last_name) ? $userInfo->last_name  :old('last_name') }}" placeholder="{{ trans('auth.last_name') }}" autocomplete="last_name" >
                            </div>
                        </div>
                        @endif
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="email" class="col-lg-6 col-form-label my-account-lable @if($userType == App\Models\User::TYPE_PARTNER) required @endif">{{ trans('auth.email_address') }} </label>
                                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ isset($userInfo->email) ? $userInfo->email : old('email') }}" placeholder="{{ trans('auth.email_address') }}" >
                            </div>
                            <div class="col-lg-5 col-xs-12 register-form-input">
                                <label for="mobile_number" class="col-lg-6 col-form-label my-account-lable required">{{ trans('auth.mobile_number') }} </label>
                                <input type="text" class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number"value="{{ isset($userInfo->mobile_number) ? $userInfo->mobile_number : old('mobile_number') }}" @if($userInfo->mobile_number) readonly="readonly" @endif>
                            </div>
                            <div class="col-lg-1 col-xs-12 mobile-change register-form-input">
                                <div class="mobile-change-div">
                                    <a href="javascript:void(0)" class="change-mobile-number">Change</a>
                                </div>
                            </div>
                        </div>
                        @if($userType == App\Models\User::TYPE_USER)
                        <div class="form-group row">
                            <div class="col-xs-12 col-lg-6 register-form-input">
                                <label for="state" class="col-lg-6 col-form-label my-account-lable required">{{ trans('messages.state') }} </label>
                                <select class="form-control search-state @error('partner_state') is-invalid @enderror" name="state" id="state">
                                    <option value="">{{ trans('auth.select_state') }}</option>
                                    @foreach($states as $key => $state)
                                        <option value="{{ $state->code }}" @if($userInfo->state == $state->code) selected="selected" @endif>{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xs-12 col-lg-6 register-form-input">
                                <label for="city" class="col-lg-6 col-form-label my-account-lable required">{{ trans('auth.city') }} </label>
                                <select class="form-control city-drop-list @error('partner_city') is-invalid @enderror" name="city" id="city">
                                    <option value="">{{ trans('messages.select_city') }}</option>
                                    @foreach($cities as $key => $citie)
                                        <option value="{{ $citie->name }}" @if($userInfo->city == $citie->name) selected="selected" @endif >{{ $citie->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="form-group row">
                            @if($userType != App\Models\User::TYPE_PARTNER)
                                <div class="col-lg-6 col-xs-12 register-form-input">
                                    <label for="postal_code" class="col-lg-6 col-form-label my-account-lable required">{{ trans('auth.postal_code') }} </label>
                                    <input id="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" value="{{ isset($userInfo->postal_code) ? $userInfo->postal_code : old('postal_code') }}" autocomplete="postal_code" placeholder="{{ trans('auth.postal_code') }}" maxlength="6">
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12 change-password">
                                <h4>{{ trans('messages.change_password') }}</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                 <label for="old_password" class="col-lg-6 col-form-label my-account-lable">{{ trans('messages.old_password') }} </label>
                                <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" placeholder="{{ trans('messages.old_password') }} ">
                            </div>

                            <div class="col-lg-6 col-xs-12 register-form-input">
                                 <label for="new_password" class="col-lg-6 col-form-label my-account-lable">{{ trans('messages.new_password') }} </label>
                                <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" placeholder="{{ trans('messages.new_password') }} ">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <button type="submit" class="btn btn-primary register_btn">
                                    &nbsp;&nbsp;&nbsp;{{ trans('messages.update') }}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i>
                                </button>
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input"></div>
                        </div>
                    </form>
                    <hr class="my-account-separator">
                    @if (Auth::check())
                        @include('partials.account-delete')
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@include('partials.mobile-number-change')
@push('script')
<script>
    $(document).ready(function() {
        var extension = ['jpeg', 'jpg', 'png'];
        $('#profile_avatar').on('change',function(){
        var file_name = $(this).val();
        var fileType  = file_name.replace(/^.*\./, '').toLowerCase();
        if (jQuery.inArray(fileType, extension) == -1){
            alert("{{ trans('messages.avator_format_validation') }}");
            return false;
        }

        $.validator.addMethod("alpha", function(value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z\s\.\&\_\/\'\-]+$/);
        },"Letters and space &./_'- only please");

        // upload image show
        if (this.files && this.files[0]) {
            $('.avatar-img').attr('src', '').hide();
            var reader = new FileReader();
            $(reader).load(function(e) {
                $('.avatar-img').attr('src', e.target.result);
            });
            reader.readAsDataURL(this.files[0]);
            $('.avatar-img').load(function(e) {
                $(this).show();
                }).hide();
            }
        });

        $("#partner_register_form").validate({
            errorElement: 'span',
            rules: {
                first_name:{
                    required: true,
                    alpha: true,
                    maxlength:50,
                },
                last_name:{
                    alpha: true,
                    maxlength:50,  
                },
                partner_business_name:{
                    required: true,
                },
                email: {
                    required: function(){
                        var user_type = $("input[name='user_type']").val();
                        return user_type != "user" ? true : false;
                    },
                    email: true
                },
                old_password: {
                    required: function(){
                        var new_password = $('#new_password').val();
                        return new_password ? true : false;
                    },
                    minlength: 6
                },
                new_password: {
                    required: function(){
                        var old_password = $('#old_password').val();
                        return old_password ? true : false;
                    },
                  minlength: 6  
                },
                mobile_number: {
                    required: true,
                    minlength:10,
                    maxlength:10,
                    number: true
                },
                state:{
                    required:true,
                },
                city:{
                    required:true,
                },
                postal_code:{
                    required:true,
                    minlength: 6,
                    digits: true
                },
                address:{
                    required:true,
                },
                profile_avatar:{
                    accept:"jpg,png,jpeg",
                    extension: "jpeg|jpg|png",
                }
            },
            messages: {
                partner_business_name: "{{trans('auth.partner_business_name') }}",
                password: {
                    required: "{{trans('auth.partner_psw_required') }}",
                    minlength: "{{trans('auth.partner_psw_length') }}",
                },
                email: "{{trans('auth.partner_email') }}",
                mobile_number: {
                    required:"{{trans('auth.partner_mobile_number_required') }}",
                    number: "{{trans('auth.partner_mobile_number_number') }}",
                    numberRange: "{{trans('auth.partner_mobile_number_length') }}",
                },
                postal_code: {
                    required:"{{trans('auth.postal_code_required') }}",
                    minlength:"{{trans('auth.postal_code_length') }}",
                    digits:"{{trans('auth.postal_code_number') }}"
                },
                profile_avatar:{
                    extension:"{{ trans('messages.avator_format_validation') }}",
                    accept:"{{ trans('messages.avator_format_validation') }}",
                }
            }
        });

        $('#partner_register_form').ajaxForm({
            url: base_url + 'profile/update',
            beforeSend: function() {
                $('.register_btn i').removeClass('fa-long-arrow-alt-right');
                $('.register_btn i').addClass('fa-spinner fa-spin');
                $('.register_btn').prop('disabled', true);
                $('span.error').remove();
                $('#partner_register_form .error').removeClass('error');
            },
            success: function(response) {
                $('.register_btn').prop('disabled', false);
                $('.register_btn i').removeClass('fa-spinner fa-spin');
                $('.register_btn i').addClass('fa-long-arrow-alt-right');
                $('.partner-register-form .custom_error').addClass('hide');
                if (response.success) {
                    $('.partner-register-form .custom_success').text(response.message).removeClass('hide')
                        setTimeout(function(){
                            $('.custom_success').addClass('hide');
                        },2000);
                } else {
                    if (response.errors) {
                        $.each(response.errors, function(key, val) {
                            $("input[name="+key+"], select[name="+key+"], textarea[name="+key+"]").addClass('error');
                            $("input[name="+key+"], select[name="+key+"], textarea[name="+key+"]").after('<span for="'+key+'" generated="true" class="error">'+val[0]+'</span>');
                        });
                    }else {
                        $('.partner-register-form .custom_error').text(response.message).removeClass('hide');
                    }
                }
            }
        });

        $(document).on('click', '.account-delete-btn', function(){
            $('#delete-account').modal('show');
        });

        $("#account-delete-email").validate({
            errorElement: 'span',
            rules: {
                reason:{
                    required:true,
                },
            }
        });

        $('#account-delete-email').ajaxForm({
            url: base_url + 'account-delete-email',
            beforeSend: function() {
                $('.ok-btn i').removeClass('fa-long-arrow-alt-right');
                $('.ok-btn i').addClass('fa-spinner fa-spin');
                $('.ok-btn').prop('disabled', true);
                $('span.error').remove();
                $('#account-delete-email .error').removeClass('error');
            },
            success: function(response) {
                $('.ok-btn i').addClass('fa-long-arrow-alt-right');
                $('.ok-btn i').removeClass('fa-spinner fa-spin');
                $('#account-delete-email .custom_error').addClass('hide');
                if (response.success) {
                    $('.ok-btn').addClass('hide');
                    $('#account-delete-email .custom_success').text(response.message).removeClass('hide')
                        setTimeout(function(){
                            window.location.href = response.redirect_url;
                            $('.custom_success').addClass('hide');
                        },1500);
                } else {
                    $('.ok-btn').prop('disabled', false);
                    if (response.errors) {
                        $.each(response.errors, function(key, val) {
                            $("textarea[name="+key+"]").addClass('error');
                            $("textarea[name="+key+"]").after('<span for="'+key+'" generated="true" class="error">'+val[0]+'</span>');
                        });
                    }else {
                        $('#account-delete-email .custom_error').text(response.message).removeClass('hide');
                    }
                }
            }
        });
    });
</script>
@endpush