@extends('admin.layouts.app')
@section('title', 'Profile')
@section('plugins.Datatables', true)
@section('plugins.Validation', true)
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>{{ trans('common.testimonials') }}</h1>
        @include('admin.partials.breadcrumbs', ['breadcrumbs' => [
            trans('common.testimonials')=> route('admin.testimonials.index'),
            trans('common.view'),
        ]])
    </div>
    <div class="col-md-6 text-right">
        @if($testimonial->status == App\Models\User::STATUS_PENDING)
            <a class="btn btn-success" href="{{ route('admin.testimonials.approve', ['id'=> $testimonial->id] ) }}">{{ trans('common.approval') }}</a>&nbsp;&nbsp;
        @endif
        <a class="btn btn-secondary" href="{{ route('admin.testimonials.index') }}">{{ trans('common.back') }}</a>&nbsp;
        <a class="btn btn-primary" href="{{ route('admin.testimonials.edit', $testimonial->id) }}">{{ trans('common.edit') }}</a>&nbsp;
        <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" class="list-inline-item item-delete-form">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn btn-danger" type="submit">Delete</button>
        </form>
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
                <h3 class="card-title">{{ trans('common.testimonials') }}</h3>
            </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="row">
                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ trans('auth.name') }} </label>
                                        <div>{{ isset($testimonial->name) ? $testimonial->name : '-' }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">{{ trans('auth.email') }}</label>
                                        <div>{{ isset($testimonial->email) ? $testimonial->email : '-' }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">{{ trans('messages.rating') }}</label>
                                        <input type="hidden" name="rating"  class="customer-rating" value="{{ isset($testimonial->rating) ? $testimonial->rating : null }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description">{{ trans('auth.description') }}</label>
                                        <div>{{ isset($testimonial->description) ? $testimonial->description : '-' }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">{{ trans('auth.address') }}</label>
                                        <div>{{ isset($testimonial->address) ? $testimonial->address : '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
        </div>
    </div>
</div>
@stop
