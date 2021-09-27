@extends('admin.layouts.app')
@section('title', 'Testimonials')
@section('plugins.Datatables', true)
@section('plugins.Validation', true)
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>{{ trans('common.testimonials') }}</h1>
        @include('admin.partials.breadcrumbs', ['breadcrumbs' => [
            trans('common.testimonials')=> route('admin.testimonials.index'),
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
                <h3 class="card-title">{{ trans('auth.service_add') }}</h3>
            </div>
            <form action="{{ route('admin.testimonials.store') }}" method="post" class="testimonials" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ trans('auth.name') }}<span class="required">&nbsp;*</span></label>
                                        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" tabindex="1" name="name" placeholder="{{ trans('auth.name') }}" value="{{ old('name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">{{ trans('auth.email') }}</label>
                                        <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" tabindex="2" name="email" placeholder="{{ trans('auth.email') }}" value="{{ old('email') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">{{ trans('auth.description') }}<span class="required">&nbsp;*</span></label>
                                        <textarea id="description" row="5" tabindex="3" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="{{trans('auth.description')}}">{{ (old('description') )}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">{{ trans('auth.address') }}<span class="required">&nbsp;*</span></label>
                                        <textarea id="address" row="5" tabindex="4" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="{{trans('auth.address')}}">{{ (old('address') )}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">{{ trans('messages.rating') }}</label>
                                        <input id="rating" type="text" name="rating">
                                       
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

        var $inp = $('#rating');
        $inp.rating({
            min: 0,
            max: 5,
            step: 1,
            size: 'xs',
            showClear: true,
        });
      $(".testimonials").validate({
        errorClass: "invalid-feedback",
        errorElement: "strong",
        rules: {
            name:{
                required:true,
                alpha:true,
                maxlength:40,
            },
            email: {
                email:true,
            },
            description:{
                required : true,
            },
            address:{
                required : true,
            },
        },
        highlight: function(element) {
          $(element).addClass("is-invalid");
        },
        unhighlight: function(element) {
          $(element).removeClass("is-invalid");
        },
        submitHandler: function(form) {
          form.submit();
        }
      });
    });
  </script>
@stop

@stop
