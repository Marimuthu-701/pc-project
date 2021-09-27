<!-- Individual Nurse/Trained Attendant/Physiotherapist/Occupational Therapist registration -->
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="{{ trans('auth.name')}} *">
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <select name="gender" class="form-control">
            <option value=""> {{ trans('messages.gender') }} *</option>
            @foreach ($getGender as $key => $value)
                <option value="{{$key}}"> {{ $value }} </option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <input type="text" class="form-control date-of-birth @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" placeholder="{{ trans('auth.dob_format') }} *">
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone" value="{{ isset($mobile_number) ? $mobile_number : old('contact_phone') }}" placeholder="{{ trans('auth.contact_phone')}} *" maxlength="10">
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
       <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ isset($email) ? $email :  old('email') }}"  placeholder="{{ trans('auth.email')}}">
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <select name="id_proof" class="form-control">
            <option value=""> {{ trans('messages.id_proof') }} *</option>
            @foreach ($getIdProof as $key => $value)
                <option value="{{ $key }}"> {{ $value }} </option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <input type="text" class="form-control @error('qualification') is-invalid @enderror" name="qualification" value="{{ old('qualification') }}" placeholder="{{ trans('auth.qualification')}} *">
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
       <input type="text" class="form-control @error('year_of_exp') is-invalid @enderror" name="year_of_exp" value="{{ old('year_of_exp') }}" placeholder="{{ trans('messages.years_of_experience')}} *">
    </div>
</div>
<div class="form-group row">
    <div class="col-xs-12 col-lg-6 register-form-input">
        <input type="text" class="form-control @error('area_of_specialization') is-invalid @enderror" name="area_of_specialization" value="{{ old('area_of_specialization') }}" placeholder="{{ trans('messages.area_of_specialization')}} *">
    </div>
    <div class="col-xs-12 col-lg-6 register-form-input">
        <input type="text" class="form-control @error('reg_no_or_licence_no') is-invalid @enderror" name="reg_no_or_licence_no" value="{{ old('reg_no_or_licence_no') }}" placeholder="{{ trans('messages.reg_no_or_licence_no')}} *">
    </div>
</div>
<div class="form-group row">
    <div class="col-xs-12 col-lg-6 register-form-input">
        <input type="text" class="form-control @error('currently_working_at') is-invalid @enderror" name="currently_working_at" value="{{ old('currently_working_at') }}" placeholder="{{ trans('auth.currently_working_at')}}">
    </div>
    <div class="col-xs-12 col-lg-6 register-form-input">
        <div class="input-group col-lg-12 col-xs-12">
            <input type="text" class="form-control nurse-fees" name="fees" value="{{ old('fees') }}" placeholder="{{ trans('messages.fees') }}">
            <select class="form-control col-lg-1 nurse-fees-type" name="fees_type">
            <option value="">{{ trans('messages.select_fees_type') }} </option>
                @foreach($getShift as $key => $value)
                    <option value="{{$key}}" @if(old('fees_type') == $key) selected="selected" @endif> {{ $value }} </option>
                @endforeach
            </select>
        </div>
        <div class="fees-type-error"></div>
        <!-- <select class="form-control" name="fees_type">
            <option value="">{{ trans('messages.select_fees_type') }} *</option>
            @foreach($getShift as $key => $value)
                <option value="{{$key}}"> {{ $value }} </option>
            @endforeach
        </select> -->
    </div>
</div>
<div class="form-group row">
    <div class="col-xs-12 col-lg-6 register-form-input">
        <select class="form-control search-state @error('state') is-invalid @enderror" name="state">
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
    <div class="col-lg-6 col-xs-12 register-form-input">
        <input type="text" class="form-control @error('pin_code') is-invalid @enderror" name="pin_code" value="{{ old('pin_code') }}" placeholder="{{ trans('auth.postal_code') }} *" maxlength="6">
    </div>
     <div class="col-lg-6 col-xs-12 register-form-input">
        <textarea row="5" class="form-control @error('add_info') is-invalid @enderror" name="add_info" value="{{ old('add_info') }}" autocomplete="add_info" placeholder="{{ trans('auth.any_additional_info') }}"></textarea>
     </div>
</div>
 <div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label for="profile_photo" class="custom-file-upload profile_photo"> {{ trans('messages.profile_photo') }}</label>
        <input id="profile_photo" type="file" name="profile_photo" accept="image/x-png,image/jpeg">   
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label for="upload_id_proof" class="custom-file-upload upload_id_proof"> {{ trans('messages.upload_id_proof') }} *</label>
        <input id="upload_id_proof" type="file" name="upload_id_proof[]" accept="image/x-png,image/jpeg,application/msword,application/pdf"  multiple/>
    </div>
 </div>
 <div class="form-group row">
    <div class="col-lg-3 col-xs-12 images_preview_profile_photo"></div>
    <div class="col-lg-9 col-xs-12 images_preview_upload_id_proof"></div>
</div> 
<!-- End Individual Nurse/Trained Attendant/Physiotherapist/Occupational Therapist registration -->
