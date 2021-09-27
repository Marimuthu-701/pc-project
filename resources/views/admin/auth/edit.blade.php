@extends('admin.layouts.app')

@section('title', 'Profile')
@section('plugins.Datatables', true)
@section('plugins.Validation', true)
@section('content_header')
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">          
          @include('flash::message')
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 profile_container">
          <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{ trans('admin.profile') }}</h3>
          </div>
          <form action="{{ route('admin.profile.update') }}" method="post" class="user_profile">
            {{ csrf_field() }}
            <div class="card-body">
              <div class="row">
                <div class="col-lg-10">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="first_name">{{ trans('auth.first_name') }}</label>
                        <input type="text" class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" id="first_name" name="first_name" placeholder="{{ trans('auth.first_name_placeholder') }}" value="{{ $user->first_name }}">
                        @if($errors->has('first_name'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </div>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="email">{{ trans('auth.email') }}</label>
                        <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" placeholder="{{ trans('auth.email_placeholder') }}" value="{{ $user->email }}">
                        @if($errors->has('email'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                        @endif
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="last_name">{{ trans('auth.last_name') }}</label>
                        <input type="text" class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" id="last_name" name="last_name" placeholder="{{ trans('auth.last_name_placeholder') }}" value="{{ $user->last_name }}">
                        @if($errors->has('last_name'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </div>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-10">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="password">{{ trans('auth.password') }}</label>
                        <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password" name="password" placeholder="{{ trans('auth.password_placeholder') }}">
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
                        <input type="password" class="form-control {{ $errors->has('confirm_password') ? 'is-invalid' : '' }}" id="confirm_password" name="confirm_password" placeholder="{{ trans('auth.confirm_password_placeholder') }}">
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
              <button type="submit" class="btn btn-primary">{{ trans('auth.submit') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
@section('js')
  <script>
    $(function() {
      $(".user_profile").validate({
        errorClass: "invalid-feedback",
        errorElement: "strong",
        rules: {
          first_name: "required",
          last_name: "required",
          email: {
            required: true,
            email: true
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
          first_name: "{{ trans('auth.first_name_msg') }}",
          last_name: "{{ trans('auth.last_name_msg') }}",
          password: {
            required: "{{ trans('auth.password_required_msg') }}",
            minlength: "{{ trans('auth.password_lengh_msg') }}"
          },
          email: "{{ trans('auth.user_email_msg') }}"
        },
        submitHandler: function(form) {
          form.submit();
        }
      });
    });
  </script>
@stop

@stop
