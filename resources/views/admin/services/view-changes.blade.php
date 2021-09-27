@php
    $dobConvert = null;
    if(isset($serviceInfo->dob) && !empty($serviceInfo->dob)) {
        $dobConvert = date('d-m-Y',strtotime($serviceInfo->dob));
    }
    $fees_type = null;
    $fees_amount = null;
    if(isset($serviceInfo->fees_per_shift) && !empty($serviceInfo->fees_per_shift)) {
        $fees_type = "Per Shift";
        $fees_amount = $serviceInfo->fees_per_shift;
    } else if (isset($serviceInfo->fees_per_day) && !empty($serviceInfo->fees_per_day)) {
        $fees_type = "Per Day";
        $fees_amount = $serviceInfo->fees_per_day;
    }
@endphp

@extends('admin.layouts.app')
@section('title', 'Profile')
@section('plugins.Datatables', true)
@section('plugins.Validation', true)
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>{{ trans('common.partner_services_changes') }}</h1>
        @include('admin.partials.breadcrumbs', ['breadcrumbs' => [
            trans('common.partner_services')=> route('admin.partners.services'),
            trans('common.view'),
        ]])
    </div>
    <div class="col-md-6 text-right">
        @if($updateHistory->status == App\Models\User::STATUS_PENDING)
            <a class="btn btn-success" href="{{ route('admin.profile.updated.approve', ['id'=>$updateHistory->id]) }}">{{ trans('common.approval') }}</a>&nbsp;&nbsp;
        @endif
        <a class="btn btn-secondary" href="{{ URL::previous() }}">{{ trans('common.back') }}</a>&nbsp;
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
                <h3 class="card-title">{{ trans('common.partner_services_changes') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10">
                       @switch($form_set)
					    @case(App\Models\Service::FORM_SET_1)
					        	<div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ trans('auth.name') }} </label>
                                            <div>{{ isset($serviceInfo->name) ? $serviceInfo->name : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.service_type') }}</label>
                                            <div>{{ isset($serviceInfo->serviceType) ? $serviceInfo->serviceType->name :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{ trans('messages.reg_no_or_licence_no') }}</label>
                                             <div>{{ isset($serviceInfo->registration_number) ? $serviceInfo->registration_number :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">{{ trans('messages.gender') }} </label>
                                            <div>{{ isset($serviceInfo->gender) ? $serviceInfo->gender : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('auth.dob')  }}</label>
                                            <div>{{ isset($dobConvert) ? $dobConvert :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{  trans('auth.contact_phone') }}</label>
                                             <div>{{ isset($serviceInfo->contact_phone) ? $serviceInfo->contact_phone :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">{{ trans('messages.contact_email')  }} </label>
                                            <div>{{ isset($serviceInfo->contact_email) ? $serviceInfo->contact_email : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.id_proof') }}</label>
                                            <div>{{ isset($serviceInfo->id_proof) ? ucfirst(str_replace('_', ' ',$serviceInfo->id_proof)) :  null }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">{{ trans('auth.qualification') }}</label>
                                             <div>{{ isset($serviceInfo->qualification) ? $serviceInfo->qualification :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{ trans('messages.years_of_experience') }}</label>
                                             <div>{{ isset($serviceInfo->total_experience) ? $serviceInfo->total_experience :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">{{  trans('messages.area_of_specialization')  }} </label>
                                            <div>{{ isset($serviceInfo->specialization_area) ? $serviceInfo->specialization_area : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('auth.currently_working_at') }}</label>
                                            <div>{{ isset($serviceInfo->working_at) ? $serviceInfo->working_at :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{ trans('messages.fees') }}</label>
                                             <div>{{ isset($fees_amount) ? 'Rs. '.$fees_amount.' '.$fees_type :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.city') }}</label>
                                            <div>{{ isset($serviceInfo->city) ? $serviceInfo->city :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{ trans('auth.state') }}</label>
                                             <div>{{ isset($serviceInfo->states) ? $serviceInfo->states->name :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">{{ trans('auth.postal_code') }} </label>
                                            <div>{{ isset($serviceInfo->postal_code) ? $serviceInfo->postal_code : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('auth.additional_info') }}</label>
                                            <div>{{ isset($serviceInfo->additional_info) ? $serviceInfo->additional_info :  null }}</div>
                                        </div>
                                        
                                    </div>
                                </div>
					        @break

					    @case(App\Models\Service::FORM_SET_2)
					        	<div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ trans('auth.name') }} </label>
                                            <div>{{ isset($serviceInfo->name) ? $serviceInfo->name : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.service_type') }}</label>
                                            <div>{{ isset($serviceInfo->serviceType) ? $serviceInfo->serviceType->name :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{ trans('messages.reg_no_or_licence_no') }}</label>
                                             <div>{{ isset($serviceInfo->registration_number) ? $serviceInfo->registration_number :  null }}</div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="name">{{ trans('auth.contact_person')  }} </label>
                                            <div>{{ isset($serviceInfo->contact_person) ? $serviceInfo->contact_person : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{  trans('auth.contact_phone') }}</label>
                                             <div>{{ isset($serviceInfo->contact_phone) ? $serviceInfo->contact_phone :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.landline_number') }}</label>
                                            <div>{{ isset($serviceInfo->landline_number) ? $serviceInfo->landline_number :  null }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.list_of_tests_provided') }}</label>
                                            <div>{{ isset($serviceInfo->tests_provided) ? $serviceInfo->tests_provided :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{ trans('messages.website_link') }}</label>
                                            <div>
                                                <a href="{{$serviceInfo->website_link}}" target="_blank"> 
                                                {{ isset($serviceInfo->website_link) ? $serviceInfo->website_link :  null }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.city') }}</label>
                                            <div>{{ isset($serviceInfo->city) ? $serviceInfo->city :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{ trans('auth.state') }}</label>
                                             <div>{{ isset($serviceInfo->states) ? $serviceInfo->states->name :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">{{ trans('auth.postal_code') }} </label>
                                            <div>{{ isset($serviceInfo->postal_code) ? $serviceInfo->postal_code : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('auth.additional_info') }}</label>
                                            <div>{{ isset($serviceInfo->additional_info) ? $serviceInfo->additional_info :  null }}</div>
                                        </div>
                                    </div>
                                </div>
					        @break

                        @case(App\Models\Service::FORM_SET_3)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ trans('auth.name') }} </label>
                                            <div>{{ isset($serviceInfo->name) ? $serviceInfo->name : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.service_type') }}</label>
                                            <div>{{ isset($serviceInfo->serviceType) ? $serviceInfo->serviceType->name :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.govt_approved') }}</label>
                                            <div>{{ $serviceInfo->govt_approved == true ? trans('common.verified') :  trans('common.not_verified') }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{ trans('messages.reg_no_or_licence_no') }}</label>
                                             <div>{{ isset($serviceInfo->registration_number) ? $serviceInfo->registration_number :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">{{ trans('auth.contact_person')  }} </label>
                                            <div>{{ isset($serviceInfo->contact_person) ? $serviceInfo->contact_person : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{  trans('auth.contact_phone') }}</label>
                                             <div>{{ isset($serviceInfo->contact_phone) ? $serviceInfo->contact_phone :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('auth.number_of_rooms') }}</label>
                                            <div>{{ isset($serviceInfo->no_of_rooms) ? $serviceInfo->no_of_rooms :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{ trans('messages.room_rent') }}</label>
                                             <div>{{ isset($serviceInfo->room_rent) ? 'Rs. ' .currency($serviceInfo->room_rent).' '.App\Models\PartnerService::RENT_PER_MONTH :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{ trans('auth.additional_info') }}</label>
                                             <div>{{ isset($serviceInfo->additional_info) ? $serviceInfo->additional_info :  null }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.landline_number') }}</label>
                                            <div>{{ isset($serviceInfo->landline_number) ? $serviceInfo->landline_number :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{ trans('messages.website_link') }}</label>
                                            <div>
                                                <a href="{{$serviceInfo->website_link}}" target="_blank"> 
                                                {{ isset($serviceInfo->website_link) ? $serviceInfo->website_link :  null }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('auth.address') }}</label>
                                            <div>{{ isset($serviceInfo->address) ? $serviceInfo->address :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.city') }}</label>
                                            <div>{{ isset($serviceInfo->city) ? $serviceInfo->city :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{ trans('auth.state') }}</label>
                                             <div>{{ isset($serviceInfo->states) ? $serviceInfo->states->name :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">{{ trans('auth.postal_code') }} </label>
                                            <div>{{ isset($serviceInfo->postal_code) ? $serviceInfo->postal_code : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('auth.additional_info') }}</label>
                                            <div>{{ isset($serviceInfo->additional_info) ? $serviceInfo->additional_info :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{ trans('auth.facilities_available') }}</label>
                                             <div>{{ isset($facilities) ? $facilities :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{ trans('auth.other_facilities') }}</label>
                                             <div>{{ isset($serviceInfo->other_facilities) ? $serviceInfo->other_facilities :  null }}</div>
                                        </div>
                                    </div>
                                </div>
                            @break
                            
						@case(App\Models\Service::FORM_SET_4)
								<div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ trans('auth.name') }} </label>
                                            <div>{{ isset($serviceInfo->name) ? $serviceInfo->name : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.service_type') }}</label>
                                            <div>{{ isset($serviceInfo->serviceType) ? $serviceInfo->serviceType->name :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">{{ trans('messages.reg_no_or_licence_no')  }} </label>
                                            <div>{{ isset($serviceInfo->registration_number) ? $serviceInfo->registration_number : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">{{ trans('auth.contact_person')  }} </label>
                                            <div>{{ isset($serviceInfo->contact_person) ? $serviceInfo->contact_person : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{  trans('auth.contact_phone') }}</label>
                                             <div>{{ isset($serviceInfo->contact_phone) ? $serviceInfo->contact_phone :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.landline_number') }}</label>
                                            <div>{{ isset($serviceInfo->landline_number) ? $serviceInfo->landline_number :  null }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                         <div class="form-group">
                                            <label for="status">{{ trans('messages.website_link') }}</label>
                                            <div>
                                                <a href="{{$serviceInfo->website_link}}" target="_blank"> 
                                                {{ isset($serviceInfo->website_link) ? $serviceInfo->website_link :  null }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('auth.address') }}</label>
                                            <div>{{ isset($serviceInfo->address) ? $serviceInfo->address :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.city') }}</label>
                                            <div>{{ isset($serviceInfo->city) ? $serviceInfo->city :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{ trans('auth.state') }}</label>
                                             <div>{{ isset($serviceInfo->states) ? $serviceInfo->states->name :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">{{ trans('auth.postal_code') }} </label>
                                            <div>{{ isset($serviceInfo->postal_code) ? $serviceInfo->postal_code : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{ trans('auth.additional_info') }}</label>
                                             <div>{{ isset($serviceInfo->additional_info) ? $serviceInfo->additional_info :  null }}</div>
                                        </div>
                                        
                                    </div>
                                </div>
							@break

						@case(App\Models\Service::FORM_SET_5)
								<div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ trans('auth.name') }} </label>
                                            <div>{{ isset($serviceInfo->name) ? $serviceInfo->name : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.service_type') }}</label>
                                            <div>{{ isset($serviceInfo->serviceType) ? $serviceInfo->serviceType->name :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">{{ trans('messages.reg_no_or_licence_no')  }} </label>
                                            <div>{{ isset($serviceInfo->registration_number) ? $serviceInfo->registration_number : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">{{ trans('auth.contact_person')  }} </label>
                                            <div>{{ isset($serviceInfo->contact_person) ? $serviceInfo->contact_person : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{  trans('auth.contact_phone') }}</label>
                                             <div>{{ isset($serviceInfo->contact_phone) ? $serviceInfo->contact_phone :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.contact_email') }}</label>
                                            <div>{{ isset($serviceInfo->contact_email) ? $serviceInfo->contact_email :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.landline_number') }}</label>
                                            <div>{{ isset($serviceInfo->landline_number) ? $serviceInfo->landline_number :  null }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">{{ trans('messages.website_link') }}</label>
                                            <div>
                                                <a href="{{$serviceInfo->website_link}}" target="_blank"> 
                                                {{ isset($serviceInfo->website_link) ? $serviceInfo->website_link :  null }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('auth.address') }}</label>
                                            <div>{{ isset($serviceInfo->address) ? $serviceInfo->address :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.city') }}</label>
                                            <div>{{ isset($serviceInfo->city) ? $serviceInfo->city :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{ trans('auth.state') }}</label>
                                             <div>{{ isset($serviceInfo->states) ? $serviceInfo->states->name :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">{{ trans('auth.postal_code') }} </label>
                                            <div>{{ isset($serviceInfo->postal_code) ? $serviceInfo->postal_code : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.service_provider') }}</label>
                                            <div>{{ isset($serviceInfo->services_provided) ? $serviceInfo->services_provided :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{ trans('auth.additional_info') }}</label>
                                             <div>{{ isset($serviceInfo->additional_info) ? $serviceInfo->additional_info :  null }}</div>
                                        </div>
                                        
                                    </div>
                                </div>
							@break

						@case(App\Models\Service::FORM_SET_6)
								<div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ trans('auth.name') }} </label>
                                            <div>{{ isset($serviceInfo->name) ? $serviceInfo->name : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.service_type') }}</label>
                                            <div>{{ isset($serviceInfo->serviceType) ? $serviceInfo->serviceType->name :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">{{ trans('messages.project_name')  }} </label>
                                            <div>{{ isset($serviceInfo->project_name) ? $serviceInfo->project_name : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">{{ trans('auth.contact_person')  }} </label>
                                            <div>{{ isset($serviceInfo->contact_person) ? $serviceInfo->contact_person : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{  trans('auth.contact_phone') }}</label>
                                             <div>{{ isset($serviceInfo->contact_phone) ? $serviceInfo->contact_phone :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.contact_email') }}</label>
                                            <div>{{ isset($serviceInfo->contact_email) ? $serviceInfo->contact_email :  null }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.landline_number') }}</label>
                                            <div>{{ isset($serviceInfo->landline_number) ? $serviceInfo->landline_number :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{ trans('messages.website_link') }}</label>
                                            <div>
                                                <a href="{{$serviceInfo->website_link}}" target="_blank"> 
                                                {{ isset($serviceInfo->website_link) ? $serviceInfo->website_link :  null }}
                                                </a>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="email">{{ trans('messages.city') }}</label>
                                            <div>{{ isset($serviceInfo->city) ? $serviceInfo->city :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{ trans('auth.state') }}</label>
                                             <div>{{ isset($serviceInfo->states) ? $serviceInfo->states->name :  null }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">{{ trans('auth.postal_code') }} </label>
                                            <div>{{ isset($serviceInfo->postal_code) ? $serviceInfo->postal_code : '-' }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">{{ trans('auth.additional_info') }}</label>
                                             <div>{{ isset($serviceInfo->additional_info) ? $serviceInfo->additional_info :  null }}</div>
                                        </div>
                                    </div>
                                </div>
							@break
						
					    @default
					        <span>Not found</span>
					@endswitch
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
