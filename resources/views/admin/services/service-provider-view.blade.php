@extends('admin.layouts.app')
@section('title', 'Profile')
@section('plugins.Datatables', true)
@section('plugins.Validation', true)
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>{{ trans('common.partner_services') }}</h1>
        @include('admin.partials.breadcrumbs', ['breadcrumbs' => [
            trans('common.partner_services')=> route('admin.partners.services'),
            trans('common.view'),
        ]])
    </div>
    <div class="col-md-6 text-right">
        @if($serviceInfo->status == App\Models\User::STATUS_PENDING)
            <a class="btn btn-success" href="{{ route('admin.partners.services.approve', ['id'=> $serviceInfo->id] ) }}">{{ trans('common.approval') }}</a>&nbsp;&nbsp;
        @endif
        <a class="btn btn-secondary" href="{{ route('admin.partners.services') }}">{{ trans('common.back') }}</a>&nbsp;
        <a class="btn btn-primary" href="{{ route('admin.partners.services.edit', $serviceInfo->id) }}">{{ trans('common.edit') }}</a>&nbsp;
        <form method="POST" action="{{ route('admin.partners.services.destroy', $serviceInfo->id) }}" class="list-inline-item item-delete-form">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn btn-danger" type="submit">Delete</button>
        </form>
        @if($updateHistoryUser)
            <a class="btn btn-primary" href="{{ route('admin.view.changes', $updateHistoryUser) }}">{{ trans('common.view_new_changes') }}</a>
        @endif
    </div>
</div>
@stop
@section('content')
<div class="row">
	<div class="col-md-12">
        @include('flash::message')
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 profile_container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ trans('common.partner_services') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10">
                       @switch($form_set)
					    @case(App\Models\Service::FORM_SET_1)
					        	@include('admin.services.nurse-physio-view')
					        @break

					    @case(App\Models\Service::FORM_SET_2)
					        	@include('admin.services.lab-pharmacy-view')
					        @break

                        @case(App\Models\Service::FORM_SET_3)
                                @include('admin.services.old-age-home-view')
                            @break
                            
						@case(App\Models\Service::FORM_SET_4)
								@include('admin.services.medical-equipment-view')
							@break

						@case(App\Models\Service::FORM_SET_5)
								@include('admin.services.home-care-view')
							@break

						@case(App\Models\Service::FORM_SET_6)
								@include('admin.services.retirment-home-view')
							@break
						
					    @default
					        <span>Something went wrong, please try again</span>
					@endswitch
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
