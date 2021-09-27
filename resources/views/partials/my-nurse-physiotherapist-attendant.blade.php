@php
    $dobConvert = null;
    if(isset($serviceInfo->dob) && !empty($serviceInfo->dob)) {
        $dobConvert = date('d-m-Y',strtotime($serviceInfo->dob));
    }
    $fees_type = null;
    $fees_amount = null;
    if(isset($serviceInfo->fees_per_shift) && !empty($serviceInfo->fees_per_shift)) {
        $fees_type = App\Models\User::PER_SHIFT;
        $fees_amount = $serviceInfo->fees_per_shift;
    } else if (isset($serviceInfo->fees_per_day) && !empty($serviceInfo->fees_per_day)) {
        $fees_type = App\Models\User::PER_DAY;
        $fees_amount = $serviceInfo->fees_per_day;
    }
@endphp
<!-- Individual Nurse/Trained Attendant/Physiotherapist/Occupational Therapist registration -->
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.name')}} </label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset($serviceInfo->name) ? $serviceInfo->name :  old('name') }}" placeholder="{{ trans('auth.name')}}">
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('messages.gender')}} </label>
        <select name="gender" class="form-control">
            <option value=""> {{ trans('messages.gender') }}</option>
            @foreach ($getGender as $key => $value)
                <option value="{{$key}}" @if($serviceInfo->gender == $key) selected="selected" @endif> {{ $value }} </option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.dob_format')}} </label>
        <input type="text" class="form-control date-of-birth @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ isset($dobConvert) ? $dobConvert : old('date_of_birth') }}" placeholder="{{ trans('auth.dob_format') }}">
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.contact_phone')}} </label>
        <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone" value="{{ isset($serviceInfo->contact_phone) ? $serviceInfo->contact_phone : old('contact_phone') }}" placeholder="{{ trans('auth.contact_phone')}}" maxlength="10">
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable"> {{ trans('auth.email')}} </label>
       <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ isset($serviceInfo->contact_email) ? $serviceInfo->contact_email : old('email') }}"  placeholder="{{ trans('auth.email')}}">
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('messages.id_proof')}} </label>
        <select name="id_proof" class="form-control">
            <option value=""> {{ trans('messages.id_proof') }}</option>
            @foreach ($getIdProof as $key => $value)
                <option value="{{ $key }}" @if($serviceInfo->id_proof == $key) selected="selected" @endif> {{ $value }} </option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.qualification')}} </label>
        <input type="text" class="form-control @error('qualification') is-invalid @enderror" name="qualification" value="{{ isset($serviceInfo->qualification) ? $serviceInfo->qualification : old('qualification') }}" placeholder="{{ trans('auth.qualification')}}">
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('messages.years_of_experience')}} </label>
       <input type="text" class="form-control @error('year_of_exp') is-invalid @enderror" name="year_of_exp" value="{{ isset($serviceInfo->total_experience) ? $serviceInfo->total_experience : old('year_of_exp') }}" placeholder="{{ trans('messages.years_of_experience')}}">
    </div>
</div>
<div class="form-group row">
    <div class="col-xs-12 col-lg-6 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('messages.area_of_specialization')}} </label>
        <input type="text" class="form-control @error('area_of_specialization') is-invalid @enderror" name="area_of_specialization" value="{{ isset($serviceInfo->specialization_area) ? $serviceInfo->specialization_area : old('area_of_specialization') }}" placeholder="{{ trans('messages.area_of_specialization')}}">
    </div>
    <div class="col-xs-12 col-lg-6 register-form-input">
        <label class="col-lg-12 col-form-label my-account-lable required"> {{ trans('messages.reg_no_or_licence_no')}} </label>
        <input type="text" class="form-control @error('reg_no_or_licence_no') is-invalid @enderror" name="reg_no_or_licence_no" value="{{ isset($serviceInfo->registration_number) ? $serviceInfo->registration_number : old('reg_no_or_licence_no') }}" placeholder="{{ trans('messages.reg_no_or_licence_no')}}">
    </div>
