@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
<!-- <div class="col-md-12 text-center">Back Office</div> -->
<div class="dash-head-main" id="dash-head-main">
	<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 dash-head-part">
        <div class="panel warn dash-head-subpart">
            <div class="panel-heading dash-head-ajax">
                <div class="row">
                    <div class="col-md-4 col-xs-4 text-center">
                        <img src="{{ asset('images/admin/dashboard_icon/user.png') }}">
                    </div>
                    <div class="col-md-8 col-xs-8 text-right">
                        <div class="title-head panel-count">{{$userCount}}</div>
                        <div class="title-text panel-lable">{{trans('admin.users')}}</div>
                    </div>
                </div>
            </div>
            <a href="{{route('admin.users.index')}}">
                <div class="panel-footer" style="background: #e5ac00;">
                    <span class="pull-left">View all</span>
                    <span class="pull-right">
                        <img src="{{ asset('images/admin/dashboard_icon/arrow.png') }}">
                    </span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 dash-head-part">
        <div class="panel danger dash-head-subpart">
            <div class="panel-heading dash-head-ajax">
                <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-4 text-center">
                        <img src="{{asset('images/admin/dashboard_icon/service_provider.png')}}">
                    </div>
                    <div class="col-md-10 col-sm-10 col-xs-8 text-right">
                        <div class="title-head panel-count">{{$serviceProviderCount}}</div>
                        <div class="title-text panel-lable">{{trans('common.partner_services')}}</div>
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.partners.services') }}">
                <div class="panel-footer" style="background: #F75059;">
                    <span class="pull-left">View all</span>
                    <span class="pull-right">
                        <img src="{{ asset('images/admin/dashboard_icon/arrow.png') }}">
                    </span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 dash-head-part">
        <div class="panel success dash-head-subpart">
            <div class="panel-heading dash-head-ajax">
                <div class="row">
                    <div class="col-md-4 col-xs-4 text-center">
                        <img src="{{asset('images/admin/dashboard_icon/service.png')}}">
                    </div>
                    <div class="col-md-8 col-xs-8 text-right">
                        <div class="title-head panel-count">{{$serviceCount}}</div>
                        <div class="title-text panel-lable">{{ trans('common.services') }}</div>
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.services.index') }}">
                <div class="panel-footer" style="background: #4ead6a;">
                    <span class="pull-left">View all</span>
                    <span class="pull-right">
                        <img src="{{ asset('images/admin/dashboard_icon/arrow.png') }}">
                    </span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 dash-head-part">
        <div class="panel warning dash-head-subpart">
            <div class="panel-heading dash-head-ajax">
                <div class="row">
                    <div class="col-md-4 col-xs-4 text-center">
                        <img src="{{asset('images/admin/dashboard_icon/facilities.png')}}">
                    </div>
                    <div class="col-md-8 col-xs-8 text-right">
                    	<div class="title-head panel-count">{{ $facilityCount }}</div>
                        <div class="title-text panel-lable">{{ trans('common.facilities') }}</div>
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.facilities.index') }}">
                <div class="panel-footer" style="background: #e26884;">
                    <span class="pull-left">View all</span>
                    <span class="pull-right">
                        <img src="{{ asset('images/admin/dashboard_icon/arrow.png') }}">
                    </span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 dash-head-part">
        <div class="panel info dash-head-subpart">
            <div class="panel-heading dash-head-ajax" id="Shares" ref="11080">
                <div class="row">
                    <div class="col-md-4 col-xs-4 text-center">
                        <img src="{{asset('images/admin/dashboard_icon/testimonials.png')}}">
                    </div>
                    <div class="col-md-8 col-xs-8 text-right">
                        <div class="title-head panel-count">{{ $testimonialCount }}</div>
                        <div class="title-text panel-lable">{{ trans('common.testimonials') }}</div>
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.testimonials.index') }}">
                <div class="panel-footer" style="background: #5572db;">
                    <span class="pull-left">View all</span>
                    <span class="pull-right">
                        <img src="{{ asset('images/admin/dashboard_icon/arrow.png') }}">
                    </span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 dash-head-part">
        <div class="panel review dash-head-subpart">
            <div class="panel-heading dash-head-ajax" id="Shares" ref="11080">
                <div class="row">
                    <div class="col-md-4 col-xs-4 text-center">
                        <img src="{{asset('images/admin/dashboard_icon/reviews.png')}}">
                    </div>
                    <div class="col-md-8 col-xs-8 text-right">
                        <div class="title-head panel-count">{{ $ratingCount }}</div>
                        <div class="title-text panel-lable">{{ trans('common.reviews') }}</div>
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.reviews.index') }}">
                <div class="panel-footer" style="background: #AA85FF;">
                    <span class="pull-left">View all</span>
                    <span class="pull-right">
                        <img src="{{ asset('images/admin/dashboard_icon/arrow.png') }}">
                    </span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

</div>
</div>
@stop
