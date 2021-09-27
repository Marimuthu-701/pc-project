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
            <label for="email">{{ trans('auth.status') }}</label>
            <div>{{ isset($status) ? $status :  null }}</div>
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
        
		<div class="form-group">
            <label for="status">{{ trans('messages.profile_photo') }}</label>
              <div class="col-lg-3">
	            @if($avatarUrl)
	                <a href="{{$avatarUrl}}" target="_blank">
	                    <img src="{{ $avatar_thumb }}" class="service-image">
	                </a>
	            @endif
        	</div>
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
        <div class="form-group" style="display: none;">
            <label for="name">{{ trans('messages.select_fees_type') }} </label>
            <div>{{ isset($fees_type) ? $fees_type : '-' }}</div>
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
            <label for="status">{{ trans('messages.upload_id_proof') }}</label>
            <div class="row"> 
                @if(count($idProofimage) > 0)
                    @foreach($idProofimage as $key=>$value)
                        <div class="col-lg-3">
                        @if($value['type']!='file')
                            <a href="{{$value['id_proof_url']}}" target="_blank">
                                <img src="{{ $value['id_proof_thump_url'] }}" class="admin-service-image">
                            </a>
                        @else
                            <a href="{{ $value['id_proof_url'] }}" target="_blank" class="service-file"> {{ substr ($value['id_proof_url'], -25) }} </a>
                        @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>