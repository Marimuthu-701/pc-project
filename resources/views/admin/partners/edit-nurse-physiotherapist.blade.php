<!-- Individual Nurse/Trained Attendant/Physiotherapist/Occupational Therapist registration -->
@php
    $dob = null;
    if ($serviceInfo->dob) {
        $dob = date('d-m-Y', strtotime($serviceInfo->dob));
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
<div class="row">
    <div class="col-md-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.name') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset($serviceInfo->name) ? $serviceInfo->name : old('name') }}" placeholder="{{ trans('auth.name')}}">
        </div>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('messages.gender') }}<span class="required">&nbsp;*</span></label>
            <select name="gender" class="form-control">
                <option value=""> {{ trans('messages.gender') }} </option>
                @foreach ($getGender as $key => $value)
                    <option value="{{$key}}" @if($key == $serviceInfo->gender) selected="selected" @endif> {{ $value }} </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.dob') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control date-of-birth @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ isset($dob) ? $dob :old('date_of_birth') }}" placeholder="{{ trans('auth.dob') }} ">
            @if($errors->has('date_of_birth'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('date_of_birth') }}</strong>
                </div>
            @endif
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.contact_phone') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone" value="{{isset($serviceInfo->contact_phone) ? $serviceInfo->contact_phone :  old('contact_phone') }}" placeholder="{{ trans('auth.contact_phone') }} " maxlength="10">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{  trans('auth.email') }}</span></label>
            <input type="text" class="form-control @error('contact_email') is-invalid @enderror" name="contact_email" value="{{ isset($serviceInfo->contact_email) ? $serviceInfo->contact_email : old('contact_email') }}"  placeholder="{{ trans('auth.email')}}">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{  trans('messages.id_proof') }}<span class="required">&nbsp;*</span></label>
            <select name="id_proof" class="form-control">
                <option value=""> {{ trans('messages.id_proof') }}</option>
                @foreach ($getIdProof as $key => $value)
                    <option value="{{ $key }}" @if($key == $serviceInfo->id_proof) selected="selected" @endif> {{ $value }} </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.qualification') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('qualification') is-invalid @enderror" name="qualification" value="{{ isset($serviceInfo->qualification) ? $serviceInfo->qualification : old('qualification') }}" placeholder="{{ trans('auth.qualification')}}">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('messages.years_of_experience') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('year_of_exp') is-invalid @enderror" name="year_of_exp" value="{{isset($serviceInfo->total_experience) ? $serviceInfo->total_experience :  old('year_of_exp') }}" placeholder="{{ trans('messages.years_of_experience')}} ">
        </div>
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('messages.area_of_specialization') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('area_of_specialization') is-invalid @enderror" name="area_of_specialization" value="{{ isset($serviceInfo->specialization_area) ? $serviceInfo->specialization_area : old('area_of_specialization') }}" placeholder="{{ trans('messages.area_of_specialization') }}">
        </div>
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('messages.reg_no_or_licence_no') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('reg_no_or_licence_no') is-invalid @enderror" name="reg_no_or_licence_no" value="{{ isset($serviceInfo->registration_number) ? $serviceInfo->registration_number : old('reg_no_or_licence_no') }}" placeholder="{{ trans('messages.reg_no_or_licence_no')}}">
        </div>
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('auth.currently_working_at') }}</label>
            <input type="text" class="form-control @error('currently_working_at') is-invalid @enderror" name="currently_working_at" value="{{ isset($serviceInfo->working_at) ? $serviceInfo->working_at :  old('currently_working_at') }}" placeholder="{{ trans('auth.currently_working_at')}}">
        </div>      
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('messages.fees') }}</label>
            <div class="input-group">
                <select class="form-control nurse-fees-type col-md-3 @error('fees_type') is-invalid @enderror" name="fees_type">
                <option value="">{{ trans('messages.select_fees_type') }} </option>
                    @foreach($getShift as $key => $value)
                        <option value="{{$key}}" @if($fees_type == $key) selected="selected" @endif> {{ $value }} </option>
                    @endforeach
                </select>
                <input type="text" class="form-control nurse-fees @error('fees') is-invalid @enderror" name="fees" value="{{ isset($fees_amount) ? $fees_amount : old('fees') }}" placeholder="{{ trans('messages.fees') }}">
            </div>
            <div class="fees-type-error"></div>
            <!-- <label>{{ trans('messages.fees') }}</label>
            <input type="text" class="form-control @error('fees') is-invalid @enderror" name="fees" value="{{ isset($fees_amount) ? $fees_amount : old('fees') }}" placeholder="{{ trans('messages.fees') }} *"> -->
        </div>
    </div>
    <!-- <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('messages.select_fees_type') }}</label>
            <input type="hidden" name="fees_type" value="{{ $fees_type }}">
            <select class="form-control" name="fees_type" @if($fees_type) disabled="disabled" @endif>
                <option value="">{{ trans('messages.select_fees_type') }} *</option>
                @foreach($getShift as $key => $value)
                    <option value="{{$key}}" @if($fees_type == $key) selected="selected" @endif> {{ $value }} </option>
                @endforeach
            </select>
        </div>
    </div> -->
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('auth.select_state') }}<span class="required">&nbsp;*</span></label>
            <select class="form-control search-state @error('state') is-invalid @enderror" name="state">
                <option value="">{{ trans('auth.select_state') }}</option>
                @foreach($states as $key => $state)
                    <option value="{{ $state->code }}" @if($state->code == $serviceInfo->state) selected="selected" @endif>{{ $state->name }}</option>
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
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.postal_code') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('pin_code') is-invalid @enderror" name="pin_code" value="{{ isset($serviceInfo->postal_code) ? $serviceInfo->postal_code :  old('pin_code') }}" placeholder="{{ trans('auth.postal_code') }}" maxlength="6">
        </div>
    </div>
     <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.any_additional_info') }}</label>
            <textarea row="5" class="form-control @error('add_info') is-invalid @enderror" name="add_info" placeholder="{{ trans('auth.any_additional_info') }}">{{ isset($serviceInfo->additional_info) ? $serviceInfo->additional_info : null }}</textarea>
        </div>
     </div>
     <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('messages.upload_id_proof') }}<span class="required">&nbsp;*</span></label><br/>
            <input type="hidden" name="id_proof_imag" id="id_proof_imag" value="{{isset($idProofUrlType[0]['name']) ? $idProofUrlType[0]['name'] : null}}">
            <input id="upload_id_proof" type="file" name="upload_id_proof[]" accept="image/x-png,image/gif,image/jpeg" multiple/>
        </div>
            <div class="row"> 
                @if(count($idProofUrlType) > 0)
                    @foreach($idProofUrlType as $key=>$value)
                    <div class="col-lg-3">
                        @if($value['type']!='file')
                            <a href="{{$value['id_proof_url']}}" target="_blank">
                                <img src="{{ $value['id_proof_thump_url'] }}" class="service-image">
                            </a>
                        @else
                            <a href="{{ $value['id_proof_url'] }}" target="_blank" class="service-file"> {{ substr ($value['name'], -25) }} </a>
                        @endif
                    </div>
                    @endforeach
                @endif
            </div>
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
<!-- End Individual Nurse/Trained Attendant/Physiotherapist/Occupational Therapist registration -->