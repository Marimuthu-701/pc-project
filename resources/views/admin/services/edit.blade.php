@extends('admin.layouts.app')
@section('title', 'Profile')
@section('plugins.Datatables', true)
@section('plugins.Validation', true)
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>{{ trans('common.services') }}</h1>
        @include('admin.partials.breadcrumbs', ['breadcrumbs' => [
            trans('common.services')=> route('admin.services.index'),
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
                <h3 class="card-title">{{ trans('auth.services_edit') }}</h3>
            </div>
            <form method="POST" action="{{ route('admin.services.update', $service->id) }}" class="services" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">{{ trans('auth.name') }}</label>
                                        <input type="text" tabindex="1" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" placeholder="{{ trans('auth.service_name_placeholder') }}" @if($errors->has('name')) value="{{ old('name') }}" @else value="{{ $service->name }}" @endif>
                                        @if($errors->has('name'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="description">{{ trans('auth.description') }}</label>
                                        <textarea id="description" row="5" tabindex="2" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="{{trans('auth.description')}}">{{ isset($service->description) ? $service->description : old('description') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">{{ trans('auth.status') }}</label>
                                        <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" id="status" tabindex="3" name="status">
                                            @foreach($servicesStatus as $key => $value)
                                            <option value="{{ $key }}" @if($key == $service->status) selected @endif  >{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('status'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('status') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="status">{{ trans('auth.feature') }}</label>
                                        <select class="form-control {{ $errors->has('featured') ? 'is-invalid' : '' }}" id="featured" tabindex="4" name="featured">
                                            @foreach($setFeatureList as $key => $value)
                                                <option value="{{ $key }}" @if($key == $service->is_featured) selected="selected" @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="position">{{ trans('auth.position') }}</label>
                                        <input type="number" class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" id="position" tabindex="5" name="position" placeholder="{{ trans('auth.position') }}" value="{{ isset($service->position) ? $service->position : old('position') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="featured">{{ trans('messages.form_set') }}<span class="required">&nbsp;*</span></label>
                                        <select class="form-control {{ $errors->has('form_set') ? 'is-invalid' : '' }}" id="form_set" tabindex="5" name="form_set">
                                            <option value="">{{ trans('messages.select_form_set') }}</option>
                                            @foreach($formset as $key => $value)
                                                <option value="{{ $key }}" @if($service->form_set == $key) selected="selected" @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                         @if($errors->has('form_set'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('form_set') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <input type="hidden" name="update_icon_image" id="update_icon_image" value="{{$service->icon}}">
                                            <label>{{ trans('messages.icon_image') }}<span class="required">&nbsp;*</span></label><br/>
                                            <input  type="file" name="icon_image">
                                        </div>
                                        @if($service->icon)
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <a href="{{$iconImage}}" target="_blank">
                                                        <img src="{{ $iconImage }}" width="100px" class="service-image">
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <input type="hidden" name="update_banner_image" id="update_banner_image" value="{{$service->banner}}">
                                            <label>{{ trans('messages.banner_image') }}<span class="required">&nbsp;*</span></label><br/>
                                            <input  type="file" name="banner_image"> 
                                        </div>
                                        @if($service->banner)
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <a href="{{$largeBanner}}" target="_blank">
                                                        <img src="{{ $bannerImage }}" width="100px" class="service-image">
                                                    </a>
                                                </div>
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
        $.validator.addMethod("alpha", function(value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
        },"Letters only please");

      $(".services").validate({
        errorClass: "invalid-feedback",
        errorElement: "strong",
        rules: {
            name:{
                required:true,
                alpha:true,
                maxlength:40,
            },
            status: "required",
            form_set: "required",
            icon_image:{
                required:{
                    depends : function(element) {
                        return $("#update_icon_image").is(":blank");
                    }
                },
                extension: "jpg|png|jpeg",
            },
            banner_image:{
                required:{
                    depends : function(element) {
                        return $("#update_banner_image").is(":blank");
                    }
                },
                extension: "jpg|png|jpeg",
            },
        },
        highlight: function(element) {
          $(element).addClass("is-invalid");
        },
        unhighlight: function(element) {
          $(element).removeClass("is-invalid");
        },
        messages: {
            name: {
                required: "{{ trans('auth.name_msg') }}",
            },
            status: "{{ trans('auth.status_msg') }}",
            icon_image:{
                extension:"{{ trans('messages.avator_format_validation') }}",
            },
            banner_image:{
                extension:"{{ trans('messages.avator_format_validation') }}",
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
