@extends('admin.layouts.app')

@section('title', 'Profile')
@section('plugins.Datatables', true)
@section('plugins.Validation', true)

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1>{{ trans('common.users') }}</h1>

    @include('admin.partials.breadcrumbs', ['breadcrumbs' => [
      trans('common.users')=> route('admin.users.index'),
      trans('common.edit'),

    ]])
    
  </div>
</div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">          
          @include('flash::message')
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 profile_container">
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ trans('common.users') }}</h3>
            </div>
            <form action="{{ route('admin.users.update', $users->id) }}" method="post" class="user_details">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">{{ trans('auth.name') }}<span class="required">&nbsp;*</span></label>
                                        <input type="text" class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" id="first_name" tabindex="1" name="first_name" placeholder="{{ trans('auth.name') }}" value="{{ $users->first_name }}">
                                        @if($errors->has('first_name'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">{{ trans('auth.email') }}<span class="required">&nbsp;*</span></label>
                                        <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" tabindex="3" name="email" placeholder="{{ trans('auth.email_placeholder') }}" value="{{ $users->email }}">
                                        @if($errors->has('email'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" name="last_name">
                                        <label for="mobile_number">{{ trans('auth.mobile') }}<span class="required">&nbsp;*</span></label>
                                        <input type="text" class="form-control {{ $errors->has('mobile_number') ? 'is-invalid' : '' }}" id="mobile_number" tabindex="4" name="mobile_number" placeholder="{{ trans('auth.mobile_number_placeholder') }}" value="{{ $users->mobile_number }}">
                                        @if($errors->has('mobile_number'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('mobile_number') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state">{{ trans('auth.state') }}<span class="required">&nbsp;*</span></label>
                                        <select class="form-control search-state {{ $errors->has('state') ? 'is-invalid' : '' }}" id="state" tabindex="7" name="state">
                                        <option value="">Select State</option>
                                          @foreach($states as $key => $value)
                                            <option value="{{ $value->code }}" @if($value->code == $users->state) selected @endif  >{{ $value->name }}</option>
                                          @endforeach
                                        </select>
                                        @if($errors->has('state'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('state') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">{{ trans('auth.city') }}<span class="required">&nbsp;*</span></label>
                                        <select class="form-control city-drop-list {{ $errors->has('status') ? 'is-invalid' : '' }}" id="city" tabindex="7" name="city">
                                            <option value="">Select City</option>
                                          @foreach($cities as $key => $value)
                                            <option value="{{ $value->name }}" @if($value->name == $users->city) selected @endif  >{{ $value->name }}</option>
                                          @endforeach
                                        </select>
                                        @if($errors->has('city'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('city') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">{{ trans('auth.postal_code') }}<span class="required">&nbsp;*</span></label>
                                        <input type="text" class="form-control" name="postal_code" value="{{$users->postal_code}}" maxlength="6">
                                        @if($errors->has('postal_code'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('postal_code') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">{{ trans('auth.status') }}<span class="required">&nbsp;*</span></label>
                                        <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" id="status" tabindex="7" name="status">
                                          @foreach($userStatus as $key => $value)
                                            <option value="{{ $key }}" @if($key == $users->status) selected @endif  >{{ $value }}</option>
                                          @endforeach
                                        </select>
                                        @if($errors->has('status'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('status') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">{{ trans('auth.password') }}</label>
                                        <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password" tabindex="5" name="password" placeholder="{{ trans('auth.password_placeholder') }}">
                                        @if($errors->has('password'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="confirm_password">{{ trans('auth.confirm_password') }}</label>
                                        <input type="password" class="form-control {{ $errors->has('confirm_password') ? 'is-invalid' : '' }}" id="confirm_password" tabindex="6" name="confirm_password" placeholder="{{ trans('auth.confirm_password_placeholder') }}">
                                        @if($errors->has('confirm_password'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('confirm_password') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                  <a href="{{URL::previous()}}"  class="btn btn-secondary">{{ trans('common.back') }}</a>
                  <button type="submit" tabindex="8" class="btn btn-primary">{{ trans('auth.submit') }}</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@section('js')
  <script>
    $(function() {
      $.validator.addMethod("specialChars", function( value, element ) {
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        var key = value;

        if (!regex.test(key)) {
           return false;
        }
        return true;
    }, "please use only alphabetic characters");
      
      $(".user_details").validate({
        errorClass: "invalid-feedback",
        errorElement: "strong",
        rules: {
          first_name:{
            required: true,
            specialChars: true,
          },
          email: {
            email: true
          },
          mobile: {
            required: true,
            minlength: 10,
            number: true
          },
          password: {
            minlength: 5
          },
          confirm_password: {
            equalTo: "#password"
          },
          state:{
            required:true,
        },
        city:{
            required:true,
        },
        postal_code:{
            required:true,
            minlength:6,
            maxlength:6,
            number: true,
        },
        },
        highlight: function(element) {
          $(element).addClass("is-invalid");
        },
        unhighlight: function(element) {
          $(element).removeClass("is-invalid");
        },
        messages: {
          first_name: {
            specialChars: "{{ trans('auth.alphanumeric_error_msg') }}",
            required: "{{ trans('auth.first_name_msg') }}"
          },
          email: "{{ trans('auth.user_email_msg') }}",
          mobile: {
            number: "{{ trans('auth.mobile_number_msg') }}",
            minlength: "{{ trans('auth.mobile_lenght_msg') }}"
          },
          password: {
            required: "{{ trans('auth.password_required_msg') }}",
            minlength: "{{ trans('auth.password_lengh_msg') }}"
          }
        },
        submitHandler: function(form) {
          form.submit();
        }
      });
    });
  </script>
@stop

@stop
