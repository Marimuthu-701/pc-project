@extends('admin.layouts.app')
@section('title', trans('common.partners'))
@section('plugins.Datatables', true)
@section('plugins.Validation', true)
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
    <h1>{{ trans('common.partner_services') }}</h1>
    @include('admin.partials.breadcrumbs', ['breadcrumbs' => [
        trans('common.partner_services')=> route('admin.partners.services'),
        trans('common.add'),
    ]])
    </div>
</div>
@stop
@section('content')
<div class="row">
    <div class="col-lg-12">          
        @include('flash::message')
    </div>

   <div class="spin admin-loader" style="display: none;">
       <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
       <span class="sr-only">Loading...</span>
   </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 profile_container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ trans('common.add_service') }}</h3>
            </div>
            <form action="{{ route('admin.partners.store') }}" method="post" class="partner_details" enctype="multipart/form-data">
                {{ csrf_field() }}
                @if(isset($userDetail) && $userDetail)
                    <input type="hidden" name="user_id" value="{{ isset($userDetail->id) ? $userDetail->id : null }}">
                @endif
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">{{ trans('auth.email') }}<span class="required">&nbsp;*</span></label>
                                        <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" tabindex="1" name="email" placeholder="{{ trans('auth.email_placeholder') }}" @if($errors) value="{{ isset($userDetail->email) ? $userDetail->email : old('email') }}" @endif>
                                        @if($errors->has('email'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">{{ trans('auth.mobile') }}<span class="required">&nbsp;*</span></label>
                                        <input type="text" class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" id="mobile" tabindex="2" name="mobile" placeholder="{{ trans('auth.mobile_number_placeholder') }}" @if($errors) value="{{ isset($userDetail->mobile_number) ? $userDetail->mobile_number : old('mobile') }}" @endif maxlength="10">
                                        @if($errors->has('mobile'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('mobile') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @if(isset($userDetail) && $userDetail)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="old_password">{{ trans('messages.old_password') }}</label>
                                            <input type="password" class="form-control {{ $errors->has('old_password') ? 'is-invalid' : '' }}" id="old_password" tabindex="3" name="old_password" placeholder="{{ trans('messages.old_password') }}" value="">
                                            @if($errors->has('old_password'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('old_password') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">    
                                        <div class="form-group">
                                            <label for="new_password">{{ trans('messages.new_password') }}</label>
                                            <input type="password" class="form-control {{ $errors->has('new_password') ? 'is-invalid' : '' }}" id="new_password" tabindex="4" name="new_password" placeholder="{{ trans('messages.new_password') }}" value="">
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">{{ trans('auth.password') }}<span class="required">&nbsp;*</span></label>
                                            <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password" tabindex="3" name="password" placeholder="{{ trans('auth.password_placeholder') }}" value="">
                                            @if($errors->has('password'))
                                                <div class="invalid-feedback">
                                                <strong>{{ $errors->first('password') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">    
                                        <div class="form-group">
                                            <label for="confirm_password">{{ trans('auth.confirm_password') }}<span class="required">&nbsp;*</span></label>
                                            <input type="password" class="form-control {{ $errors->has('confirm_password') ? 'is-invalid' : '' }}" id="confirm_password" tabindex="4" name="confirm_password" placeholder="{{ trans('auth.confirm_password_placeholder') }}" value="">
                                            @if($errors->has('confirm_password'))
                                                <div class="invalid-feedback">
                                                <strong>{{ $errors->first('confirm_password') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="featured_from_date">{{ trans('auth.featured_from_date') }}</label>
                                        <input type="text" class="form-control feature_date {{ $errors->has('featured_from_date') ? 'is-invalid' : '' }}" id="featured_from_date" tabindex="5" name="featured_from_date" placeholder="{{ trans('auth.featured_from_date') }}" value="{{ old('featured_from_date') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="featured_to_date">{{ trans('auth.featured_to_date') }}</label>
                                      <input type="text" class="form-control feature_date {{ $errors->has('featured_to_date') ? 'is-invalid' : '' }}" id="featured_to_date" tabindex="6" name="featured_to_date" placeholder="{{ trans('auth.featured_to_date') }}" value="{{ old('featured_to_date') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">{{ trans('auth.show_home') }}</label>
                                        <select class="form-control {{ $errors->has('show_home') ? 'is-invalid' : '' }}" id="show_home" tabindex="7" name="show_home">
                                            <option value="0" @if(old('show_home') == 0) selected="selected" @endif>No</option>
                                            <option value="1" @if(old('show_home') == 1) selected="selected" @endif>Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">{{ trans('auth.position') }}</label>
                                        <input type="text" class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" id="position" tabindex="8" name="position" placeholder="{{ trans('auth.position') }}" value="{{ old('position') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">{{ trans('auth.verified') }}</label>
                                        <select class="form-control {{ $errors->has('verified') ? 'is-invalid' : '' }}" id="verified" tabindex="9" name="verified">
                                          @if(count($getVerifiedStatus) > 0)
                                              @foreach($getVerifiedStatus as $key => $value)
                                                  <option value="{{ $key }}" @if(old('verified') == $key) selected="selected" @endif>{{ $value }}</option>
                                              @endforeach
                                          @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">    
                                    <div class="form-group">
                                        <label for="service_provider">{{ trans('messages.service_provider') }}<span class="required">&nbsp;*</span></label>
                                        <select class="form-control service_provider" name="service_provider">
                                            <option value=""> {{ trans('messages.select_your_serivice_provider') }}</option>
                                            @foreach($services as $key=>$service)
                                                <option value="{{$service->id}}" @if( ($provider_id == $service->id) || ($service->id == old('service_provider'))) selected="selected" @endif data-provider-type="{{$service->form_set}}"> {{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @if($provider_form)
                                <div class="service-template-body">
                                    @include('admin.partners.'.$provider_form)
                                </div>
                            @else
                                <div class="service-template-body"></div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{URL::previous()}}"  class="btn btn-secondary">{{ trans('common.back') }}</a>
                    <button type="submit" class="btn btn-primary">{{ trans('auth.submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@section('js')
  <script>
    
    $(function() {
        $('.service_provider').on('change', function(){
            var id  = $(this).val();
            var providerType = $(this).find(':selected').data('provider-type');
            $('.service-template-body').empty();
            var url = window.location.href.split('?')[0];
            if (providerType) {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    method: "GET",
                    data  : {'id': id, 'provider_type':providerType},
                    url:"{{ url('/admin/service-template') }}",
                    success:function(response){
                        if (response) {
                            $('.service-template-body').html(response);
                        }
                        var qeuryString = $.param({'id':id});
                        var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?'+qeuryString;
                        window.history.replaceState(null, null, newurl);
                    }
                });
            } else{
                window.history.replaceState(null, null, url);
            }
        });
        
        $.validator.addMethod("specialChars", function( value, element ) {
            var regex = new RegExp("^[a-zA-Z0-9_ ]+$");
            var key = value;
            if (!regex.test(key)) { return false; }
            return true;
        }, "please use only alphabetic characters");

        //Currnecy Validation
        $.validator.addMethod("currency", function (value, element) {
            var isValidMoney = /^\d{0,9}(\.\d{0,2})?$/.test(value);
            return this.optional(element) || isValidMoney;
        }, "Please a valid amount");

        //Similarly for mobile number Validation
        $.validator.addMethod("mobileValidation",
            function(value, element) { return !value.match(/^(\d)\1+$/g); },
        "Mobile number is invalid");

        //This validation for multiple file upload
        $.validator.addMethod("validate_file_type",
            function(val,elem) { var files    =   $('#'+elem.id)[0].files;
                for(var i=0;i<files.length;i++){
                    var fname = files[i].name.toLowerCase();
                    var re = /(\.pdf|\.docx|\.doc|\.jpeg|\.jpg|\.png)$/i;
                    if(!re.exec(fname)){console.log("File extension not supported!");return false;}
                }return true;
            },
            "Please upload jpeg,jpg,png,pdf formats only"
        );
        
        $.validator.addMethod("image_file_type",
            function(val,elem) { var files    =   $('#'+elem.id)[0].files;
                for(var i=0;i<files.length;i++){
                    var fname = files[i].name.toLowerCase();
                    var re = /(\.gif|\.jpeg|\.jpg|\.png)$/i;
                    if(!re.exec(fname)){console.log("File extension not supported!");return false;}
                }return true;
            },
            "Please upload jpeg,jpg,png,gif formats only"
        );

        $.validator.addMethod("alpha", function(value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z0-9\s\.\&\_\/\'\-]+$/);
        },"Letters and number space &./_'- only please");

        $.validator.addMethod("landline_no", function(value, element) {
            return this.optional(element) || value == value.match(/^[0-9][0-9\s\-]*$/);
        },"Numbers and space between only please");

        // Validate website url
        $.validator.addMethod('validUrl', function(value, element) {
            var url = $.validator.methods.url.bind(this);
            return url(value, element) || url('http://' + value, element);
        }, 'Please enter a valid URL');
        

        $(".partner_details").validate({
            errorClass: "invalid-feedback",
            errorElement: "strong",
            rules: {
                service_provider: "required",
                email: {
                    required: true,
                    email: true
                },
                mobile: {
                    required: true,
                    minlength: 10,
                    number: true
                },
                password: {
                    required: true,
                    minlength: 5
                },
                confirm_password: {
                    equalTo: "#password"
                },
                featured_from_date:{
                    required: function(){
                        var featureTo = $('#featured_to_date').val();
                        return featureTo ? true :false;
                    }
                },
                old_password: {
                    required: function(){
                        var new_password = $('#new_password').val();
                        return new_password ? true : false;
                    },
                    minlength: 6
                },
                new_password: {
                    required: function(){
                        var old_password = $('#old_password').val();
                        return old_password ? true : false;
                    },
                  minlength: 6  
                },
                position:{
                    number: true,
                },
                serive_provider_name:{
                    required:true,
                },
                name:{
                    required:true,
                    alpha: true,
                    maxlength:50,
                },
                gender:{
                   required: true,  
                },
                date_of_birth:{
                    required:true,
                },
                contact_phone:{
                    required: true,
                    minlength:10,
                    maxlength:10,
                    number: true,
                    mobileValidation:true
                },
                contact_email:{
                    email:true
                },
                id_proof:{
                    required: true,
                },
                qualification: {
                    required:true,
                },
                year_of_exp: {
                    required:true,
                    digits: true,
                    maxlength:2,
                },
                area_of_specialization: {
                    required: true,
                },
                reg_no_or_licence_no:{
                    required:true,
                },
                fees_type:{
                    required: function(){
                        var fees_type = $('.nurse-fees').val();
                        return fees_type ? true :false;
                    }
                },

                fees:{
                    required: function(){
                        var fees = $('.nurse-fees-type').val();
                        return fees ? true :false;
                    },
                    digits: true,
                    maxlength:4
                },
                // old age home form
                govt_approved:{
                    required:true,
                },
                old_age_home_reg_no:{
                    required: function(){
                        var govt_approved = $("select[name='govt_approved']").val();
                        return govt_approved == true ? true : false; 
                    },
                },
                contact_person:{
                    required:true,
                    alpha: true,
                    maxlength:40,
                },
                number_of_rooms:{
                    required:true,
                    number: true,
                },
                "facilities_available[]":{
                    required:true,
                },
                room_rent:{
                    //required:true,
                    digits: true,
                    maxlength:5
                },
                landline_number:{
                    landline_no: true,
                },
                form_two_landline_number:{
                    landline_no: true,
                },
                "home_avatar[]":{
                    //required:true,
                    accept:"jpg,png,jpeg,gif",
                    image_file_type:true,
                },
                // Medical equipment form
                "medical_profile_photo[]":{
                    //required:true,
                    accept:"jpg,png,jpeg,gif",
                    image_file_type:true,
                },
                // Home care service provider form
                address:{
                    required:true,
                },
                "care_home_photo[]":{
                    //required:true,
                    accept:"jpg,png,jpeg,gif",
                    image_file_type:true,
                },
                contact_email: {
                    email: true
                },
                //Lab pharmacy provider form 
                website_link:{
                    validUrl:true,
                },
                "lab_pharmacy_photo[]":{
                    //required:true,
                    accept:"jpg,png,jpeg,gif",
                    image_file_type:true,
                },
                // Redirement Home form
                project_name:{
                    required:true,
                },
                "retire_home_photo[]":{
                    //required:true,
                    accept:"jpg,png,jpeg,gif",
                    image_file_type:true,
                },
                state:{
                    required:true,
                },
                city:{
                    required:true,
                },
                pin_code:{
                    required:true,
                    minlength:6,
                    maxlength:6,
                    number: true,
                },
                "upload_id_proof[]":{
                    required:true,
                    accept:"jpg,png,jpeg,pdf,docx,doc",
                    validate_file_type:true,
                    //extension: "jpeg|jpg|png|bmp|pdf|doc|docx",
                },
                profile_photo:{
                    accept:"jpg,png,jpeg",
                    extension: "jpeg|jpg|png",
                },
            },
            highlight: function(element) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function(element) {
              $(element).removeClass("is-invalid");
            },
            errorPlacement: function(error, element) {
            var fees_type = element.attr("name");    
                if (fees_type == 'fees_type') {
                    error.insertAfter('.fees-type-error');
                }else {
                    error.insertAfter(element);
                }
            },
            messages: {
                mobile: {
                    required: "{{ trans('auth.mobile_requried_msg') }}",
                    number: "{{ trans('auth.mobile_number_msg') }}",
                    minlength: "{{ trans('auth.mobile_lenght_msg') }}"
                },
                password: {
                    required: "{{ trans('auth.password_required_msg') }}",
                    minlength: "{{ trans('auth.password_lengh_msg') }}"
                },
                email: "{{ trans('auth.user_email_msg') }}",
                profile_photo:{
                    extension:"{{ trans('messages.avator_format_validation') }}",
                    accept:"{{ trans('messages.gallery_image_validation') }}",
                },
                "home_avatar[]":{
                    accept:"{{ trans('messages.gallery_image_validation') }}",
                },
                "medical_profile_photo[]":{
                    accept:"{{ trans('messages.gallery_image_validation') }}",
                },
                "care_home_photo[]":{
                    accept:"{{ trans('messages.gallery_image_validation') }}",
                },
                "lab_pharmacy_photo[]":{
                    accept:"{{ trans('messages.gallery_image_validation') }}",
                },
                "retire_home_photo[]":{
                    accept:"{{ trans('messages.gallery_image_validation') }}",
                },
                "upload_id_proof[]":{
                    accept:"{{ trans('messages.id_proof_image_validation') }}",
                },
            },
            submitHandler: function(form) { 
                $('.profile_container').css("opacity", "0.5");
                $('.admin-loader').show();
                form.submit();
            }
        });
    });
  </script>
@stop

@stop
