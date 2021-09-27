@extends('admin.layouts.app')

@section('title', trans('common.partner_homes'))
@section('plugins.Datatables', true)
@section('plugins.Validation', true)

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1>{{ trans('common.partner_homes') }}</h1>

    @include('admin.partials.breadcrumbs', ['breadcrumbs' => [
      trans('common.partner_homes')=> route('admin.partners.homes'),
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
            <h3 class="card-title">{{ trans('common.partner_homes') }}</h3>
          </div>
          <form action="{{ route('admin.partners.homes.store') }}" method="post" class="partner_homes" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="card-body">
              <div class="row">
                <div class="col-lg-10">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="name">{{ trans('auth.name') }}<span class="required">&nbsp;*</span></label>
                        <input type="text" class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}" id="name" tabindex="1" name="name" placeholder="{{ trans('auth.home_name_placeholder') }}" value="">
                        <input type="hidden" name="partner_id" value="{{ $partner_id }}">
                        @if($errors->has('name'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="type">{{ trans('auth.facilities') }}<span class="required">&nbsp;*</span></label>
                        <select class="form-control {{ $errors->has('facility') ? 'is-invalid' : '' }}" id="facility" tabindex="3" name="facility[]" multiple>
                            <option value=''> -select- </option>
                            @if(!empty($facilities))
                            @foreach($facilities as $key => $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                            @endif
                        </select>
                        @if($errors->has('facility'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('facility') }}</strong>
                        </div>
                        @endif
                      </div>
                     
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="no_of_rooms">{{ trans('auth.number_of_rooms') }}<span class="required">&nbsp;*</span></label>
                        <input type="text" class="form-control {{ $errors->has('no_of_rooms') ? 'is-invalid' : '' }}" id="no_of_rooms" tabindex="2" name="no_of_rooms" placeholder="{{ trans('auth.no_of_rooms_placeholder') }}" value="">
                        @if($errors->has('no_of_rooms'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('no_of_rooms') }}</strong>
                        </div>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="other_facilities">{{ trans('auth.other_facilities') }}</label>
                        <textarea class="form-control {{ $errors->has('other_facilities') ? 'is-invalid' : '' }}" id="other_facilities" tabindex="4" name="other_facilities" placeholder="{{ trans('auth.other_facilities_available') }}"></textarea> 
                        @if($errors->has('other_facilities'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('other_facilities') }}</strong>
                        </div>
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="address">{{ trans('auth.address') }}<span class="required">&nbsp;*</span></label>
                        <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" id="address" tabindex="5" name="address" placeholder="{{ trans('auth.address_placeholder') }}"></textarea> 
                        @if($errors->has('address'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('address') }}</strong>
                        </div>
                        @endif
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="row form-group">
                        <div class="col-md-6">
                          <label for="address">{{ trans('auth.upload_photo') }}<span class="required">&nbsp;*</span></label>
                          <br>
                          <input type="file" class="{{ $errors->has('address') ? 'is-invalid' : '' }}" id="upload_photo" tabindex="6" name="upload_photo"> 
                          @if($errors->has('upload_photo'))
                          <div class="invalid-feedback">
                              <strong>{{ $errors->first('upload_photo') }}</strong>
                          </div>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Add Feature form date and To date -->
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="featured_from_date">{{ trans('auth.featured_from_date') }}</label>
                               <input type="text" class="form-control feature_date {{ $errors->has('featured_from_date') ? 'is-invalid' : '' }}" id="featured_from_date" tabindex="5" name="featured_from_date" placeholder="{{ trans('auth.featured_from_date') }}">
                              @if($errors->has('featured_from_date'))
                                  <div class="invalid-feedback">
                                      <strong>{{ $errors->first('featured_from_date') }}</strong>
                                  </div>
                              @endif
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="featured_to_date">{{ trans('auth.featured_to_date') }}</label>
                              <input type="text" class="form-control feature_date {{ $errors->has('featured_to_date') ? 'is-invalid' : '' }}" id="featured_to_date" tabindex="6" name="featured_to_date" placeholder="{{ trans('auth.featured_to_date') }}">
                              @if($errors->has('featured_to_date'))
                                  <div class="invalid-feedback">
                                      <strong>{{ $errors->first('featured_to_date') }}</strong>
                                  </div>
                              @endif
                          </div>
                      </div>
                  </div>
                  <!-- End Add Feature form date and To date -->
                  <!-- Add verified status -->
                  <div class="row">
                    <div class="col-md-6">
                      <label for="type">{{ trans('auth.verified') }}</label>
                      <select class="form-control {{ $errors->has('verified') ? 'is-invalid' : '' }}" id="verified" tabindex="7" name="verified">
                          @if(count($getVerifiedStatus) > 0)
                              @foreach($getVerifiedStatus as $key => $value)
                                  <option value="{{ $key }}">{{ $value }}</option>
                              @endforeach
                          @endif
                      </select>
                    </div>
                  </div>
                  <!--End Add verified status -->
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" tabindex="7" class="btn btn-primary">{{ trans('auth.submit') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
@stop

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
      
      $.validator.addMethod('greaterThan', function(value, element) {
        var dateFrom = $("#featured_from_date").val();
        var dateTo   = $('#featured_to_date').val();
        if (dateFrom) { return dateTo > dateFrom; } else{ return true; }
      }, 'Must be greater From Date');

      $(".partner_homes").validate({
        errorClass: "invalid-feedback",
        errorElement: "strong",
        rules: {
          name: {
            required: true,
            specialChars: true,
          }, 
          facility: "required",
          address: "required",
          upload_photo: "required",
          no_of_rooms: {
            required: true,
            number: true
          },
          featured_from_date:{
              required: function(){
                  var featureTo = $('#featured_to_date').val();
                  return featureTo ? true :false;
              }
          },
          featured_to_date: {
              greaterThan: "#featured_from_date", 
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
          facility: "{{ trans('auth.facility_msg') }}",
          address: "{{ trans('auth.address_msg') }}",
          no_of_rooms: {
            number: "{{ trans('auth.no_of_rooms_only_msg') }}",
            required: "{{ trans('auth.no_of_rooms_msg') }}"
          },
          upload_photo: "{{ trans('auth.upload_image_requried_msg') }}",
        },
        submitHandler: function(form) {
          form.submit();
        }
      });
      $('.feature_date').datepicker({
        format: 'dd-mm-yyyy',
        startDate: '-d',
        autoclose: true
      });

    });
  </script>
@stop