@php
$featureFromDate = null;
$featureToDate   = null;
if (isset($serviceInfo->featured_from) && !empty($serviceInfo->featured_from)) {
    $featureFromDate = date('d-m-Y',strtotime($serviceInfo->featured_from));
}
if (isset($serviceInfo->featured_to) && !empty($serviceInfo->featured_to)) {
    $featureToDate = date('d-m-Y',strtotime($serviceInfo->featured_to));
}
@endphp

@extends('admin.layouts.app')
@section('title', trans('common.partner_services'))
@section('plugins.Datatables', true)
@section('plugins.Validation', true)
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>{{ trans('common.partner_services') }}</h1>
        @include('admin.partials.breadcrumbs', ['breadcrumbs' => [
          trans('common.partner_services')=> route('admin.partners.services'),
          trans('common.edit'),
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
                    <h3 class="card-title">{{ trans('common.edit_service') }}</h3>
                </div>
                <form action="{{ route('admin.partners.services.update', $serviceInfo->id) }}" method="post" class="partner_details" enctype="multipart/form-data" id="service-update">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ isset($serviceInfo->user_id) ? $serviceInfo->user_id : null }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">{{ trans('auth.email') }}<span class="required">&nbsp;*</span></label>
                                            <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" tabindex="1" name="email" placeholder="{{ trans('auth.email_placeholder') }}" @if($errors) value="{{ isset($serviceInfo->user) ? $serviceInfo->user->email : old('email') }}" @endif>
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
                                            <input type="text" class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" id="mobile" tabindex="2" name="mobile" placeholder="{{ trans('auth.mobile_number_placeholder') }}" @if($errors) value="{{ isset($serviceInfo->user) ? $serviceInfo->user->mobile_number :old('mobile') }}" @endif maxlength="10">
                                            @if($errors->has('mobile'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('mobile') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="featured_from_date">{{ trans('auth.featured_from_date') }}</label>
                                            <input type="text" class="form-control feature_date {{ $errors->has('featured_from_date') ? 'is-invalid' : '' }}" id="featured_from_date" tabindex="5" name="featured_from_date" placeholder="{{ trans('auth.featured_from_date') }}" value="{{ isset($featureFromDate) ? $featureFromDate : old('featured_from_date') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="featured_to_date">{{ trans('auth.featured_to_date') }}</label>
                                          <input type="text" class="form-control feature_date {{ $errors->has('featured_to_date') ? 'is-invalid' : '' }}" id="featured_to_date" tabindex="6" name="featured_to_date" placeholder="{{ trans('auth.featured_to_date') }}" value="{{ isset($featureToDate) ? $featureToDate : old('featured_to_date') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type">{{ trans('auth.show_home') }}</label>
                                            <select class="form-control {{ $errors->has('show_home') ? 'is-invalid' : '' }}" id="show_home" tabindex="7" name="show_home">
                                                <option value="0" @if($serviceInfo->show_at_home == 0) selected="selected" @endif>No</option>
                                                <option value="1" @if($serviceInfo->show_at_home == 1) selected="selected" @endif>Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type">{{ trans('auth.position') }}</label>
                                            <input type="text" class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" id="position" tabindex="8" name="position" placeholder="{{ trans('auth.position') }}" value="{{ isset($serviceInfo->position) ? $serviceInfo->position : old('position') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type">{{ trans('auth.verified') }}</label>
                                            <select class="form-control {{ $errors->has('verified') ? 'is-invalid' : '' }}" id="verified" tabindex="9" name="verified">
                                              @if(count($getVerifiedStatus) > 0)
                                                  @foreach($getVerifiedStatus as $key => $value)
                                                      <option value="{{ $key }}" @if($serviceInfo->verified == $key) selected="selected" @endif>{{ $value }}</option>
                                                  @endforeach
                                              @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">    
                                    <div class="form-group">
                                        <label for="service_provider">{{ trans('messages.service_provider') }}<span class="required">&nbsp;*</span></label>
                                        <input type="hidden" name="service_provider" value="{{$provider_id}}">
                                        <select class="form-control service_provider" name="service_provider" disabled="disabled">
                                            <option value=""> {{ trans('messages.select_your_serivice_provider') }}</option>
                                            @foreach($services as $key=>$service)
                                                <option value="{{$service->id}}" @if( ($provider_id == $service->id) || ($service->id == old('service_provider'))) selected="selected" @endif data-provider-type="{{$service->slug}}"> {{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                </div>
                                <div class="service-template-body">
                                    @include('admin.partners.edit-'.$provider_form)
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{URL::previous()}}"  class="btn btn-secondary">{{ trans('common.back') }}</a>
                        <button type="submit" tabindex="16" class="btn btn-primary">{{ trans('auth.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
        @if($provider_form == App\Models\PartnerService::MEDICAL_EQUIPMENT_BLADE)
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 profile_container">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ trans('messages.equipement_details') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="admin-add-equipment pull-right">
                                    <button type="button" class="btn btn-success create-btn">{{ trans('messages.create_equipment') }}</button>
                                </div>
                                <div class="table-overflow table-responsive">
                                    <div class="equipment-list-container">
                                        @include('admin.partners.admin-equipment-list')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.partners.equipment-add-edit-view')
        @endif
    </div>
@stop
@section('js')
  <script>
    $(document).ready(function() {
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
        
        $.validator.addMethod('validUrl', function(value, element) {
            var url = $.validator.methods.url.bind(this);
            return url(value, element) || url('http://' + value, element);
        }, 'Please enter a valid URL');


        $("#service-update").validate({
            errorClass: "invalid-feedback",
            errorElement: "strong",
            rules: {
                email: {
                    required: true,
                    email: true
                },
                mobile: {
                    required: true,
                    minlength: 10,
                    number: true
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
                featured_from_date:{
                    required: function(){
                        var featureTo = $('#featured_to_date').val();
                        return featureTo ? true :false;
                    }
                },
                position:{
                    number: true,
                },
                serive_provider_name:{
                    required:true,
                },
                name:{
                    required: true,
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
                    maxlength:4,
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
                    digits: true,
                    maxlength:5,
                },
                landline_number:{
                    landline_no: true,
                },
                form_two_landline_number:{
                    landline_no: true,
                },
                "home_avatar[]":{
                    accept:"jpg,png,jpeg,gif",
                    image_file_type:true,
                },
                // Medical equipment form
                "medical_profile_photo[]":{
                    accept:"jpg,png,jpeg,gif",
                    image_file_type:true,
                },
                // Home care service provider form
                address:{
                    required:true,
                },
                "care_home_photo[]":{
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
                    accept:"jpg,png,jpeg,gif",
                    image_file_type:true,
                },
                // Redirement Home form
                project_name:{
                    required:true,
                },
                "retire_home_photo[]":{
                    /*required:{
                        depends : function(element) {
                            return $("#retirment_image").is(":blank");
                        }
                    },*/
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
                    required:{
                        depends : function(element) {
                            return $("#id_proof_imag").is(":blank");
                        }
                    },
                    accept:"jpg,png,jpeg,pdf,docx,doc",
                    validate_file_type:true,
                    //extension: "jpeg|jpg|png|bmp|pdf|doc|docx",
                },
                profile_photo:{
                    accept:"jpg,png,jpeg,gif",
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
                    accept:"{{ trans('messages.avator_format_validation') }}",
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

        // Medical Equipment Section


        $('body').on('click', '.create-btn', function() {
            $('#admin_add_equipment').trigger("reset");                
            $('#admin-create-equipement').modal('show');
        });

        $("#admin_add_equipment").validate({
            errorElement: 'span',
            ignore: [],
            rules: {
                equipment_name:{
                    required:true,
                },
                rent:{
                    currency:true,
                },
                "equipment_photo[]":{
                   required: true,
                   accept:"jpg,png,jpeg,gif",
                   image_file_type:true,  
                },
            },
            messages: {
                "equipment_photo[]":{
                    accept:"{{ trans('messages.gallery_image_validation') }}", 
                },
            },
        });

        $('#admin_add_equipment').ajaxForm({
            beforeSend: function() {
                $('#admin_add_equipment .error').removeClass('error');
            },
            success: function(response) {
                $('#admin_add_equipment .custom_error').addClass('hide');
                if (response.success) {
                    $('#admin_add_equipment .custom_success').text(response.message).removeClass('hide');
                    $('#admin_add_equipment').trigger("reset");
                    setTimeout(function(){
                        $('.custom_success').addClass('hide');
                        $('#admin-create-equipement').modal('hide');
                        location.reload();
                    },2000);
                } else {
                    if (response.errors) {
                        $.each(response.errors, function(key, val) {
                            $("input[name="+key+"], select[name="+key+"]").addClass('error');
                            $("input[name="+key+"], select[name="+key+"]").after('<span for="'+key+'" generated="true" class="error">'+val[0]+'</span>');
                        });
                    }else {
                        $('#admin_add_equipment .custom_error').text(response.message).removeClass('hide');
                    }
                }
            }
        });
            
        $('body').on('click', '.medical-update-btn', function() {
            var id = $(this).data('id');
            $('#equipment_id').val(id);
            var imagGallery = '';
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: "GET",
                data:{"id":id},
                url:"{{ url('/admin/equipment-show') }}",
                success:function(response){
                    if (response.success) {
                        $('.uploaded-image-gallery').empty();
                        $('#admin-equipment-name').val(response.data.equpment_info.name);
                        $('#admin-description').text(response.data.equpment_info.description);
                        $('#admin_rent_type>option[value="'+response.data.equpment_info.rent_type+'"]').prop('selected', true);
                        var rent = response.data.equpment_info.rent ? parseFloat(response.data.equpment_info.rent).toFixed(2) : null;
                        $('#admin_rent').val(rent);
                        if (response.data.media.length > 0) {
                            var media = response.data.media;
                            var imagelabel = media[0] ? media[0].imageName.substr(media[0].imageName.length -25): null;
                            $('#update-equipment-image').val(media[0].imageName);
                            $('.equipment-file-name').text(imagelabel);
                            for(var i= 0; i < media.length; i++) {
                                imagGallery +=`<div class="col-lg-3 col-xs-12 register-form-input eqp-media-div" id="eqp_photo_`+media[i].image_id+`">
                                                    <span class="admin-equipment-photo-delete" data-toggle="tooltip" data-id="`+media[i].equipment_id+`" data-media-id="`+media[i].image_id+`" data-placement="top" title="Delete">
                                                        <i class="fas fa-times-circle"></i>
                                                    </span>
                                                    <a href="`+media[i].imagePath+`" target="_blank">
                                                        <img src="`+media[i].imageThumbPath+`" class="service-image">
                                                    </a>
                                                </div>`;
                            }
                           $('.uploaded-image-gallery').html(imagGallery); 
                        }
                    }
                }
            });
            $('#admin-update-equipement').modal('show');
            });

            $("#admin_equipment_update").validate({
                errorElement: 'span',
                ignore: [],
                rules: {
                    equipment_name:{
                        required:true,
                    },
                    rent:{
                        currency:true,
                    },
                    "update_equipment_photo[]":{
                        required:{
                            depends : function(element) {
                                return $("#update-equipment-image").is(":blank");
                            }
                        },
                        accept:"jpg,png,jpeg,gif",
                        image_file_type:true,  
                    },
                },
                 messages: {
                    "update_equipment_photo[]":{
                        accept:"{{ trans('messages.gallery_image_validation') }}", 
                    },
                },
            });
            $('#admin_equipment_update').ajaxForm({
                beforeSend: function() {
                    $('#admin_equipment_update .error').removeClass('error');
                },
                success: function(response) {
                    $('#admin_equipment_update .custom_error').addClass('hide');
                    if (response.success) {
                        $('#admin_equipment_update .custom_success').text(response.message).removeClass('hide');
                        setTimeout(function(){
                            $('.custom_success').addClass('hide');
                            $('#admin-update-equipement').modal('hide');
                        },2000);
                        location.reload();
                    } else {
                        if (response.errors) {
                            $.each(response.errors, function(key, val) {
                                $("input[name="+key+"], select[name="+key+"]").addClass('error');
                                $("input[name="+key+"], select[name="+key+"]").after('<span for="'+key+'" generated="true" class="error">'+val[0]+'</span>');
                            });
                        }else {
                            $('#admin_equipment_update .custom_error').text(response.message).removeClass('hide');
                        }
                    }
                }
            });

            $('body').on('click', '.medical-view-btn', function(){
            var id = $(this).data('id');
            var imagGallery = '';
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: "GET",
                data:{"id":id},
                url:"{{ url('admin/equipment-show') }}",
                success:function(response){
                    if (response.success) {
                        $('.equipment-name').text(response.data.equpment_info.name);
                        $('.description').text(response.data.equpment_info.description);
                        var rentType = response.data.equpment_info.rent_type ? response.data.equpment_info.rent_type.replace('_', ' ') : '-';
                        $('.rent-type').text(rentType);
                        var rent = response.data.equpment_info.rent ? parseFloat(response.data.equpment_info.rent).toFixed(2) : '-';
                        $('.rent').text(rent);
                        if (response.data.media.length > 0) {
                            var media = response.data.media;
                            var imagelabel = media[0] ? media[0].imageName.substr(media[0].imageName.length -25): null;
                            $('#update-equipment-image').val(media[0].imageName);
                            $('.equipment-file-name').text(imagelabel);
                            for(var i= 0; i < media.length; i++) {
                                imagGallery +=`<div class="col-lg-3 col-xs-12 register-form-input media-div">
                                                    <a href="`+media[i].imagePath+`" target="_blank">
                                                        <img src="`+media[i].imageThumbPath+`" class="service-image">
                                                    </a>
                                                </div>`;
                            }
                           $('.equipment-gallery').html(imagGallery); 
                        }
                    }
                }
            });
            $('#admin-view-equipement').modal('show');
        });

        $('body').on('click', '.medical-delete-btn', function() {
            var id = $(this).data('id');
            $('#equipment_delete_id').val(id);
            $('#admin-delete-equipement').modal('show');
        });
        
        $('#admin_equipment_delete').ajaxForm({
            success: function(response) {
                if (response.success) {
                    $('#admin-delete-equipement').modal('hide');
                    location.reload();
                } else {
                    $('.partner-register-form .custom_error').text(response.message).removeClass('hide');
                }
            }
        });
    });
  </script>
@stop