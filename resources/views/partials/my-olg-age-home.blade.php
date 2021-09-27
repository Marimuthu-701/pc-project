<!-- Old Age home Form -->
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label for="name" class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.home_name')}} </label>
        <input  type="text" class="form-control @error('home_name') is-invalid @enderror" name="name" value="{{ isset($serviceInfo->name) ? $serviceInfo->name : old('home_name') }}"  placeholder="{{ trans('auth.home_name')}}">
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label for="name" class="col-lg-6 col-form-label my-account-lable required"> {{ trans('messages.govt_approved') }}</label>
        <select  class="form-control @error('govt_approved') is-invalid @enderror" name="govt_approved">
            @foreach($govtApproved as $key=>$value)
                <option value="{{ $key }}" @if($key == $serviceInfo->govt_approved) selected="selected" @endif> {{ $value }} </option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label for="name" class="col-lg-6 col-form-label my-account-lable"> {{ trans('messages.reg_no_or_licence_no')}} </label>
        <input type="text" class="form-control @error('reg_no_or_licence_no') is-invalid @enderror" name="old_age_home_reg_no" value="{{ isset($serviceInfo->registration_number) ? $serviceInfo->registration_number : old('old_age_home_reg_no') }}" placeholder="{{ trans('messages.reg_no_or_licence_no')}}">
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label for="contact_person" class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.contact_person')}} </label>
        <input  type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" value="{{ isset($serviceInfo->contact_person) ? $serviceInfo->contact_person : old('contact_person') }}" placeholder="{{ trans('auth.contact_person')}}">
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label for="contact_phone" class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.contact_phone')}} </label>
        <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone" value="{{ isset($serviceInfo->contact_phone) ? $serviceInfo->contact_phone : old('contact_phone') }}"  placeholder="{{ trans('auth.contact_phone')}}" maxlength="10">
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label for="number_of_rooms" class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.number_of_rooms')}} </label>
        <input id="number_of_rooms" type="text" class="form-control @error('number_of_rooms') is-invalid @enderror" name="number_of_rooms" value="{{ isset($serviceInfo->no_of_rooms) ? $serviceInfo->no_of_rooms : old('number_of_rooms') }}" placeholder="{{ trans('auth.number_of_rooms')}}">
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input" id="available_facility">
        <label for="facilities_available" class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.facilities_available')}} </label>
       <select  class="form-control @error('facilities_available') is-invalid @enderror" name="facilities_available[]" multiple>
            @foreach( $facilities as $key => $value)
                <option value="{{ $value->id }}" @if( isset($selectedfecility[$value->id]) && ( $selectedfecility[$value->id] == $value->id)) selected="selected" @endif > {{ $value->name }} </option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label for="room_rent" class="col-lg-6 col-form-label my-account-lable"> {{ trans('messages.room_rent').' '.trans('messages.room_rent_rate') }} </label>
        <input  type="text" class="form-control @error('room_rent') is-invalid @enderror" name="room_rent" value="{{ isset($serviceInfo->room_rent) ? $serviceInfo->room_rent : old('room_rent') }}"  placeholder="{{ trans('messages.room_rent').' '.trans('messages.room_rent_rate') }}" autofocus>
        
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label for="other_facilities" class="col-lg-6 col-form-label my-account-lable"> {{ trans('auth.other_facilities')}} </label>
        <textarea type="text" class="form-control @error('other_facilities_available') is-invalid @enderror" name="other_facilities_available" placeholder="{{ trans('auth.other_facilities_available') }}">{{ isset($serviceInfo->other_facilities) ? $serviceInfo->other_facilities : null}}</textarea>
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label for="old_home_address" class="col-lg-6 col-form-label my-account-lable"> {{ trans('auth.address')}} </label>
        <textarea  row="5" class="form-control @error('old_home_address') is-invalid @enderror" name="old_home_address" placeholder="{{ trans('auth.address') }}">{{isset($serviceInfo->address) ? $serviceInfo->address : null }}</textarea>
    </div>
</div>
<div class="form-group row">
    <div class="col-xs-12 col-lg-6 register-form-input">
        <label for="select_state" class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.select_state')}} </label>
        <select class="form-control search-state @error('state') is-invalid @enderror" name="state" >
            <option value="">{{ trans('auth.select_state') }}</option>
            @foreach($states as $key => $state)
                <option value="{{ $state->code }}" @if($serviceInfo->state == $state->code) selected="selected" @endif>{{ $state->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-xs-12 col-lg-6 register-form-input">
        <label for="select_city" class="col-lg-6 col-form-label my-account-lable required"> {{ trans('messages.select_city')}} </label>
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
        <label for="postal_code" class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.postal_code')}} </label>
        <input  type="text" class="form-control @error('pin_code') is-invalid @enderror" name="pin_code" value="{{ isset($serviceInfo->postal_code) ? $serviceInfo->postal_code : old('pin_code') }}" placeholder="{{ trans('auth.postal_code') }}" maxlength="6">
    </div>
     <div class="col-xs-12 col-lg-6 register-form-input">
        <label for="postal_code" class="col-lg-6 col-form-label my-account-lable"> {{ trans('messages.landline_number')}} </label>
        <input type="text" class="form-control @error('landline_number') is-invalid @enderror" name="landline_number" value="{{ isset($serviceInfo->landline_number) ? $serviceInfo->landline_number : old('landline_number') }}"  placeholder="{{ trans('messages.landline_number') }}">
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label for="any_additional_info" class="col-lg-6 col-form-label my-account-lable"> {{ trans('auth.any_additional_info')}} </label>
        <textarea  row="5" class="form-control @error('add_info') is-invalid @enderror" name="add_info" placeholder="{{ trans('auth.any_additional_info') }}">{{ isset($serviceInfo->additional_info) ? $serviceInfo->additional_info : null }}</textarea>
    </div>
    <div class="col-xs-12 col-lg-6 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable"> {{ trans('messages.website_link')}} </label>
        <input type="text" class="form-control @error('website_link') is-invalid @enderror" name="website_link" value="{{ isset($serviceInfo->website_link) ? $serviceInfo->website_link : old('website_link') }}" placeholder="{{ trans('messages.website_link')}}">
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label for="home_avatar" class="col-lg-6 col-form-label my-account-lable">{{ trans('messages.photo')}}</label>
        <label for="home_avatar" class="custom-file-upload home_avatar my-accout-file">{{ isset($medias[0]) ? substr($medias[0]['source'], -25 ) : trans('messages.photo') }} </label>
        <input id="check_qul_img" type="hidden" name="check_qul_img" value="{{ isset($medias[0]) ? $medias[0]['source'] : ''}}">
        <input id="home_avatar" type="file" name="home_avatar[]" accept="image/x-png,image/gif,image/jpeg" multiple/>
    </div>
</div>
<div class="form-group row">
    <div class="images_preview_home_avatar"></div>
</div>
<!-- End old age home form -->