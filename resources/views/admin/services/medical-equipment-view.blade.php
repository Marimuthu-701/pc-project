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
<div class="row">
	<div class="col-md-12">
		<label for="status">{{ trans('messages.equipement_details') }}</label>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ trans('messages.equipment_name') }}</th>
                    <th>{{ trans('auth.description') }}</th>
                    <th>{{ trans('messages.rent_type_lable') }}</th>
                    <th>{{ trans('messages.rent') }}</th>
                </tr>
            </thead>
            <tbody>
                @if(count($equipmentsDetail) > 0)
                    @foreach($equipmentsDetail as $key => $value)
                        <tr>
                            <td>{{ isset($value['name']) ? $value['name'] : '-' }}</td>
                            <td>{{ isset($value['description']) ? $value['description'] : '-' }}</td>
                            <td>{{ isset($value['rent_type']) ? ucfirst(str_replace('_', ' ', $value['rent_type'])) : '-' }}</td>
                            <td>{{ isset($value['rent']) ? currency($value['rent']) : '-' }}</td>
                            
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" style="text-align: center;">Record Not found</td>
                    </tr>
                @endif
            </tbody>
        </table>
	</div>
</div>
<div class="row">
    @if($equipmentsDetail > 0)
        @foreach($equipmentsDetail as $key => $value)
            @if(count($value['imagePath']) > 0)
                @foreach($value['imagePath'] as $key_two => $value_two)
                    <div class="col-lg-2 col-md-2 col-xs-12">
                        <a href="{{$value_two}}">
                            <img src="{{ $value['thump_image'][$key_two] }}" alt="Another alt text" class="admin-service-image">
                        </a>
                    </div>
                @endforeach
            @endif
        @endforeach
    @else
    <div class="col-lg-12 col-md-12 col-xs-12 text-center">
        <p>{{ trans('messages.image_not_found') }}</p>
    </div>
	@endif
</div>