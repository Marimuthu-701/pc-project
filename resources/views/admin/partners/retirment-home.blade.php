<div class="row">    
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('messages.company_name') }}<span class="required">&nbsp;*</span></label>
            <input  type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="{{ trans('messages.company_name')}}">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('messages.project_name') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('project_name') is-invalid @enderror" name="project_name" value="{{ old('project_name') }}" placeholder="{{ trans('messages.project_name') }}">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.contact_person') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" value="{{ old('contact_person') }}"  placeholder="{{ trans('auth.contact_person') }}">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.contact_phone') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone" value="{{ old('contact_phone') }}" placeholder="{{ trans('auth.contact_phone') }}" maxlength="10">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('messages.contact_email') }}</label>
            <input type="text" class="form-control @error('contact_email') is-invalid @enderror" name="contact_email" value="{{ old('contact_email') }}" placeholder="{{ trans('messages.contact_email')}}">
        </div>
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('auth.select_state') }}<span class="required">&nbsp;*</span></label>
            <select class="form-control search-state @error('state') is-invalid @enderror" name="state" >
                <option value="">{{ trans('auth.select_state') }}</option>
                @foreach($states as $key => $state)
                    <option value="{{ $state->code }}" @if(old('state') == $state->code) selected="selected" @endif>{{ $state->name }}</option>
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
                    <option value="{{ $citie->name }}" @if(old('city') == $citie->name) selected="selected" @endif>{{ $citie->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('auth.postal_code') }}<span class="required">&nbsp;*</span></label>
            <input type="text" class="form-control @error('pin_code') is-invalid @enderror" name="pin_code" value="{{ old('pin_code') }}" placeholder="{{ trans('auth.postal_code') }} *" maxlength="6">
        </div>
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('messages.landline_number') }}</label>
            <input type="text" class="form-control @error('landline_number') is-invalid @enderror" name="landline_number" value="{{ old('landline_number') }}"  placeholder="{{ trans('messages.landline_number')}}">
        </div>
    </div>
    <div class="col-xs-12 col-lg-6">
        <div class="form-group">
            <label>{{ trans('messages.website_link_in_any') }}</label>
            <input type="text" class="form-control @error('website_link') is-invalid @enderror" name="website_link" value="{{ old('website_link') }}" placeholder="{{ trans('messages.website_link_in_any') }}">
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('auth.any_additional_info') }}</label>
            <textarea row="5" class="form-control @error('add_info') is-invalid @enderror" name="add_info" value="{{ old('add_info') }}" placeholder="{{ trans('auth.any_additional_info') }}"></textarea>
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('messages.photo') }}</label><br/>
            <input id="retire_home_photo" type="file" name="retire_home_photo[]" accept="image/x-png,image/gif,image/jpeg" multiple/>
        </div>
    </div>
    <div class="col-lg-6 col-xs-12">
        <div class="form-group">
            <label>{{ trans('messages.profile_photo') }}</label><br/>
            <input id="profile_photo" type="file" name="profile_photo" accept="image/x-png,image/jpeg">   
        </div>
    </div>
</div>
