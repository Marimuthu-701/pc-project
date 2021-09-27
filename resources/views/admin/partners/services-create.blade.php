@extends('admin.layouts.app')

@section('title', trans('common.partner_services'))
@section('plugins.Datatables', true)
@section('plugins.Validation', true)

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1>{{ trans('common.partner_services') }}</h1>

    @include('admin.partials.breadcrumbs', ['breadcrumbs' => [
      trans('common.partner_services')=> route('admin.partners.services'),
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
            <h3 class="card-title">{{ trans('common.partner_services') }}</h3>
          </div>
          <form action="{{ route('admin.partners.services.store') }}" method="post" class="partner_details" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="card-body">
              <div class="row">
                <div class="col-lg-10">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="type">{{ trans('auth.service_name') }}<span class="required">&nbsp;*</span></label>
                        <input type="hidden" name="partner_id" value="{{ $partner_id }}">
                        <select class="form-control {{ $errors->has('services') ? 'is-invalid' : '' }}" id="services" tabindex="1" name="services">
                            <option value=''> -select- </option>
                            @if(!empty($services))
                            @foreach($services as $key => $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                            @endif
                        </select>
                        @if($errors->has('services'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('services') }}</strong>
                        </div>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="father_name">{{ trans('auth.father_name') }}<span class="required">&nbsp;*</span></label>
                        <input type="text" class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}" id="father_name" tabindex="3" name="father_name" placeholder="{{ trans('auth.father_name_placeholder') }}" value="">
                        @if($errors->has('father_name'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('father_name') }}</strong>
                        </div>
                        @endif
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="name">{{ trans('auth.name') }}<span class="required">&nbsp;*</span></label>
                        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" tabindex="2" name="name" placeholder="{{ trans('auth.partner_name_placeholder') }}" value="">
                        @if($errors->has('name'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="qualification">{{ trans('auth.qualification') }}<span class="required">&nbsp;*</span></label>
                        <input type="text" class="form-control {{ $errors->has('qualification') ? 'is-invalid' : '' }}" id="qualification" tabindex="4" name="qualification" placeholder="{{ trans('auth.qualification_placeholder') }}" value="">
                        @if($errors->has('qualification'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('qualification') }}</strong>
                        </div>
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="row form-group">
                        <div class="col-md-6">
                          <label for="year_of_passing">{{ trans('auth.qualification_certificate') }}</label>
                          <input type="file" class="{{ $errors->has('qualification_certificate') ? 'is-invalid' : '' }}" id="qualification_certificate" tabindex="5" name="qualification_certificate" value="">
                          @if($errors->has('qualification_certificate'))
                          <div class="invalid-feedback">
                              <strong>{{ $errors->first('qualification_certificate') }}</strong>
                          </div>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="dob">{{ trans('auth.dob') }}</label>
                        <input type="text" class="form-control {{ $errors->has('dob') ? 'is-invalid' : '' }}" id="dob" tabindex="6" name="dob"  placeholder="{{ trans('auth.dob_placeholder') }}" value="">
                        @if($errors->has('dob'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('dob') }}</strong>
                        </div>
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="year_of_passing">{{ trans('auth.year_of_passing') }}<span class="required">&nbsp;*</span></label>
                        <select class="form-control {{ $errors->has('year_of_passing') ? 'is-invalid' : '' }}" id="year_of_passing" tabindex="7" name="year_of_passing">
                          <option value=''> -select- </option>
                          @if(!empty($yearofpassing))
                            @foreach($yearofpassing as $key => $value)
                              <option value="{{ $value }}">{{ $value }}</option>
                            @endforeach
                          @endif
                        </select>
                        @if($errors->has('year_of_passing'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('year_of_passing') }}</strong>
                        </div>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="working_at">{{ trans('auth.currently_working_at') }}<span class="required">&nbsp;*</span></label>
                        <input type="text" class="form-control {{ $errors->has('working_at') ? 'is-invalid' : '' }}" id="working_at" tabindex="9" name="working_at" placeholder="{{ trans('auth.working_at_placeholder') }}" value="">
                        @if($errors->has('working_at'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('working_at') }}</strong>
                        </div>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="total_year_of_exp">{{ trans('auth.total_year_of_exp') }}<span class="required">&nbsp;*</span></label>
                        <input type="text" class="form-control {{ $errors->has('total_experience') ? 'is-invalid' : '' }}" id="total_experience" tabindex="11" name="total_experience" placeholder="{{ trans('auth.total_experience_placeholder') }}" value="">
                        @if($errors->has('total_experience'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('total_experience') }}</strong>
                        </div>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="charges">{{ trans('auth.charges') }}<span class="required">&nbsp;*</span></label>
                        <input type="text" class="form-control {{ $errors->has('total_year_of_exp') ? 'is-invalid' : '' }}" id="charges" tabindex="13" name="charges" placeholder="{{ trans('auth.charges_placeholder') }}" value="">
                        @if($errors->has('charges'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('charges') }}</strong>
                        </div>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="current_address">{{ trans('auth.current_address') }}<span class="required">&nbsp;*</span></label>
                        <textarea class="form-control {{ $errors->has('current_address') ? 'is-invalid' : '' }}" id="current_address" placeholder="{{ trans('auth.current_address_placeholder') }}" tabindex="15" name="current_address"></textarea>
                        @if($errors->has('current_address'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('current_address') }}</strong>
                        </div>
                        @endif
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="college_name">{{ trans('auth.name_of_the_college') }}<span class="required">&nbsp;*</span></label>
                        <input type="text" class="form-control {{ $errors->has('college_name') ? 'is-invalid' : '' }}" id="name_of_the_college" tabindex="7" name="college_name" placeholder="{{ trans('auth.college_name_placeholder') }}" value="">
                        @if($errors->has('college_name'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('college_name') }}</strong>
                        </div>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="specialization_area">{{ trans('auth.area_of_specialization') }}<span class="required">&nbsp;*</span></label>
                        <input type="text" class="form-control {{ $errors->has('specialization_area') ? 'is-invalid' : '' }}" id="specialization_area" tabindex="10" name="specialization_area" placeholder="{{ trans('auth.specialization_area_placeholder') }}" value="">
                        @if($errors->has('specialization_area'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('specialization_area') }}</strong>
                        </div>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="shift_timings">{{ trans('auth.preferred_shift_time') }}<span class="required">&nbsp;*</span></label>
                        <select class="form-control {{ $errors->has('shift_timings') ? 'is-invalid' : '' }}" id="shift_timings" tabindex="12" name="shift_timings">
                          <option value=''> -select- </option>
                          @if(!empty($preferredShiftTime))
                            @foreach($preferredShiftTime as $key => $value)
                              <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                          @endif
                        </select>
                        @if($errors->has('shift_timings'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('shift_timings') }}</strong>
                        </div>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="additional_info">{{ trans('auth.any_additional_info') }}</label>
                        <textarea class="form-control {{ $errors->has('additional_info') ? 'is-invalid' : '' }}" id="additional_info" tabindex="14" name="additional_info" placeholder="{{ trans('auth.additional_info_placeholder') }}"></textarea> 
                        @if($errors->has('any_additional_info'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('any_additional_info') }}</strong>
                        </div>
                        @endif
                      </div>
                      <!-- Add Feature form date and To date -->
                      <div class="form-group">
                          <label for="featured_from_date">{{ trans('auth.featured_from_date') }}</label>
                           <input type="text" class="form-control feature_date {{ $errors->has('featured_from_date') ? 'is-invalid' : '' }}" id="featured_from_date" tabindex="5" name="featured_from_date" placeholder="{{ trans('auth.featured_from_date') }}">
                          @if($errors->has('featured_from_date'))
                              <div class="invalid-feedback">
                                  <strong>{{ $errors->first('featured_from_date') }}</strong>
                              </div>
                          @endif
                      </div>
                      <!-- End Add Feature form date and To date -->
                    </div>
                  </div>
                  <!-- Add Feature form date and To date -->
                    <div class="row">
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
                    <!-- End Add Feature form date and To date -->
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" tabindex="16" class="btn btn-primary">{{ trans('auth.submit') }}</button>
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

      $(".partner_details").validate({
        errorClass: "invalid-feedback",
        errorElement: "strong",
        rules: {
          services: "required",
          name: {
            specialChars: "{{ trans('auth.alphanumeric_error_msg') }}",
            required: "{{ trans('auth.name_msg') }}"
          },
          father_name: "required",
          working_at: "required",
          /*dob: "required",*/
          qualification: "required",
          year_of_passing: "required",
          college_name: "required",
          specialization_area: "required",
          total_experience: "required",
          shift_timings: "required",
          charges: "required",
          current_address: "required",
          /*qualification_certificate: "required", */
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
          services: "{{ trans('auth.services_msg') }}",
          father_name: "{{ trans('auth.father_name_msg') }}",
          dob: "{{ trans('auth.dob_msg') }}",
          qualification: "{{ trans('auth.qualification_msg') }}",
          year_of_passing: "{{ trans('auth.year_of_passing_msg') }}",
          college_name: "{{ trans('auth.college_name_msg') }}",
          specialization_area: "{{ trans('auth.specialization_area_msg') }}",
          total_experience: "{{ trans('auth.total_experience_msg') }}",
          shift_timings: "{{ trans('auth.shift_timings_msg') }}",
          charges: "{{ trans('auth.charges_msg') }}",
          working_at: "{{ trans('auth.working_at_msg') }}",
          current_address: "{{ trans('auth.current_address_msg') }}",
          qualification_certificate: "{{ trans('auth.qualification_certificate_error_msg')}}" 
        },
        submitHandler: function(form) {
          form.submit();
        }
      });

      $('#dob').datepicker({
        format: 'dd-mm-yyyy',
        endDate: '+0d',
        autoclose: true
      });
      
     $('.feature_date').datepicker({
          format: 'dd-mm-yyyy',
          startDate: '-d',
          autoclose: true
      });

    });
  </script>
@stop