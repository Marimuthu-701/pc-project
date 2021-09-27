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
            <label for="name">{{ trans('auth.contact_person')  }} </label>
            <div>{{ isset($serviceInfo->contact_person) ? $serviceInfo->contact_person : '-' }}</div>
        </div>
        <div class="form-group">
            <label for="status">{{  trans('auth.contact_phone') }}</label>
             <div>{{ isset($serviceInfo->contact_phone) ? $serviceInfo->contact_phone :  null }}</div>
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
            <label for="email">{{ trans('messages.landline_number') }}</label>
            <div>{{ isset($serviceInfo->landline_number) ? $serviceInfo->landline_number :  null }}</div>
        </div>
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
        <div class="form-group">
            <label for="status">{{ trans('messages.uploaded_image') }}</label>
            <div class="row">
            @if(count($serviceMedia) > 0)
                @foreach($serviceMedia as $key=>$value)
            	<div class="col-lg-3">
                    @if($value['type']!='file')
                        <a href="{{$value['image_url']}}" target="_blank">
                            <img src="{{ $value['thump_url'] }}" class="admin-service-image">
                        </a>
                    @else
                        <a href="{{ $value['image_url'] }}" target="_blank" class="service-file"> {{ substr ($value['image_url'], -25) }} </a>
                    @endif
        		</div>
                @endforeach
            @endif
        	</div>
        </div>
    </div>
</div>