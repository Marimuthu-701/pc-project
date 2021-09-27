<!-- Individual Nurse/Trained Attendant/Physiotherapist/Occupational Therapist registration -->
<div class="row">
    <div class="col-md-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.name') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="{{ trans('auth.name')}}">
        </div>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('messages.gender') }}<span class="required">&nbsp;*</span></label>
            <select name="gender" class="form-control">
                <option value=""> {{ trans('messages.gender') }} </option>
                @foreach ($getGender as $key => $value)
                    <option value="{{$key}}" @if($key == old('gender')) selected="selected" @endif> {{ $value }} </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.dob_format') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control date-of-birth @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" placeholder="{{ trans('auth.dob_format') }} ">
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
            <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone" value="{{ old('contact_phone') }}" placeholder="{{ trans('auth.contact_phone') }} " maxlength="10">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{  trans('auth.email') }}</span></label>
            <input type="text" class="form-control @error('contact_email') is-invalid @enderror" name="contact_email" value="{{ old('contact_email') }}"  placeholder="{{ trans('auth.email')}}">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{  trans('messages.id_proof') }}<span class="required">&nbsp;*</span></label>
            <select name="id_proof" class="form-control">
                <option value=""> {{ trans('messages.id_proof') }}</option>
                @foreach ($getIdProof as $key => $value)
                    <option value="{{ $key }}" @if($key == old('id_proof')) selected="selected" @endif> {{ $value }} </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.qualification') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('qualification') is-invalid @enderror" name="qualification" value="{{ old('qualification') }}" placeholder="{{ trans('auth.qualification')}}">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('messages.years_of_experience') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('year_of_exp') is-invalid @enderror" name="year_of_exp" value="{{ old('year_of_exp') }}" placeholder="{{ trans('messages.years_of_experience')}} ">
        </div>
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('messages.area_of_specialization') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('area_of_specialization') is-invalid @enderror" name="area_of_specialization" value="{{ old('area_of_specialization') }}" placeholder="{{ trans('messages.area_of_specialization') }}">
        </div>
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('messages.reg_no_or_licence_no') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('reg_no_or_licence_no') is-invalid @enderror" name="reg_no_or_licence_no" value="{{ old('reg_no_or_licence_no') }}" placeholder="{{ trans('messages.reg_no_or_licence_no')}}">
        </div>
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('auth.currently_working_at') }}</label>
            <input type="text" class="form-control @error('currently_working_at') is-invalid @enderror" name="currently_working_at" value="{{ old('currently_working_at') }}" placeholder="{{ trans('auth.currently_working_at')}}">
        </div>      
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('messages.fees') }}</label>
             <div class="input-group">
                <select class="form-control nurse-fees-type col-md-3 @error('fees_type') is-invalid @enderror" name="fees_type">
                <option value="">{{ trans('messages.select_fees_type') }} </option>
                    @foreach($getShift as $key => $value)
                        <option value="{{$key}}" @if(old('fees_type') == $key) selected="selected" @endif> {{ $value }} </option>
                    @endforeach
                </select>
                <input type="text" class="form-control nurse-fees @error('fees') is-invalid @enderror" name="fees" value="{{ old('fees') }}" placeholder="{{ trans('messages.fees') }}">
              </div>
              <div class="fees-type-error"></div>
        </div>
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('auth.select_state') }}<span class="required">&nbsp;*</span></label>
            <select class="form-control search-state @error('state') is-invalid @enderror" name="state">
                <option value="">{{ trans('auth.select_state') }}</option>
                @foreach($states as $key => $state)
                    <option value="{{ $state->code }}" @if($state->code == old('state')) selected="selected" @endif>{{ $state->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('messages.select_city') }}<span class="required">&nbsp;*</span></label>
            <select class="form-control city-drop-list @error('city') is-invalid @enderror" name="city" @if(!old('state')) disabled="disabled" @endif>
                <option value="">{{ trans('messages.select_city') }}</option>
                @foreach($cities as $key => $citie)
                    <option value="{{ $citie->name }}" @if($citie->name == old('city')) selected="selected" @endif>{{ $citie->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.postal_code') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('pin_code') is-invalid @enderror" name="pin_code" value="{{ old('pin_code') }}" placeholder="{{ trans('auth.postal_code') }}" maxlength="6">
        </div>
    </div>
     <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.any_additional_info') }}</label>
            <textarea row="5" class="form-control @error('add_info') is-invalid @enderror" name="add_info" placeholder="{{ trans('auth.any_additional_info') }}"></textarea>
        </div>
     </div>
     <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('messages.upload_id_proof') }}<span class="required">&nbsp;*</span></label><br/>
            <input id="upload_id_proof" type="file" name="upload_id_proof[]" accept="image/x-png,image/jpeg,application/msword,application/pdf" multiple>
        </div>
     </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('messages.profile_photo') }}</label><br/>
            <input id="profile_photo" type="file" name="profile_photo" accept="image/x-png,image/jpeg">   
        </div>
    </div>
</div>
<!-- End Individual Nurse/Trained Attendant/Physiotherapist/Occupational Therapist registration -->