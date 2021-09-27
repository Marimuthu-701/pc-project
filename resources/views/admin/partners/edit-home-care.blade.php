<!-- Home Care Service Provider-->
<div class="row">
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('messages.company_name') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset($serviceInfo->name) ? $serviceInfo->name : old('name') }}" placeholder="{{ trans('messages.company_name')}}">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('messages.reg_no_or_licence_no') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('reg_no_or_licence_no') is-invalid @enderror" name="reg_no_or_licence_no" value="{{ isset($serviceInfo->registration_number) ? $serviceInfo->registration_number : old('reg_no_or_licence_no') }}" placeholder="{{ trans('messages.reg_no_or_licence_no')}}">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.contact_person') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" value="{{ isset($serviceInfo->contact_person) ? $serviceInfo->contact_person : old('contact_person') }}"  placeholder="{{ trans('auth.contact_person')}}">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.contact_phone') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone" value="{{ isset($serviceInfo->contact_phone) ? $serviceInfo->contact_phone : old('contact_phone') }}" placeholder="{{ trans('auth.contact_phone') }}" maxlength="10">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('messages.contact_email') }}</label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" name="contact_email" value="{{ isset($serviceInfo->contact_email) ? $serviceInfo->contact_email : old('email') }}" placeholder="{{ trans('messages.contact_email') }}">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.address') }}<span class="required">&nbsp;*</span></label>
            <textarea  row="5" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="{{ trans('auth.address') }}">{{ isset($serviceInfo->address) ? $serviceInfo->address : old('address') }}</textarea>
        </div>
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('auth.select_state') }}<span class="required">&nbsp;*</span></label>
            <select class="form-control search-state @error('state') is-invalid @enderror" name="state" >
                <option value="">{{ trans('auth.select_state') }}</option>
                @foreach($states as $key => $state)
                    <option value="{{ $state->code }}" @if($state->code == $serviceInfo->state)) selected="selected" @endif>{{ $state->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('messages.select_city') }}<span class="required">&nbsp;*</span></label>
            <select class="form-control city-drop-list @error('city') is-invalid @enderror" name="city">
                <option value="">{{ trans('messages.select_city') }}</option>
                @foreach($cities as $key => $citie)
                    <option value="{{ $citie->name }}" @if($citie->name == $serviceInfo->city) selected="selected" @endif>{{ $citie->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('auth.postal_code') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('pin_code') is-invalid @enderror" name="pin_code" value="{{ isset($serviceInfo->postal_code) ? $serviceInfo->postal_code : old('pin_code') }}" placeholder="{{ trans('auth.postal_code') }}" maxlength="6">
        </div>
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('messages.landline_number') }}</label>
            <input type="text" class="form-control @error('landline_number') is-invalid @enderror" name="landline_number" value="{{ isset($serviceInfo->landline_number) ? $serviceInfo->landline_number : old('landline_number') }}"  placeholder="{{ trans('messages.landline_number')}}">
        </div>
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('messages.service_provider') }}</label>
             <textarea row="5" class="form-control @error('home_service_provider') is-invalid @enderror" name="home_service_provider" placeholder="{{ trans('messages.service_provider') }}">{{ isset($serviceInfo->services_provided) ? $serviceInfo->services_provided: old('home_service_provider') }}</textarea>
        </div>
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('messages.website_link') }}</label>
            <input type="text" class="form-control @error('website_link') is-invalid @enderror" name="website_link" value="{{ isset($serviceInfo->website_link) ? $serviceInfo->website_link : old('website_link') }}" placeholder="{{ trans('messages.website_link')}}">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.any_additional_info') }}</label>
            <textarea row="5" class="form-control @error('add_info') is-invalid @enderror" name="add_info" placeholder="{{ trans('auth.any_additional_info') }}">{{ isset($serviceInfo->additional_info) ? $serviceInfo->additional_info : old('add_info') }}</textarea>
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('messages.photo') }}</label><br/>
            <input type="hidden" name="home_care_img" value="{{ isset($serviceMedia[0]['file']) ? $serviceMedia[0]['file'] : null }}" id="home_care_img">
            <input id="care_home_photo" type="file" name="care_home_photo[]" accept="image/x-png,image/gif,image/jpeg" multiple/>   
        </div>
        @if (count($serviceMedia) > 0)
            @include('admin.partners.service-provider-photos')
        @endif
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('messages.profile_photo') }}</label><br/>
            <input id="profile_photo" type="file" name="profile_photo" accept="image/x-png,image/jpeg">   
        </div>
        @if($avatar_url)
            <div class="row">
                <div class="col-lg-3">
                    <a href="{{$avatar_url}}" target="_blank">
                        <img src="{{ $avatar_thumb }}"  class="service-image">
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
<!-- End Home Care Service Provider-->