@extends('admin.layouts.app')
@section('title', trans('common.partners'))
@section('plugins.Datatables', true)
@section('plugins.Validation', true)
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>{{ trans('common.partners') }}</h1>
        @include('admin.partials.breadcrumbs', ['breadcrumbs' => [
            trans('common.partners')=> route('admin.partners.index'),
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
                <h3 class="card-title">{{ trans('common.partners') }}</h3>
            </div>
            <form action="{{ route('admin.partners.update', $partner->id) }}" method="post" class="partner_details">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ trans('auth.name') }}<span class="required">&nbsp;*</span></label>
                                        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" tabindex="1" name="name" placeholder="{{ trans('auth.partner_name_placeholder') }}" value="{{ $partner->name }}">
                                        @if($errors->has('name'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="email">{{ trans('auth.email') }}<span class="required">&nbsp;*</span></label>
                                        <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" tabindex="3" name="email" placeholder="{{ trans('auth.email_placeholder') }}" value="{{ $partner->user->email }}">
                                        @if($errors->has('email'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="type">{{ trans('auth.state') }}<span class="required">&nbsp;*</span></label>
                                        <select class="form-control search-state {{ $errors->has('state') ? 'is-invalid' : '' }}" id="state" tabindex="5" name="state">
                                            <option value=''> -select- </option>
                                            @if(!empty($state))
                                            @foreach($state as $key => $value)
                                                <option value="{{ $value->code }}" @if($value->code == $partner->state) selected @endif  >{{ $value->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @if($errors->has('state'))
                                            <div class="invalid-feedback">
                                            <strong>{{ $errors->first('state') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="postal_code">{{ trans('auth.postal_code') }}<span class="required">&nbsp;*</span></label>
                                        <input type="text" class="form-control {{ $errors->has('postal_code') ? 'is-invalid' : '' }}" id="postal_code" tabindex="7" name="postal_code" placeholder="{{ trans('auth.postal_code_placeholder') }}" value="{{ $partner->postal_code }}">
                                        @if($errors->has('postal_code'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('postal_code') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="status">{{ trans('auth.status') }}<span class="required">&nbsp;*</span></label>
                                            <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" id="status" tabindex="9" name="status">
                                            @if(!empty($partnerStatus))
                                                @foreach($partnerStatus as $key => $value)
                                                    <option value="{{ $key }}" @if($key == $partner->user->status) selected @endif  >{{ $value }}</option>
                                                @endforeach
                                            @endif
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
                                        <label for="mobile">{{ trans('auth.mobile') }}<span class="required">&nbsp;*</span></label>
                                        <input type="text" class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" id="mobile" tabindex="2" name="mobile" placeholder="{{ trans('auth.mobile_number_placeholder') }}" value="{{ $partner->user->mobile_number }}">
                                        @if($errors->has('city'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('mobile') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="partnertype">{{ trans('auth.partnertype') }}<span class="required">&nbsp;*</span></label>
                                        <input type="text" class="form-control {{ $errors->has('partnertype') ? 'is-invalid' : '' }}" id="partnertype" tabindex="4" name="partnertype" placeholder="{{ trans('auth.partnertype_placeholder') }}" value="{{ $partner->type }}" readonly="readonly">
                                        @if($errors->has('partnertype'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('partnertype') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="city">{{ trans('auth.city') }}<span class="required">&nbsp;*</span></label>
                                        <select class="form-control city-drop-list {{ $errors->has('city') ? 'is-invalid' : '' }}" id="city" tabindex="8" name="city">
                                            <option value="">-Select-</option>
                                            @if(count($cities) > 0)
                                                @foreach($cities as $key => $value)
                                                <option value="{{ $value->name }}" @if($partner->city == $value->name ) selected @endif>{{ $value->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="about">{{ trans('auth.about') }}</label>
                                        <textarea class="form-control {{ $errors->has('about') ? 'is-invalid' : '' }}" id="about" tabindex="8" name="about" placeholder="{{ trans('auth.textarea_placeholder') }}">{{ $partner->about }}</textarea> 
                                        @if($errors->has('about'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('about') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" tabindex="9" class="btn btn-primary">{{ trans('auth.submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@section('js')
  <script>
    $(function() {
      $.validator.addMethod("specialChars", function( value, element ) {
            var regex = new RegExp("^[a-zA-Z0-9_ ]+$");
            var key = value;

            if (!regex.test(key)) {
               return false;
            }
            return true;
      }, "please use only alphabetic characters");

      $(".partner_details").validate({
        errorClass: "invalid-feedback",
        errorElement: "strong",
        rules: {
          name: {
            required: true,
            specialChars: true
          }, 
          partnertype:"required",
          email: {
            required: true,
            email: true
          },
          status:"required",
          mobile: {
            required: true,
            minlength: 10,
            number: true
          },
          state: "required",
          city: "required",
          postal_code: {
            required: true,
            maxlength: 6,
            number: true
          }
        },
        highlight: function(element) {
          $(element).addClass("is-invalid");
        },
        unhighlight: function(element) {
          $(element).removeClass("is-invalid");
        },
        messages: {
          name: {
            specialChars: "{{ trans('auth.alphanumeric_error_msg') }}",
            required: "{{ trans('auth.name_msg') }}"
          },
          status: "{{ trans('auth.status_msg') }}",
          partnertype: "{{ trans('auth.partertype_msg') }}",
          mobile: {
            required: "{{ trans('auth.mobile_requried_msg') }}",
            number: "{{ trans('auth.mobile_number_msg') }}",
            minlength: "{{ trans('auth.mobile_lenght_msg') }}"
          },
          email: "{{ trans('auth.user_email_msg') }}",
          state: "{{ trans('auth.partner_state') }}",
          city: "{{ trans('auth.partner_city') }}",
          postal_code: {
            required: "{{ trans('auth.postal_code_required') }}",
            maxlength: "{{ trans('auth.postal_code_length') }}",
            number: "{{ trans('auth.postal_code_number') }}"
            
          },
        },
        submitHandler: function(form) {
          form.submit();
        }
      });
    });
  </script>
@stop

@stop
