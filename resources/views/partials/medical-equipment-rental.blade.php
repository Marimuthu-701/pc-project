<!-- Medical Equipment Rental -->
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <input  type="text" class="form-control @error('company_name') is-invalid @enderror" name="name" value="{{ old('company_name') }}" placeholder="{{ trans('messages.company_name')}} *">
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
       <input type="text" class="form-control @error('reg_no_or_licence_no') is-invalid @enderror" name="reg_no_or_licence_no" value="{{ old('reg_no_or_licence_no') }}" placeholder="{{ trans('messages.reg_no_or_licence_no')}} *">
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <input type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" value="{{ old('contact_person') }}"  placeholder="{{ trans('auth.contact_person')}} *">
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone" value="{{ old('contact_phone') }}" placeholder="{{ trans('auth.contact_phone')}} *" maxlength="10">
    </div>
</div>

<div class="form-group row">
     <div class="col-lg-6 col-xs-12 register-form-input">
        <textarea  row="5" class="form-control @error('address') is-invalid @enderror" name="medical_address" value="{{ old('medical_address') }}" placeholder="{{ trans('auth.address') }}"></textarea>
    </div>
    <div class="col-xs-12 col-lg-6 register-form-input">
        <select class="form-control search-state @error('state') is-invalid @enderror" name="state" >
            <option value="">{{ trans('auth.select_state') }} *</option>
            @foreach($states as $key => $state)
                <option value="{{ $state->code }}">{{ $state->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <div class="col-xs-12 col-lg-6 register-form-input">
        <select class="form-control city-drop-list @error('city') is-invalid @enderror" name="city" disabled="disabled">
            <option value="">{{ trans('messages.select_city') }} *</option>
            @foreach($cities as $key => $citie)
                <option value="{{ $citie->name }}">{{ $citie->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-xs-12 col-lg-6 register-form-input">
        <input type="text" class="form-control @error('pin_code') is-invalid @enderror" name="pin_code" value="{{ old('pin_code') }}" placeholder="{{ trans('auth.postal_code') }} *" maxlength="6">
    </div>
</div>
<div class="form-group row">
    <div class="col-xs-12 col-lg-6 register-form-input">
        <input type="text" class="form-control @error('landline_number') is-invalid @enderror" name="landline_number" value="{{ old('landline_number') }}"  placeholder="{{ trans('messages.landline_number')}}">
    </div>
    <div class="col-xs-12 col-lg-6 register-form-input">
        <input type="text" class="form-control @error('website_link') is-invalid @enderror" name="website_link" value="{{ old('website_link') }}" placeholder="{{ trans('messages.website_link')}}">
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <textarea row="5" class="form-control @error('add_info') is-invalid @enderror" name="add_info" value="{{ old('add_info') }}" autocomplete="add_info" placeholder="{{ trans('auth.any_additional_info') }}"></textarea>
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label for="medical_profile_photo" class="custom-file-upload"> {{ trans('messages.photo') }}</label>
        <input id="medical_profile_photo" type="file" name="medical_profile_photo[]" accept="image/x-png,image/gif,image/jpeg" multiple>   
     </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label for="profile_photo" class="custom-file-upload profile_photo"> {{ trans('messages.profile_photo') }}</label>
        <input id="profile_photo" type="file" name="profile_photo" accept="image/x-png,image/jpeg">   
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-9 col-xs-12 images_preview_medical_profile_photo"></div>
    <div class="col-lg-3 col-xs-12 images_preview_profile_photo"></div>
</div>
<!-- End Medical Equipment Rental -->