@extends('admin.layouts.app')

@section('title', trans('common.users'))
@section('plugins.Datatables', true)
@section('plugins.Validation', true)

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1>{{ trans('common.users') }}</h1>

    @include('admin.partials.breadcrumbs', ['breadcrumbs' => [
      trans('common.users')=> route('admin.users.index'),
      trans('common.add'),

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
            <h3 class="card-title">{{ trans('auth.users_add') }}</h3>
          </div>
          <form action="{{ route('admin.users.store') }}" method="post" class="users">
            {{ csrf_field() }}
            <div class="card-body">
              <div class="row">
                <div class="col-lg-10">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="first_name">{{ trans('auth.first_name') }}<span class="required">&nbsp;*</span></label>
                        <input type="text" class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" id="first_name" name="first_name" placeholder="{{ trans('auth.first_name_placeholder') }}" tabindex="1" @if($errors->has('first_name')) value="{{ old('first_name') }}" @endif>
                        @if($errors->has('first_name'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </div>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="email">{{ trans('auth.email') }}</label>
                        <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" tabindex="3" placeholder="{{ trans('auth.email_placeholder') }}" autocomplete="off" @if($errors->has('email')) value="{{ old('email') }}" @endif>
                        @if($errors->has('email'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="password">{{ trans('auth.password') }}<span class="required">&nbsp;*</span></label>
                        <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password" name="password" tabindex="5" placeholder="{{ trans('auth.password_placeholder') }}" autocomplete="off">
                        @if($errors->has('password'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </div>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="status">{{ trans('auth.status') }}<span class="required">&nbsp;*</span></label>
                        <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" id="status" name="status" tabindex="7">
                          @foreach($userStatus as $key => $value)
                            <option value="{{ $key }}" @if(!empty(old('status')) && ($key == old('status'))) selected @endif>{{ $value }}</option>
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
                        <label for="last_name">{{ trans('auth.last_name') }}</label>
                        <input type="text" class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" id="last_name" name="last_name" tabindex="2" placeholder="{{ trans('auth.last_name_placeholder') }}" @if($errors->has('last_name')) value="{{ old('last_name') }}" @endif>
                        @if($errors->has('last_name'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </div>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="mobile">{{ trans('auth.mobile') }}<span class="required">&nbsp;*</span></label>
                        <input type="text" class="form-control {{ $errors->has('mobile_number') ? 'is-invalid' : '' }}" id="mobile_number" name="mobile_number" tabindex="3" placeholder="{{ trans('auth.mobile_number_placeholder') }}" @if($errors->has('mobile_number')) value="{{ old('mobile_number') }}" @endif>
                        @if($errors->has('mobile_number'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('mobile_number') }}</strong>
                        </div>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="confirm_password">{{ trans('auth.confirm_password') }}<span class="required">&nbsp;*</span></label>
                        <input type="password" class="form-control {{ $errors->has('confirm_password') ? 'is-invalid' : '' }}" id="confirm_password" name="confirm_password" tabindex="6" placeholder="{{ trans('auth.confirm_password_placeholder') }}" autocomplete="off">
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

      $(".users").validate({
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
          mobile_number: {
            required: true,
            minlength: 10,
            number: true
          },
          password: {
            minlength: 5
          },
          confirm_password: {
            equalTo: "#password"
          }
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
          mobile_number: {
            number: "{{ trans('auth.mobile_number_msg') }}",
            minlength: "{{ trans('auth.mobile_lenght_msg') }}"
          },
          password: {
            required: "{{ trans('auth.password_required_msg') }}",
            minlength: "{{ trans('auth.password_lengh_msg') }}"
          },
          status: "{{ trans('auth.status_msg') }}"
        },
        submitHandler: function(form) {
          form.submit();
        }
      });
    });
  </script>
@stop

@stop
