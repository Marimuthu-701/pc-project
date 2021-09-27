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
            trans('common.view'),
        ]])
    </div>
    <div class="col-md-6 text-right">
        @if($review->approved == App\Models\User::STATUS_PENDING)
            <a class="btn btn-success" href="{{ route('admin.reviews.approve', ['id'=> $review->id] ) }}">{{ trans('common.approval') }}</a>&nbsp;&nbsp;
        @endif
        <a class="btn btn-secondary" href="{{ route('admin.reviews.index') }}">{{ trans('common.back') }}</a>&nbsp;
        <a class="btn btn-primary" href="{{ route('admin.reviews.edit', $review->id) }}">{{ trans('common.edit') }}</a>&nbsp;
        <form method="POST" action="{{ route('admin.reviews.destroy', $review->id) }}" class="list-inline-item item-delete-form">
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
                <h3 class="card-title">{{ trans('common.reviews') }}</h3>
            </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="row">
                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ trans('messages.provider_name') }} </label>
                                        <div>{{ isset($provider_name) ? $provider_name : '-' }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">{{ trans('messages.question_comments') }}</label>
                                        <div>{{ isset($review->body) ? $review->body : '-' }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">{{ trans('messages.rating') }}</label>
                                        <input type="hidden" name="rating"  class="customer-rating" value="{{ isset($review->rating) ? $review->rating : null }}">
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
