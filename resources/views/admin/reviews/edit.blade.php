@extends('admin.layouts.app')
@section('title', 'Profile')
@section('plugins.Datatables', true)
@section('plugins.Validation', true)
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>{{ trans('common.reviews') }}</h1>
        @include('admin.partials.breadcrumbs', ['breadcrumbs' => [
            trans('common.reviews')=> route('admin.reviews.index'),
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
                <h3 class="card-title">{{ trans('common.edit_review') }}</h3>
            </div>
            <form method="POST" action="{{ route('admin.reviews.update', $review->id) }}" class="reviews">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="row">
                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('messages.provider_name') }}</label>
                                        <div class="">{{ isset($provider_name) ? $provider_name : null }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">{{ trans('messages.question_comments') }}<span class="required">&nbsp;*</span></label>
                                        <textarea id="description" row="1" tabindex="1" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="{{trans('messages.question_comments')}}">{{ isset($review->body) ? $review->body : old('description') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">{{ trans('messages.rating') }}<span class="required">&nbsp;*</span></label>
                                        <input id="rating" type="text" name="rating" value="{{ isset($review->rating) ? $review->rating : null }}">
                                        <div class="rating-error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">{{ trans('auth.feature') }}</label>
                                        <select class="form-control {{ $errors->has('recommend') ? 'is-invalid' : '' }}"  tabindex="3" name="recommend">
                                            @foreach($featureList as $key => $value)
                                                <option value="{{ $key }}" @if($key == $review->recommend) selected="selected" @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
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
      var $inp = $('#rating');
        $inp.rating({
            min: 0,
            max: 5,
            step: 1,
            size: 'xs',
            showClear: true,
        });
      $(".reviews").validate({
        errorClass: "invalid-feedback",
        errorElement: "strong",
        rules: {
            description:{
                required : true,
            },
            rating:{
                required : true,
            },
        },
        highlight: function(element) {
          $(element).addClass("is-invalid");
        },
        unhighlight: function(element) {
          $(element).removeClass("is-invalid");
        },
        errorPlacement: function(error, element) {
            var terms = element.attr("name");    
            if (terms == 'rating') {
                error.insertAfter('.rating-error');
            }else {
                error.insertAfter(element);
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
