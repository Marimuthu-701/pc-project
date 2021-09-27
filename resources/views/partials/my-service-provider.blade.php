<div class="container partner-register-form">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="partner-form-title" style="margin-bottom: 0px;">{{ trans('messages.my_service') }}</h3>
                </div>
                @if($serviceInfo)
                    <div class="card-body">
                        <div class="custom_error alert alert-danger hide"></div>
                        <div class="custom_success alert alert-success hide"></div>
                        <form method="POST" action="{{ route('profile.service.update') }}" class="register_form" id="service_update_form">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 col-xs-12 register-form-input">
                                    <h3 class="service-provider-name">{{ $serviceName }}</h3>
                                </div>
                            </div>
                            <div class="service-provider-form">
                                @include('partials.my-'.$serviceTemplate)
                            </div>
                            @if ($form_name && $form_name != App\Models\Service::FORM_SET_1)
                                @if (count($medias) > 0)
                                    @include('partials.my-provider-photos')
                                @endif
                            @endif
                            <div class="common-password-btn-section">
                                <div class="form-group row">
                                    <div class="col-lg-6 col-xs-12 register-form-input">
                                        <button type="submit" class="btn btn-primary register_btn">
                                            &nbsp;&nbsp;&nbsp;{{ trans('messages.update') }}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @if($serviceTemplate == App\Models\PartnerService::MEDICAL_EQUIPMENT_BLADE)
                        <div class="equipement-list">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6 col-xs-12  equipement_details">
                                    <h4>{{ trans('messages.equipement_details') }}</h4>
                                </div>
                                <div class="col-lg-6 col-xs-12 col-md-6 col-sm-6">
                                    <div class="add-equipment pull-right">
                                        <button type="button" class="btn btn-success create-btn">{{ trans('messages.create_equipment') }}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="equipement-list-table">
                                @include('partials.equipment-list')
                            </div>
                             @include('partials.equipment-create-edit')
                        </div>
                        @endif
                    </div>
                @else
                    <div class="right-search-result-panel text-center service-not-found">
                        <label class="my-wish-list">Data Not Found</label>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
