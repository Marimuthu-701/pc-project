<!-- Home Care Service Provider-->
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('messages.company_name')}} </label>
        <input type="text" class="form-control @error('company_name') is-invalid @enderror" name="name" value="{{ isset($serviceInfo->name) ? $serviceInfo->name : old('company_name') }}" placeholder="{{ trans('messages.company_name')}}">
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-12 col-form-label my-account-lable required"> {{ trans('messages.reg_no_or_licence_no')}} </label>
       <input type="text" class="form-control @error('reg_no_or_licence_no') is-invalid @enderror" name="reg_no_or_licence_no" value="{{ isset($serviceInfo->registration_number) ? $serviceInfo->registration_number :  old('reg_no_or_licence_no') }}" placeholder="{{ trans('messages.reg_no_or_licence_no')}}">
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.contact_person')}} </label>
        <input type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" value="{{ isset($serviceInfo->contact_person) ? $serviceInfo->contact_person : old('contact_person') }}"  placeholder="{{ trans('auth.contact_person')}}" autofocus>
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.contact_phone')}} </label>
        <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone" value="{{ isset($serviceInfo->contact_phone) ? $serviceInfo->contact_phone : old('contact_phone') }}" placeholder="{{ trans('auth.contact_phone')}}" maxlength="10">
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable"> {{ trans('messages.contact_email')}} </label>
        <input type="text" class="form-control @error('email') is-invalid @enderror" name="contact_email" value="{{ isset($serviceInfo->contact_email) ? $serviceInfo->contact_email : old('email') }}" placeholder="{{ trans('messages.contact_email') }}">
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.address')}} </label>
        <textarea  row="5" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="{{ trans('auth.address') }}">{{isset($serviceInfo->address) ? $serviceInfo->address :  old('address') }}</textarea>
    </div>
</div>
<div class="form-group row">
    <div class="col-xs-12 col-lg-6 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.select_state')}} </label>
        <select class="form-control search-state @error('state') is-invalid @enderror" name="state" >
            <option value="">{{ trans('auth.select_state') }}</option>
            @foreach($states as $key => $state)
                <option value="{{ $state->code }}" @if($serviceInfo->state == $state->code) selected="selected" @endif>{{ $state->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-xs-12 col-lg-6 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('messages.select_city')}} </label>
        <select class="form-control city-drop-list @error('city') is-invalid @enderror" name="city">
            <option value="">{{ trans('messages.select_city') }}</option>
            @foreach($cities as $key => $citie)
                <option value="{{ $citie->name }}" @if($serviceInfo->city == $citie->name) selected="selected" @endif>{{ $citie->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <div class="col-xs-12 col-lg-6 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.postal_code')}} </label>
        <input type="text" class="form-control @error('pin_code') is-invalid @enderror" name="pin_code" value="{{ isset($serviceInfo->postal_code) ? $serviceInfo->postal_code : old('pin_code') }}" placeholder="{{ trans('auth.postal_code') }}" maxlength="6">
    </div>
    <div class="col-xs-12 col-lg-6 register-form-input">
        <label for="postal_code" class="col-lg-6 col-form-label my-account-lable"> {{ trans('messages.landline_number')}} </label>
        <input type="text" class="form-control @error('landline_number') is-invalid @enderror" name="landline_number" value="{{ isset($serviceInfo->landline_number) ? $serviceInfo->landline_number : old('landline_number') }}"  placeholder="{{ trans('messages.landline_number') }}">
    </div>
</div>
<div class="form-group row">
    <div class="col-xs-12 col-lg-6 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable"> {{ trans('messages.service_provider')}} </label>
        <textarea row="5" class="form-control @error('service_provider') is-invalid @enderror" name="service_provider" placeholder="{{ trans('messages.service_provider') }}">{{ isset($serviceInfo->services_provided) ? $serviceInfo->services_provided : old('service_provider') }}</textarea>
        <!-- <select class="form-control" name="service_provider">
            <option value="">{{ trans('messages.service_provider') }}</option>
            @foreach($services as $key => $service)
                <option value="{{ $service->name }}" @if($serviceInfo->services_provided == $service->name) selected="selected" @endif>{{ $service->name }}</option>
            @endforeach
        </select> -->
    </div>
    <div class="col-xs-12 col-lg-6 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable"> {{ trans('messages.website_link')}} </label>
        <input type="text" class="form-control @error('website_link') is-invalid @enderror" name="website_link" value="{{ isset($serviceInfo->website_link) ? $serviceInfo->website_link : old('website_link') }}" placeholder="{{ trans('messages.website_link')}}">
    </div>
    
</div>
<div class="row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable"> {{ trans('auth.any_additional_info')}} </label>
        <textarea row="5" class="form-control @error('add_info') is-invalid @enderror" name="add_info" value="{{ old('add_info') }}" autocomplete="add_info" placeholder="{{ trans('auth.any_additional_info') }}">{{isset($serviceInfo->additional_info) ? $serviceInfo->additional_info : null}}</textarea>
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable"> {{ trans('messages.photo')}} </label>
        <input id="care_home_qul_img" type="hidden" name="check_qul_img" value="{{ isset($medias[0]) ? $medias[0]['source'] : ''}}">
        <label for="care_home_photo" class="custom-file-upload care_home_photo my-accout-file"> {{ isset($medias[0]) ? substr($medias[0]['source'], -25) : trans('messages.photo') }}</label>
        <input id="care_home_photo" type="file" name="care_home_photo[]" accept="image/x-png,image/gif,image/jpeg" multiple/>   
     </div>
</div>
<div class="form-group row">
    <div class="images_preview_care_home_photo"></div>
</div>
<!-- End Home Care Service Provider-->