</div>
<div class="form-group row">
    <div class="col-xs-12 col-lg-6 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable"> {{ trans('auth.currently_working_at')}} </label>
        <input type="text" class="form-control @error('currently_working_at') is-invalid @enderror" name="currently_working_at" value="{{ isset($serviceInfo->working_at) ? $serviceInfo->working_at : old('currently_working_at') }}" placeholder="{{ trans('auth.currently_working_at')}}">
    </div>
    <div class="col-xs-12 col-lg-6 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable"> {{ trans('messages.fees')}} </label>
        <div class="input-group col-lg-12 col-xs-12">
            <input type="text" class="form-control nurse-fees" name="fees" value="{{ isset($fees_amount) ? $fees_amount : old('fees') }}" placeholder="{{ trans('messages.fees') }}">
            <select class="form-control col-lg-1 nurse-fees-type" name="fees_type">
            <option value="">{{ trans('messages.select_fees_type') }} </option>
                @foreach($getShift as $key => $value)
                    <option value="{{$key}}" @if($fees_type == $key) selected="selected" @endif> {{ $value }} </option>
                @endforeach
            </select>
        </div>
        <div class="fees-type-error"></div>
    </div>
</div>
<div class="form-group row">
    <div class="col-xs-12 col-lg-6 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.select_state')}} </label>
        <select class="form-control search-state @error('state') is-invalid @enderror" name="state">
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
                <option value="{{ $citie->name }}" @if($serviceInfo->city == $citie->name) selected="selected" @endif >{{ $citie->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.postal_code')}} </label>
        <input type="text" class="form-control @error('pin_code') is-invalid @enderror" name="pin_code" value="{{ isset($serviceInfo->postal_code) ? $serviceInfo->postal_code : old('pin_code') }}" placeholder="{{ trans('auth.postal_code') }}" maxlength="6">
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable"> {{ trans('auth.any_additional_info')}} </label>
        <textarea row="5" class="form-control @error('add_info') is-invalid @enderror" name="add_info" placeholder="{{ trans('auth.any_additional_info') }}">{{ isset($serviceInfo->additional_info) ? $serviceInfo->additional_info : old('add_info') }}</textarea>
     </div>
</div>
 <div class="form-group row">
     <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('messages.upload_id_proof')}} </label>
        <input id="id_proof_img" type="hidden" name="check_qul_img" value="{{ isset($idProofDetail[0]['id_proof_url']) ? $idProofDetail[0]['id_proof_url'] : ''}}">
        <label for="upload_id_proof" class="custom-file-upload upload_id_proof my-accout-file"> {{ isset($idProofDetail[0]['id_proof_url']) ? substr ($idProofDetail[0]['id_proof_url'], -25) :trans('messages.upload_id_proof') }}</label>
        <input id="upload_id_proof" type="file" name="upload_id_proof[]" accept="image/x-png,image/jpeg,application/msword,application/pdf" multiple/>
     </div>
 </div>
<div class="row id-proof-image-view">
    @if(count($idProofDetail) > 0)
        @foreach($idProofDetail as $key => $value)
        <div class="col-lg-2 col-xs-12 register-form-input media-div">
            @if($value['type'] != "file")
            <a href="{{ $value['id_proof_url'] }}" target="_blank">
                <img src="{{ $value['id_thumb'] }}" class="service-image">
            </a>
            @else
                <a href="{{ $value['id_proof_url'] }}" target="_blank" class="service-file"> {{ substr ($value['id_proof_url'], -25) }} </a>
            @endif
        </div>
        @endforeach
    @endif
</div>
 <div class="form-group row">
    <div class="col-lg-12 col-xs-12 images_preview_upload_id_proof"></div>
</div> 
<!-- End Individual Nurse/Trained Attendant/Physiotherapist/Occupational Therapist registration -->