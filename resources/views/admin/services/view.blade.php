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
            trans('common.view'),
        ]])
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-secondary" href="{{ route('admin.services.index') }}">{{ trans('common.back') }}</a>&nbsp;
        <a class="btn btn-primary" href="{{ route('admin.services.edit', $service->id) }}">{{ trans('common.edit') }}</a>&nbsp;
        <form method="POST" action="{{ route('admin.services.destroy', $service->id) }}" class="list-inline-item item-delete-form">
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
                <h3 class="card-title">{{ trans('auth.services_detail') }}</h3>
            </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">{{ trans('auth.name') }}</label>
                                        <div>{{ $service->name }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">{{ trans('auth.description') }}</label>
                                        <div>{{ isset($service->description) ? $service->description : '-' }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">{{ trans('auth.status') }}</label>
                                        @if($service->status == App\Models\Service::STATUS_INACTIVE)
                                            <div>{{ trans('common.inactive') }}</div>
                                        @else
                                            <div>{{ trans('common.active') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="status">{{ trans('auth.feature') }}</label>
                                        @if($service->is_featured == App\Models\Service::IS_FEATURED)
                                            <div>{{ trans('common.verified') }}</div>
                                        @else
                                            <div>{{ trans('common.not_verified') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="status">{{ trans('messages.form_set') }}</label>
                                        <div>{{ isset($service->form_set) ? $service->form_set : '-' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="position">{{ trans('auth.position') }}</label>
                                        <div>{{ isset($service->position) ? $service->position : null }}</div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>{{ trans('messages.icon_image') }}<br/>
                                        </div>
                                        @if($service->icon)
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <a href="{{$iconImage}}" target="_blank">
                                                        <img src="{{ $iconImage }}" class="service-image">
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>{{ trans('messages.banner_image') }}</label><br/>
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
        </div>
    </div>
</div>
@stop
