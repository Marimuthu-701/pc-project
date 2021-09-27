<!-- Old Age home Form -->
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <input  type="text" class="form-control @error('home_name') is-invalid @enderror" name="name" value="{{ old('home_name') }}"  placeholder="{{ trans('auth.home_name')}} *" autofocus>
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
       <select  class="form-control @error('govt_approved') is-invalid @enderror" name="govt_approved">
            <option value=""> {{ trans('messages.govt_approved') }} *</option>
            @foreach($govtApproved as $key=>$value)
                <option value="{{ $key }}"> {{ $value }} </option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
       <input type="text" class="form-control @error('reg_no_or_licence_no') is-invalid @enderror" name="old_age_home_reg_no" value="{{ old('old_age_home_reg_no') }}" placeholder="{{ trans('messages.reg_no_or_licence_no')}}">
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <input  type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" value="{{ old('contact_person') }}" placeholder="{{ trans('auth.contact_person')}} *" autofocus>
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone" value="{{ old('contact_phone') }}"  placeholder="{{ trans('auth.contact_phone')}} *" maxlength="10" autofocus>
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <input id="number_of_rooms" type="text" class="form-control @error('number_of_rooms') is-invalid @enderror" name="number_of_rooms" value="{{ old('number_of_rooms') }}" placeholder="{{ trans('auth.number_of_rooms')}} *" autofocus>
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input" id="available_facility">
       <select  class="form-control @error('facilities_available') is-invalid @enderror" name="facilities_available[]" multiple>
            <option value=""> {{ trans('auth.facilities_available') }} *</option>
            @foreach( $facilities as $key => $value)
                <option value="{{ $value->id }}"> {{ $value->name }} </option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <input  type="text" class="form-control @error('room_rent') is-invalid @enderror" name="room_rent" value="{{ old('room_rent') }}"  placeholder="{{ trans('messages.room_rent').' '.trans('messages.room_rent_rate') }}" autofocus>
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <textarea type="text" class="form-control @error('other_facilities_available') is-invalid @enderror" name="other_facilities_available" value="{{ old('other_facilities_available') }}" placeholder="{{ trans('auth.other_facilities') }}"></textarea>
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <textarea  row="5" class="form-control @error('old_home_address') is-invalid @enderror" name="old_home_address" value="{{ old('old_home_address') }}"  placeholder="{{ trans('auth.address') }}"></textarea>
    </div>
</div>
<div class="form-group row">
    <div class="col-xs-12 col-lg-6 register-form-input">
        <select class="form-control search-state @error('state') is-invalid @enderror" name="state" >
            <option value="">{{ trans('auth.select_state') }} *</option>
            @foreach($states as $key => $state)
                <option value="{{ $state->code }}">{{ $state->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-xs-12 col-lg-6 register-form-input">
        <select class="form-control city-drop-list @error('city') is-invalid @enderror" name="city" disabled="disabled">
            <option value="">{{ trans('messages.select_city') }} *</option>
            @foreach($cities as $key => $citie)
                <option value="{{ $citie->name }}">{{ $citie->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <div class="col-xs-12 col-lg-6 register-form-input">
        <input  type="text" class="form-control @error('pin_code') is-invalid @enderror" name="pin_code" value="{{ old('pin_code') }}" placeholder="{{ trans('auth.postal_code') }} *" maxlength="6">
    </div>
    <div class="col-xs-12 col-lg-6 register-form-input">
        <input type="text" class="form-control @error('landline_number') is-invalid @enderror" name="landline_number" value="{{ old('landline_number') }}"  placeholder="{{ trans('messages.landline_number')}}">
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <textarea  row="5" class="form-control @error('add_info') is-invalid @enderror" name="add_info" value="{{ old('add_info') }}" placeholder="{{ trans('auth.any_additional_info') }}"></textarea>
    </div>
    <div class="col-xs-12 col-lg-6 register-form-input">
        <input type="text" class="form-control @error('website_link') is-invalid @enderror" name="website_link" value="{{ old('website_link') }}" placeholder="{{ trans('messages.website_link')}}">
    </div>
    
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label for="home_avatar" class="custom-file-upload home_avatar"> {{ trans('messages.photo') }}</label>
        <input id="home_avatar" type="file" name="home_avatar[]" accept="image/x-png,image/gif,image/jpeg" multiple/>
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label for="profile_photo" class="custom-file-upload profile_photo"> {{ trans('messages.profile_photo') }}</label>
        <input id="profile_photo" type="file" name="profile_photo" accept="image/x-png,image/jpeg">   
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 images_preview_profile_photo"></div>
</div>
<div class="form-group row">
    <div class="images_preview_home_avatar"></div>
</div>
<!-- End old age home form -->