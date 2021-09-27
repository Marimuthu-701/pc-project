@extends('admin.layouts.app')

@section('title', 'Profile')
@section('plugins.Datatables', true)
@section('plugins.Validation', true)

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1>{{ trans('common.facilities') }}</h1>

    @include('admin.partials.breadcrumbs', ['breadcrumbs' => [
      trans('common.facilities')=> route('admin.facilities.index'),
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
            <h3 class="card-title">{{ trans('auth.facilities_add') }}</h3>
          </div>
          <form action="{{ route('admin.facilities.store') }}" method="post" class="facilities">
            {{ csrf_field() }}
            <div class="card-body">
              <div class="row">
                <div class="col-lg-10">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="first_name">{{ trans('auth.name') }}</label>
                        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="first_name" tabindex="1" name="name" placeholder="{{ trans('auth.facility_name_placeholder') }}" @if($errors->has('name')) value="{{ old('name') }}" @endif>
                        @if($errors->has('name'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="status">{{ trans('auth.status') }}</label>
                        <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" id="status" tabindex="2" name="status">
                          @foreach($facilitiesStatus as $key => $value)
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
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <a href="{{URL::previous()}}"  class="btn btn-secondary">{{ trans('common.back') }}</a>
              <button type="submit" tabindex="3" class="btn btn-primary">{{ trans('auth.submit') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
@section('js')
  <script>
    $(function() {
      $(".facilities").validate({
        errorClass: "invalid-feedback",
        errorElement: "strong",
        rules: {
          name: "required",
          status: "required",
        },
        highlight: function(element) {
          $(element).addClass("is-invalid");
        },
        unhighlight: function(element) {
          $(element).removeClass("is-invalid");
        },
        messages: {
          name: "{{ trans('auth.facility_name_msg') }}",
         
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