$(document).ready(function() {
    
    var imgGallery = '';
    var fileExts  = ['jpeg', 'jpg', 'png', 'bmp', 'pdf', 'doc', 'docx'];
    var docArray  = ['pdf', 'doc', 'docx'];
    var imageUrl  = '';
    // Multiple images preview in browser
    function imagesPreview(input, previewDiv,file_type) {
        if (input.files) {
            var filesAmount = input.files.length;
            var imageCount  = 0;
            for (i = 0; i < filesAmount; i++) {
                imageCount = i;
                var reader = new FileReader();
                reader.onload = function(event) {
                    imageUrl = event.target.result;
                    if ($.inArray(file_type, docArray) >= 0) {
                        imageUrl = "{{ asset("images/document_icon.png") }}";
                    } 
                    imgGallery = `<div class="col-md-2 upload_image_id">
                                    <div class="file-uploade-gallery">
                                        <img src=`+imageUrl+` class="upload-image" width="150px" height="100px">
                                    </div>
                                  </div>`;
                    $(imgGallery).appendTo(previewDiv);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    }

    $('.serive-provider-name').on('change', function(){
        var id  = $(this).val();
        var providerType = $(this).find(':selected').data('provider-type');
        $('.service-provider-form-body').empty();
        $('.common-password-btn-section').hide();
        var url = window.location.href.split('?')[0];
        if (providerType) {
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: "GET",
                data  : {'id': id, 'provider_type':providerType},
                url:"{{ url('serive-provider-form') }}",
                beforeSend:function(){ $('.loader').show(); },
                success:function(response){
                    $('.loader').hide();
                    if (response) {
                        $('.service-provider-form-body').html(response);
                        $('.common-password-btn-section').show();
                    }
                    var qeuryString = $.param({'provider_id':id});
                    var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?'+qeuryString;
                    window.history.replaceState(null, null, newurl);
                }
            });
        }else{
            window.history.replaceState(null, null, url);
        }
    });

    $('body').on('change', '#upload_id_proof', function(e) {
        var upload_type = $(this).attr('id');
        $('div.images_preview_'+upload_type).empty();
        $('.id-proof-image-view').remove();
        var file_name = e.target.files[0]? e.target.files[0].name : '' ; //$(this).val();
        var fileType  = file_name.replace(/^.*\./, '').toLowerCase();
        $('.upload_id_proof').html(file_name);
        imagesPreview(this, 'div.images_preview_'+upload_type,fileType);
    });

    $('body').on('change', '#lab_pharmacy_photo', function(e) {
        var upload_type = $(this).attr('id');
        $('div.images_preview_'+upload_type).empty();
        var file_name = e.target.files[0]? e.target.files[0].name : '' ; //$(this).val();
        var fileType  = file_name.replace(/^.*\./, '').toLowerCase();
        $('.lab_pharmacy_photo').html(file_name);
        imagesPreview(this, 'div.images_preview_'+upload_type,fileType);
    });

    $('body').on('change', '#home_avatar', function(e) {
        var upload_type = $(this).attr('id');
        $('div.images_preview_'+upload_type).empty();
        var file_name = e.target.files[0]? e.target.files[0].name : '' ; //$(this).val();
        var fileType  = file_name.replace(/^.*\./, '').toLowerCase();
        $('.home_avatar').html(file_name);
        imagesPreview(this, 'div.images_preview_'+upload_type,fileType);
    });

    $('body').on('change', '#retire_home_photo', function(e) {
        var upload_type = $(this).attr('id');
        $('div.images_preview_'+upload_type).empty();
        var file_name = e.target.files[0]? e.target.files[0].name : '' ; //$(this).val();
        var fileType  = file_name.replace(/^.*\./, '').toLowerCase();
        $('.retire_home_photo').html(file_name);
        imagesPreview(this, 'div.images_preview_'+upload_type,fileType);
    });

    $('body').on('change', '#care_home_photo', function(e) {
        var upload_type = $(this).attr('id');
        $('div.images_preview_'+upload_type).empty();
        var file_name = e.target.files[0]? e.target.files[0].name : '' ; //$(this).val();
        var fileType  = file_name.replace(/^.*\./, '').toLowerCase();
        $('.care_home_photo').html(file_name);
        imagesPreview(this, 'div.images_preview_'+upload_type,fileType);
    });

    $('body').on('change', '#medical_profile_photo', function(e) {
        var upload_type = $(this).attr('id');
        $('div.images_preview_'+upload_type).empty();
        var file_name = e.target.files[0]? e.target.files[0].name : '' ; //$(this).val();
        var fileType  = file_name.replace(/^.*\./, '').toLowerCase();
        $('.medical_profile_photo').html(file_name);
        imagesPreview(this, 'div.images_preview_'+upload_type,fileType);
    });

    //Similarly for mobile number
    $.validator.addMethod("mobileValidation",
        function(value, element) { return !value.match(/^(\d)\1+$/g); },
    "Mobile number is invalid");

    //valiation for currency
    $.validator.addMethod("currency", function (value, element) {
        var isValidMoney = /^\d{0,9}(\.\d{0,2})?$/.test(value);
        return this.optional(element) || isValidMoney;
    }, "Please a valid amount");

     //This validation for multiple file upload
    $.validator.addMethod("validate_file_type",
        function(val,elem) { var files    =   $('#'+elem.id)[0].files;
            for(var i=0;i<files.length;i++){
                var fname = files[i].name.toLowerCase();
                var re = /(\.pdf|\.docx|\.doc|\.jpeg|\.jpg|\.png)$/i;
                if(!re.exec(fname)){console.log("File extension not supported!");return false;}
            }return true;
        },
        "Please upload jpeg,jpg,png,bmp,pdf formats only"
    );
    
    $.validator.addMethod("image_file_type",
        function(val,elem) { var files    =   $('#'+elem.id)[0].files;
            for(var i=0;i<files.length;i++){
                var fname = files[i].name.toLowerCase();
                var re = /(\.jpeg|\.jpg|\.png|\.gif)$/i;
                if(!re.exec(fname)){console.log("File extension not supported!");return false;}
            }return true;
        },
        "Please upload jpeg,jpg,png,gif formats only"
    );

    // Validate website url
    $.validator.addMethod('validUrl', function(value, element) {
        var url = $.validator.methods.url.bind(this);
        return url(value, element) || url('http://' + value, element);
    }, 'Please enter a valid URL');


    $.validator.addMethod("alpha", function(value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z0-9\s\.\&\_\/\'\-]+$/);
    },"Letters and number space &./_'- only please");

    $.validator.addMethod("landline_no", function(value, element) {
        return this.optional(element) || value == value.match(/^[0-9][0-9\s\-]*$/);
    },"Numbers and space between only please");

    $("#service_update_form").validate({
        errorElement: 'span',
        ignore: [],
        rules: {
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
            email:{
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
                //currency:true,
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
                //required:true,
                //currency:true,
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
                image_file_type : true,
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
               /* required:{
                    depends : function(element) {
                        return $("#retirment-upload").is(":blank");
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
                        return $("#id_proof_img").is(":blank");
                    }
                },
                accept:"jpg,png,jpeg,pdf,docx,doc",
                validate_file_type : true,
            },
            profile_photo:{
                accept:"jpg,png,jpeg",
                extension: "jpeg|jpg|png",
            },
        },
        messages:{
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
            "upload_id_proof[]":{
                accept:"{{ trans('messages.id_proof_image_validation') }}",
            },
            "retire_home_photo[]":{
                accept:"{{ trans('messages.gallery_image_validation') }}",
            },
        },
        errorPlacement: function(error, element) {
            var fees = element.attr("name");
            if (fees == 'fees_type' || fees == 'fees') {
                error.insertAfter('.fees-type-error');
            }else {
                error.insertAfter(element);
            }
        }
    });

    $('#service_update_form').ajaxForm({
        beforeSend: function() {
            $('.register_btn i').removeClass('fa-long-arrow-alt-right');
            $('.register_btn i').addClass('fa-spinner fa-spin');
            $('.register_btn').prop('disabled', true);
            $('span.error').remove();
            $('#partner_register_form .error').removeClass('error');
        },
        success: function(response) {
            $('.register_btn').prop('disabled', false);
            $('.register_btn i').removeClass('fa-spinner fa-spin');
            $('.register_btn i').addClass('fa-long-arrow-alt-right');
            $('.partner-register-form .custom_error').addClass('hide');
            if (response.success) {
                if(response.provider_update){
                    location.reload();
                } else {
                    $('#photo-deleted-response').addClass('hide');
                    $('.partner-register-form .custom_success').text(response.message).removeClass('hide');
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                    setTimeout(function(){
                        $('.custom_success').addClass('hide');
                        //window.location.href = response.redirect_url;
                    },2000);
                }
            } else {
                if (response.errors) {
                    var facility_error = response.errors.facilities_available ? response.errors.facilities_available.length : null;
                    if(facility_error) {
                        $("select[name='facilities_available[]']").addClass('error');
                        $("select[name='facilities_available[]']").after('<span for="facilities_available" generated="true" class="error">'+response.errors.facilities_available+'</span>');
                        $('html, body').animate({
                            scrollTop: $("#available_facility").position().top
                        }, 200);    
                    }else{
                        $.each(response.errors, function(key, val) {
                            $("input[name="+key+"], select[name="+key+"], textarea[name="+key+"]").addClass('error');
                            $("input[name="+key+"], select[name="+key+"], textarea[name="+key+"]").after('<span for="'+key+'" generated="true" class="error">'+val[0]+'</span>');
                        });
                    }
                    
                }else {
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                    $('.partner-register-form .custom_error').text(response.message).removeClass('hide');
                }
            }
        }
    });
});
</script>
@endpush