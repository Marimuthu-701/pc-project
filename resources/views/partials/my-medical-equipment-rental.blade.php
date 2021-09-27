<!-- Medical Equipment Rental -->
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('messages.company_name')}} </label>
        <input  type="text" class="form-control @error('company_name') is-invalid @enderror" name="name" value="{{ isset($serviceInfo->name) ? $serviceInfo->name : old('company_name') }}" placeholder="{{ trans('messages.company_name')}}">
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-12 col-form-label my-account-lable required"> {{ trans('messages.reg_no_or_licence_no')}} </label>
       <input type="text" class="form-control @error('reg_no_or_licence_no') is-invalid @enderror" name="reg_no_or_licence_no" value="{{ isset($serviceInfo->registration_number) ? $serviceInfo->registration_number : old('reg_no_or_licence_no') }}" placeholder="{{ trans('messages.reg_no_or_licence_no')}}">
    </div>
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.contact_person')}} </label>
        <input type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" value="{{ isset($serviceInfo->contact_person) ? $serviceInfo->contact_person : old('contact_person') }}"  placeholder="{{ trans('auth.contact_person')}}" autofocus>
    </div>
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.contact_phone')}} </label>
        <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone" value="{{ isset($serviceInfo->contact_phone) ? $serviceInfo->contact_phone : old('contact_phone') }}" placeholder="{{ trans('auth.contact_phone')}}" maxlength="10">
    </div>
</div>

<div class="form-group row">
     <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable"> {{ trans('auth.address')}} </label>
        <textarea  row="5" class="form-control @error('medical_address') is-invalid @enderror" name="medical_address" value="{{ old('medical_address') }}" placeholder="{{ trans('auth.address') }}">{{ isset($serviceInfo->address) ? $serviceInfo->address : null }}</textarea>
    </div>
    <div class="col-xs-12 col-lg-6 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable required"> {{ trans('auth.select_state')}} </label>
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
        <label class="col-lg-6 col-form-label my-account-lable"> {{ trans('messages.website_link')}} </label>
        <input type="text" class="form-control @error('website_link') is-invalid @enderror" name="website_link" value="{{ isset($serviceInfo->website_link) ? $serviceInfo->website_link : old('website_link') }}" placeholder="{{ trans('messages.website_link')}}">
    </div>
    
</div>
<div class="form-group row">
    <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable"> {{ trans('messages.photo')}} </label>
        <label for="medical_profile_photo" class="custom-file-upload my-accout-file medical_profile_photo"> {{ isset($medias[0]) ? substr($medias[0]['source'], -25) : trans('messages.photo') }}</label>
        <input id="medical-imag" type="hidden" name="check_qul_img" value="{{ isset($medias[0]) ? $medias[0]['source'] : ''}}">
        <input id="medical_profile_photo" type="file" name="medical_profile_photo[]" accept="image/x-png,image/gif,image/jpeg" multiple>   
     </div>
     <div class="col-lg-6 col-xs-12 register-form-input">
        <label class="col-lg-6 col-form-label my-account-lable"> {{ trans('auth.any_additional_info')}} </label>
        <textarea row="5" class="form-control @error('add_info') is-invalid @enderror" name="add_info"  placeholder="{{ trans('auth.any_additional_info') }}">{{ isset($serviceInfo->additional_info) ? $serviceInfo->additional_info : null}}</textarea>
    </div>
</div>
<div class="form-group row">
    <div class="images_preview_medical_profile_photo"></div>
</div>

