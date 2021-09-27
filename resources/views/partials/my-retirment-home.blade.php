<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('messages.company_name')}} </label>
        <input  type="text" class="form-control @error('company_name') is-invalid @enderror" name="name" value="{{isset($serviceInfo->name) ? $serviceInfo->name :  old('company_name') }}" placeholder="{{ trans('messages.company_name')}} ">
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
       <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('messages.project_name')}} </label>
       <input type="text" class="form-control @error('project_name') is-invalid @enderror" name="project_name" value="{{ isset($serviceInfo->project_name) ? $serviceInfo->project_name : old('project_name') }}" placeholder="{{ trans('messages.project_name')}}">
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.contact_person')}} </label>
        <input type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" value="{{ isset($serviceInfo->contact_person) ? $serviceInfo->contact_person : old('contact_person') }}"  placeholder="{{ trans('auth.contact_person')}}" autofocus>
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.contact_phone')}} </label>
        <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone" value="{{isset($serviceInfo->contact_phone) ? $serviceInfo->contact_phone :  old('contact_phone') }}" placeholder="{{ trans('auth.contact_phone')}}" maxlength="10">
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-xs-12 register-form-input">
         <label class="col-lg-6 col-form-label my-account-lable"> {{ trans('messages.contact_email')}} </label>
        <input type="text" class="form-control @error('contact_email') is-invalid @enderror" name="contact_email" value="{{isset($serviceInfo->contact_email) ? $serviceInfo->contact_email :  old('contact_email') }}" placeholder="{{ trans('messages.contact_email')}}">
    </div>
    <div class="col-xs-12 col-lg-6 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.state')}} </label>
        <select class="form-control search-state @error('state') is-invalid @enderror" name="state" >
            <option value="">{{ trans('auth.select_state') }}</option>
            @foreach($states as $key => $state)
                <option value="{{ $state->code }}" @if($serviceInfo->state == $state->code) selected="selected" @endif>{{ $state->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <div class="col-xs-12 col-lg-6 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('messages.select_city')}} </label>
        <select class="form-control city-drop-list @error('city') is-invalid @enderror" name="city">
            <option value="">{{ trans('messages.select_city') }}</option>
            @foreach($cities as $key => $citie)
                <option value="{{ $citie->name }}" @if($serviceInfo->city == $citie->name) selected="selected" @endif>{{ $citie->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-xs-12 col-lg-6 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.postal_code')}} </label>
        <input type="text" class="form-control @error('pin_code') is-invalid @enderror" name="pin_code" value="{{ isset($serviceInfo->postal_code) ? $serviceInfo->postal_code : old('pin_code') }}" placeholder="{{ trans('auth.postal_code') }}" maxlength="6">
    </div>
</div>
<div class="form-group row">
    <div class="col-xs-12 col-lg-6 register-form-input">
        <label for="postal_code" class="col-lg-6 col-form-label my-account-lable"> {{ trans('messages.landline_number')}} </label>
        <input type="text" class="form-control @error('landline_number') is-invalid @enderror" name="landline_number" value="{{ isset($serviceInfo->landline_number) ? $serviceInfo->landline_number : old('landline_number') }}"  placeholder="{{ trans('messages.landline_number') }}">
    </div>
    <div class="col-xs-12 col-lg-6 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable"> {{ trans('messages.website_link_in_any')}} </label>
        <input type="text" class="form-control @error('website_link') is-invalid @enderror" name="website_link" value="{{ isset($serviceInfo->website_link) ? $serviceInfo->website_link :  old('website_link') }}" placeholder="{{ trans('messages.website_link_in_any')}}">
    </div>
    
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable"> {{ trans('auth.any_additional_info')}} </label>
        <textarea row="5" class="form-control @error('add_info') is-invalid @enderror" name="add_info" placeholder="{{ trans('auth.any_additional_info') }}">{{ isset($serviceInfo->additional_info) ? $serviceInfo->additional_info : old('add_info') }}</textarea>
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable"> {{ trans('messages.photo')}} </label>
        <label for="retire_home_photo" class="custom-file-upload retire_home_photo my-accout-file"> {{ isset($medias[0]) ? substr($medias[0]['source'], -25) : trans('messages.photo') }}</label>
        <input id="retirment-upload" type="hidden" name="check_qul_img" value="{{ isset($medias[0]) ? $medias[0]['source'] : ''}}">
        <input id="retire_home_photo" type="file" name="retire_home_photo[]" accept="image/x-png,image/gif,image/jpeg" multiple/>   
     </div>
</div>
<div class="form-group row">
    <div class="images_preview_retire_home_photo"></div>
</div>