<!-- Old Age home Form -->
<div class="row">
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.home_name') }}<span class="required">&nbsp;*</span></label>
            <input  type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset($serviceInfo->name) ? $serviceInfo->name : old('name') }}"  placeholder="{{ trans('auth.home_name') }}">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('messages.govt_approved') }}<span class="required">&nbsp;*</span></label>
            <select  class="form-control @error('govt_approved') is-invalid @enderror" name="govt_approved">
                @foreach($govtApproved as $key=>$value)
                    <option value="{{ $key }}" @if($serviceInfo->govt_approved == $key) selected="selected" @endif> {{ $value }} </option>
                @endforeach
            </select>
            @if($errors->has('govt_approved'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('govt_approved') }}</strong>
                </div>
            @endif
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('messages.reg_no_or_licence_no') }}</label>
            <input type="text" class="form-control @error('reg_no_or_licence_no') is-invalid @enderror" name="old_age_home_reg_no" value="{{ isset($serviceInfo->registration_number) ? $serviceInfo->registration_number : old('old_age_home_reg_no') }}" placeholder="{{ trans('messages.reg_no_or_licence_no')}}">
            @if($errors->has('old_age_home_reg_no'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('old_age_home_reg_no') }}</strong>
                </div>
            @endif
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.contact_person') }}<span class="required">&nbsp;*</span></label>
            <input  type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" value="{{ isset($serviceInfo->contact_person) ? $serviceInfo->contact_person :  old('contact_person') }}" placeholder="{{ trans('auth.contact_person') }}">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.contact_phone') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone" value="{{ isset($serviceInfo->contact_phone) ? $serviceInfo->contact_phone :  old('contact_phone') }}"  placeholder="{{ trans('auth.contact_phone') }}" maxlength="10">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.number_of_rooms') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('number_of_rooms') is-invalid @enderror" name="number_of_rooms" value="{{ isset($serviceInfo->no_of_rooms) ? $serviceInfo->no_of_rooms : old('number_of_rooms') }}" placeholder="{{ trans('auth.number_of_rooms') }}">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.facilities_available') }}<span class="required">&nbsp;*</span></label>
            <select  class="form-control @error('facilities_available') is-invalid @enderror" name="facilities_available[]" multiple>
                @foreach( $facilities as $key => $value)
                    <option value="{{ $value->id }}" @if( isset($selectedfecility[$value->id]) && ( $selectedfecility[$value->id] == $value->id)) selected="selected" @endif > {{ $value->name }} </option>
                @endforeach
            </select>
            @if($errors->has('facilities_available'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('facilities_available') }}</strong>
                </div>
            @endif
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('messages.room_rent').' '.trans('messages.room_rent_rate') }}</label>
            <input  type="text" class="form-control @error('room_rent') is-invalid @enderror" name="room_rent" value="{{ isset($serviceInfo->room_rent) ? $serviceInfo->room_rent : old('room_rent') }}"  placeholder="{{ trans('messages.room_rent').' '.trans('messages.room_rent_rate') }}">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.other_facilities_available') }}</label>
            <textarea type="text" class="form-control @error('other_facilities_available') is-invalid @enderror" name="other_facilities_available" placeholder="{{ trans('auth.other_facilities_available') }}"> {{ isset($serviceInfo->other_facilities) ? $serviceInfo->other_facilities : old('other_facilities_available') }}</textarea>
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.address') }}</label>
            <textarea  row="5" class="form-control @error('old_home_address') is-invalid @enderror" name="old_home_address"  placeholder="{{ trans('auth.address') }}">{{ isset($serviceInfo->address) ? $serviceInfo->address : old('old_home_address') }}</textarea>
        </div>
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('auth.select_state') }}<span class="required">&nbsp;*</span></label>
            <select class="form-control search-state @error('state') is-invalid @enderror" name="state" >
                <option value="">{{ trans('auth.select_state') }}</option>
                @foreach($states as $key => $state)
                    <option value="{{ $state->code }}" @if($serviceInfo->state == $state->code) selected="selected" @endif>{{ $state->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('messages.select_city') }}<span class="required">&nbsp;*</span></label>
            <select class="form-control city-drop-list @error('city') is-invalid @enderror" name="city">
                <option value="">{{ trans('messages.select_city') }} </option>
                @foreach($cities as $key => $citie)
                    <option value="{{ $citie->name }}" @if($serviceInfo->city == $citie->name) selected="selected" @endif>{{ $citie->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('auth.postal_code') }}<span class="required">&nbsp;*</span></label>
            <input  type="text" class="form-control @error('pin_code') is-invalid @enderror" name="pin_code" value="{{ isset($serviceInfo->postal_code) ? $serviceInfo->postal_code : old('pin_code') }}" placeholder="{{ trans('auth.postal_code') }}" maxlength="6">
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
            <label>{{ trans('messages.website_link') }}</label>
            <input type="text" class="form-control @error('website_link') is-invalid @enderror" name="website_link" value="{{ isset($serviceInfo->website_link) ? $serviceInfo->website_link : old('website_link') }}" placeholder="{{ trans('messages.website_link')}}">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.any_additional_info') }}</label>
            <textarea  row="5" class="form-control @error('add_info') is-invalid @enderror" name="add_info" placeholder="{{ trans('auth.any_additional_info') }}">{{ isset($serviceInfo->additional_info) ? $serviceInfo->additional_info : old('add_info') }}</textarea>
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('messages.photo') }}</label><br/>
            <input type="hidden" name="old_age_img" value="{{ isset($serviceMedia[0]['file']) ? $serviceMedia[0]['file'] : null }}" id="old_age_img">
            <input id="home_avatar" type="file" name="home_avatar[]" accept="image/x-png,image/gif,image/jpeg" multiple/>
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
<!-- End old age home form -->