@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var imgGallery = '';
            var fileExts  = ['jpeg', 'jpg', 'png', 'bmp', 'pdf', 'doc', 'docx'];
            var docArray  = ['pdf', 'doc', 'docx'];
            var imageUrl  = '';
            // Multiple images preview in browser
            function imagesPreviewOnPopup(input, previewDiv,file_type) {
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
                            imgGallery = `<div class="col-md-3 upload_image_id">
                                            <div class="file-uploade-gallery popup-upload-preview">
                                                <img src=`+imageUrl+` class="upload-image" width="100px" height="100px">
                                                <div class="uploaded-romove-imag"><span class="remove-btn" data-id="`+i+`">Remove &nbsp;&nbsp;<i class="fas fa-trash-alt"></i></span></div>
                                            </div>
                                          </div>`;
                            $(imgGallery).appendTo(previewDiv);
                        }
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            }

            $('body').on('click', '.create-btn', function() {
                $('#equipment_create_form').trigger("reset");
                $('.equipment_photo').text("{{ trans('messages.equipment_photo') }}*");
                $('.images_preview_equipment_photo').empty();
                $('#create-equipement').modal('show');
            });
           
            $('body').on('change', '#equipment_photo', function(e) {
                var upload_type = $(this).attr('id');
                $('div.images_preview_'+upload_type).empty();
                var file_name = e.target.files[0]? e.target.files[0].name : '' ; //$(this).val();
                var fileType  = file_name.replace(/^.*\./, '').toLowerCase();
                $('.equipment_photo').html(file_name);
                imagesPreviewOnPopup(this, 'div.images_preview_'+upload_type,fileType);
            });

            $('body').on('change', '#update_equipment_photo', function(e) {
                var upload_type = $(this).attr('id');
                $('div.images_preview_'+upload_type).empty();
                var file_name = e.target.files[0]? e.target.files[0].name : '' ; //$(this).val();
                var fileType  = file_name.replace(/^.*\./, '').toLowerCase();
                $('.equipment-file-name').html(file_name);
                imagesPreviewOnPopup(this, 'div.images_preview_'+upload_type,fileType);
            });

            //This validation for multiple file upload
            $.validator.addMethod("validate_file_type",
                function(val,elem) { var files    =   $('#'+elem.id)[0].files;
                    for(var i=0;i<files.length;i++){
                        var fname = files[i].name.toLowerCase();
                        var re = /(\.jpeg|\.jpg|\.png|\.gif)$/i;
                        if(!re.exec(fname)){console.log("File extension not supported!");return false;}
                    }return true;
                },
                "Please upload jpeg,jpg,png,bmp,pdf formats only"
            );

            //valiation for currency
            $.validator.addMethod("currency", function (value, element) {
                var isValidMoney = /^\d{0,9}(\.\d{0,2})?$/.test(value);
                return this.optional(element) || isValidMoney;
            }, "Please a valid amount");

            $("#equipment_create_form").validate({
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
                       validate_file_type:true,  
                    },
                },
                messages:{
                    "equipment_photo[]":{
                        accept:"{{ trans('messages.gallery_image_validation') }}",
                    },
                },
            });
            $('#equipment_create_form').ajaxForm({
                beforeSend: function() {
                    $('.equipment-add i').removeClass('fa-long-arrow-alt-right');
                    $('.equipment-add i').addClass('fa-spinner fa-spin');
                    $('.equipment-add').prop('disabled', true);
                    $('span.error').remove();
                    $('#equipment_create_form .error').removeClass('error');
                },
                success: function(response) {
                    $('.equipment-add i').removeClass('fa-spinner fa-spin');
                    $('.equipment-add i').addClass('fa-long-arrow-alt-right');
                    $('#create-equipement .custom_error').addClass('hide');
                    $('.equipment-add').prop('disabled', false);
                    if (response.success) {
                        $('#create-equipement .custom_success').text(response.message).removeClass('hide');
                        $('#equipment_create_form').trigger("reset");
                        setTimeout(function(){
                            $('.custom_success').addClass('hide');
                            equipmentList();
                            $('#create-equipement').modal('hide');
                        },2000);
                    } else {
                        if (response.errors) {
                            $.each(response.errors, function(key, val) {
                                $("input[name="+key+"], select[name="+key+"]").addClass('error');
                                $("input[name="+key+"], select[name="+key+"]").after('<span for="'+key+'" generated="true" class="error">'+val[0]+'</span>');
                            });
                        }else {
                            $('#create-equipement .custom_error').text(response.message).removeClass('hide');
                        }
                    }
                }
            });

            $('body').on('click', '.update-btn', function() {
                $('#equipment_update_form').trigger("reset");
                $('.images_preview_update_equipment_photo').empty();
                var id = $(this).data('id');
                $('#equipment_id').val(id);
                var imagGallery = '';
                var deleteIcon = '';
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    method: "GET",
                    data:{"id":id},
                    url:"{{ url('/equipment-show') }}",
                    success:function(response){
                        if (response.success) {
                            $('.uploaded-image-gallery').empty();
                            $('#equipment_name').val(response.data.equpment_info.name);
                            $('#description').text(response.data.equpment_info.description);
                            $('#rent_type>option[value="'+response.data.equpment_info.rent_type+'"]').prop('selected', true);
                            var rent = response.data.equpment_info.rent ? parseFloat(response.data.equpment_info.rent).toFixed(2) : null;
                            $('#rent').val(rent);
                            if (response.data.media.length > 0) {
                                var media = response.data.media;
                                var imagelabel = media[0] ? media[0].imageName.substr(media[0].imageName.length -25): null;
                                $('#update-equipment-image').val(media[0].imageName);
                                $('.equipment-file-name').text(imagelabel);
                                for(var i= 0; i < media.length; i++) {
                                    deleteIcon =`<span class="equipment-photo-delete" data-toggle="tooltip" data-id="`+media[i].equipment_id+`" data-media-id="`+media[i].image_id+`" data-placement="top" title="Delete">
                                    <i class="fas fa-times-circle"></i>
                                    </span>`;
                                    imagGallery +=`<div class="col-lg-3 col-xs-12 register-form-input media-div" id="eqp_photo_`+media[i].image_id+`">
                                                        <div class="photo-container">`+ deleteIcon +
                                                            `<a href="`+media[i].imagePath+`" target="_blank">
                                                                <img src="`+media[i].imageThumbPath+`" class="service-image">
                                                            </a>
                                                        </div>
                                                    </div>`;
                                }
                               $('.uploaded-image-gallery').html(imagGallery); 
                            }
                        }
                    }
                });
               $('#update-equipement').modal('show'); 
            });

            $("#equipment_update_form").validate({
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
                        validate_file_type:true,  
                    },
                },
                messages:{
                    "equipment_photo[]":{
                        accept:"{{ trans('messages.gallery_image_validation') }}",
                    },
                },
            });

            $('#equipment_update_form').ajaxForm({
                beforeSend: function() {
                    $('.equipment-update i').removeClass('fa-long-arrow-alt-right');
                    $('.equipment-update i').addClass('fa-spinner fa-spin');
                    $('.equipment-update').prop('disabled', true);
                    $('span.error').remove();
                    $('#equipment_create_form .error').removeClass('error');
                },
                success: function(response) {
                    $('.equipment-update i').removeClass('fa-spinner fa-spin');
                    $('.equipment-update i').addClass('fa-long-arrow-alt-right');
                    $('#update-equipement .custom_error').addClass('hide');
                    $('.equipment-update').prop('disabled', false);
                    if (response.success) {
                        $('#update-equipement .custom_success').text(response.message).removeClass('hide');
                        setTimeout(function(){
                            $('.custom_success').addClass('hide');
                            equipmentList();
                            $('#update-equipement').modal('hide');
                        },2000);
                    } else {
                        if (response.errors) {
                            $.each(response.errors, function(key, val) {
                                $("input[name="+key+"], select[name="+key+"]").addClass('error');
                                $("input[name="+key+"], select[name="+key+"]").after('<span for="'+key+'" generated="true" class="error">'+val[0]+'</span>');
                            });
                        }else {
                            $('#update-equipement .custom_error').text(response.message).removeClass('hide');
                        }
                    }
                }
            });
            $('body').on('click', '.delete-btn', function() {
                var id = $(this).data('id');
                $('#equipment_delete_id').val(id);
                $('#delete-equipement').modal('show');
                
            });
            
            $('#equipment_delete_form').ajaxForm({
                success: function(response) {
                    if (response.success) {
                        $('#delete-equipement').modal('hide');
                        $('.partner-register-form .custom_success').text(response.message).removeClass('hide');
                        $('html, body').animate({ scrollTop: 0 }, 'slow');
                        equipmentList();
                        setTimeout(function(){
                            $('.custom_success').addClass('hide');
                        },2000);

                    } else {
                        $('.partner-register-form .custom_error').text(response.message).removeClass('hide');
                    }
                }
            });

            $('body').on('click', '.view-btn', function(){
                var id = $(this).data('id');
                var imagGallery = '';
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    method: "GET",
                    data:{"id":id},
                    url:"{{ url('/equipment-show') }}",
                    success:function(response){
                        if (response.success) {
                            $('.equipment-name').text(response.data.equpment_info.name);
                            $('.description').text(response.data.equpment_info.description);
                            var rentType = response.data.equpment_info.rent_type ? response.data.equpment_info.rent_type.replace('_', ' ') : '-';
                            $('.rent-type').text(ucwords(rentType));
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
                $('#view-equipement').modal('show');
            });

            $('body').on('click', '.equipment-close-btn', function() {
                equipmentList();
            });

            function equipmentList(){
                $('.equipement-list-table').empty();
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    method: "GET",
                    url:"{{ url('/equipment-list') }}",
                    success:function(data){
                        $('.equipement-list-table').html(data);
                    }
                });
            }
            function ucwords (str) {
                return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
                    return $1.toUpperCase();
                });
            }

            $('body').on('click', '.equipment-photo-delete', function() {
                var provider_id = $(this).data('id');
                var media_id = $(this).data('media-id');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    method: "GET",
                    data:{"id":provider_id, 'media_id':media_id },
                    url:"{{ url('/equipment-photo-delete') }}",
                    success:function(response) {
                       if (response.success) {
                            if(response.media_count == 0) {
                                $('#update-equipment-image').val('');
                                $('.equipment-file-name').text('Equipment Photo *');
                            }
                            $('#eqp_photo_'+media_id).remove();
                            $('#update-equipement .custom_success').text(response.message).removeClass('hide');
                                setTimeout(function(){
                                    $('.custom_success').addClass('hide');
                                },2000);
                        } else {
                            $('#update-equipement .custom_error').text(response.message).removeClass('hide');
                        }
                    }
                });
            });
        });
    </script>
@endpush