<div class="container partner-register-form partner-home">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="partner-form-title">{{ trans('messages.my_home') }}</h3>
                </div>
                @if(!empty($homeInfo))
                <div class="card-body">
                    <div class="custom_error alert alert-danger hide"></div>
                    <div class="custom_success alert alert-success hide"></div>
                    <form method="POST" action="{{ route('profile.home.update') }}" class="register_form" id="partner_home_form" enctype="multipart/form-data">
                        <input type="hidden" name="partner_id" value="{{ $partnerInfo->id}}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="home_name" class="col-lg-6 col-form-label my-account-lable required">{{ trans('auth.home_name')}}</label>
                                <input id="home_name" type="text" class="form-control @error('home_name') is-invalid @enderror" name="home_name" value="{{ isset($homeInfo->name) ? $homeInfo->name : old('home_name') }}" autocomplete="home_name" placeholder="{{ trans('auth.home_name')}}" autofocus>
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="number_of_rooms" class="col-lg-6 col-form-label my-account-lable required">{{ trans('auth.number_of_rooms')}}</label>
                                <input id="number_of_rooms" type="text" class="form-control @error('number_of_rooms') is-invalid @enderror" name="number_of_rooms" value="{{ isset($homeInfo->no_of_rooms) ? $homeInfo->no_of_rooms : old('number_of_rooms') }}" autocomplete="number_of_rooms" placeholder="{{ trans('auth.number_of_rooms')}}" autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="contact_person" class="col-lg-6 col-form-label my-account-lable required">{{ trans('auth.contact_person')}}</label>
                                <input id="contact_person" type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" value="{{ isset($homeInfo->contact_person) ? $homeInfo->contact_person : old('contact_person') }}" autocomplete="contact_person" placeholder="{{ trans('auth.contact_person')}}" autofocus>
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="contact_phone" class="col-lg-6 col-form-label my-account-lable required">{{ trans('auth.contact_phone') }}</label>
                                <input id="contact_phone" type="text" class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone" value="{{ isset($homeInfo->contact_phone) ? $homeInfo->contact_phone : old('number_of_rooms') }}" autocomplete="contact_phone" placeholder="{{ trans('auth.contact_phone') }}" maxlength="10" autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="facilities_available" class="col-lg-6 col-form-label my-account-lable required">{{ trans('auth.facilities_available')}}</label>
                                <select id="facilities_available" class="form-control @error('facilities_available') is-invalid @enderror" name="facilities_available[]" multiple>
                                    <option value=""> {{ trans('auth.facilities_available') }}</option>
                                    @foreach( $facilities_list as $key => $value)
                                        <option value="{{ $value->id }}" @if( isset($selectedfecility[$value->id]) && ( $selectedfecility[$value->id] == $value->id)) selected="selected" @endif> {{ $value->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="room_rent" class="col-lg-6 col-form-label my-account-lable required">{{ trans('messages.room_rent') }}</label>
                                <input id="room_rent" type="text" class="form-control @error('room_rent') is-invalid @enderror" name="room_rent" value="{{ isset($homeInfo->room_rent) ? $homeInfo->room_rent : old('number_of_rooms') }}" autocomplete="room_rent" placeholder="{{ trans('messages.room_rent') }}" maxlength="10" autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="other_facilities_available" class="col-lg-6 col-form-label my-account-lable">{{ trans('auth.other_facilities')}}</label>
                                <textarea id="other_facilities_available" type="text" class="form-control @error('other_facilities_available') is-invalid @enderror" name="other_facilities_available" placeholder="{{ trans('auth.other_facilities_available') }}">{{ isset($homeInfo->other_facilities) ? $homeInfo->other_facilities : old('other_facilities_available') }}</textarea>
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="address" class="col-lg-6 col-form-label my-account-lable required">{{ trans('auth.address')}}</label>
                                <textarea id="address" row="5" class="form-control @error('address') is-invalid @enderror" name="address" autocomplete="address" placeholder="{{ trans('auth.address') }}">{{ isset($homeInfo->address) ? $homeInfo->address : old('address') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="check_home_img" class="col-lg-6 col-form-label my-account-lable required">{{ trans('auth.upload_photo')}}</label>
                                <input id="check_home_img" type="hidden" name="check_home_img" value="{{ isset($homeImageMedia[0]) ? $homeImageMedia[0]->source : ''}}">
                                <label for="upload_photo" class="custom-file-upload my-accout-file"> {{ isset($homeImageMedia[0]) ? substr($homeImageMedia[0]->source, -25 ) : trans('auth.upload_photo') }}</label>
                                <input id="upload_photo" type="file" name="upload_photo[]" multiple/>
                            </div>
                        </div>
                         <div class="form-group row">
                            <div class="col-lg-12 col-xs-12 register-form-input upload_images_gallery">
                                @if( count($homeImageMedia) > 0)
                                    @foreach($homeImageMedia as $key => $value)
                                        <div class="col-md-3">
                                            @if($value['type'] != "file")
                                                <a href="{{ asset('storage/'.App\Models\Partner::HOME_MEDIA_PATH.$value['source']) }}" target="_blank"><img src="{{ asset('storage/'.App\Models\Partner::HOME_MEDIA_PATH.$value['source']) }}" width="250" height="250" class="service-image"></a>
                                            @else
                                                <a href="{{ asset('storage/'.App\Models\Partner::HOME_MEDIA_PATH.$value['source']) }}" target="_blank" class="service-file"> {{ substr ($value['source'], -25) }} </a>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <button type="submit" class="btn btn-primary register_btn">
                                    &nbsp;&nbsp;&nbsp;{{ trans('messages.update') }}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i>
                                </button>
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input"></div>
                        </div>
                    </form>
                </div>
                @else
                    <div class="right-search-result-panel wish_list_empty text-center">
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
        function imagesPreview(input, placeToInsertImagePreview,file_type) {
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
                                        <div class="file-uploade-gallery">
                                            <img src=`+imageUrl+` class="upload-image" width="175px" height="150px">
                                            <div class="uploaded-romove-imag"><span class="remove-btn" data-id="`+i+`">Remove &nbsp;&nbsp;<i class="fas fa-trash-alt"></i></span></div>
                                        </div>
                                      </div>`;
                        $(imgGallery).appendTo(placeToInsertImagePreview);
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }
        };
        $('#upload_photo').on('change',function(e) {
            $('div.upload_images_gallery').empty();
            var file_name = e.target.files[0]? e.target.files[0].name : '' ; //$(this).val();
            var fileType  = file_name.replace(/^.*\./, '').toLowerCase();
            $('.custom-file-upload').html(file_name);
            imagesPreview(this, 'div.upload_images_gallery',fileType);
        });

        //valiation for currency
        $.validator.addMethod("currency", function (value, element) {
            var isValidMoney = /^\d{0,9}(\.\d{0,2})?$/.test(value);
            return this.optional(element) || isValidMoney;
        }, "Please a valid amount");

        // Mobile validation
        $.validator.addMethod("mobileValidation",
            function(value, element) { return !value.match(/^(\d)\1+$/g); },
        "Mobile number is invalid");

        //This validation for multiple file upload
        $.validator.addMethod("validate_file_type",
            function(val,elem) { var files    =   $('#'+elem.id)[0].files;
                for(var i=0;i<files.length;i++){
                    var fname = files[i].name.toLowerCase();
                    var re = /(\.pdf|\.docx|\.doc|\.jpeg|\.jpg|\.png|\.bmp)$/i;
                    if(!re.exec(fname)){console.log("File extension not supported!");return false;}
                }
                return true;
            },
            "Please upload jpeg,jpg,png,bmp,pdf formats only"
        );
        
        $("#partner_home_form").validate({
            errorElement: 'span',
            ignore: [],
            rules: {
                home_name:{
                    required: true,
                },
                number_of_rooms:{
                   required: true,  
                },
                contact_person: {
                    required: true,
                },
                contact_phone: {
                    required: true,
                    mobileValidation: true,
                },
                "facilities_available[]": {
                    required: true,
                },
                room_rent: {
                    required: true,
                    currency:true,
                },
                address:{
                    required:true,
                },
                "upload_photo[]":{
                    required:{
                        depends : function(element) {
                            return $("#check_home_img").is(":blank");
                        }
                    },
                    validate_file_type : true,
                    //extension: "jpeg|jpg|png|bmp|pdf|doc|docx",
                }
            },
            messages:{
                upload_photo:{
                    extension:'Please upload jpeg,jpg,png,bmp,pdf formats only',
                }
            }
        });
        $('#partner_home_form').ajaxForm({
            url: base_url + 'profile/home/update',
            beforeSend: function() {
                $('.register_btn i').removeClass('fa-long-arrow-alt-right');
                $('.register_btn i').addClass('fa-spinner fa-spin');
                $('span.error').remove();
                $('#partner_home_form .error').removeClass('error');
            },
            success: function(response) {
                $('.register_btn i').removeClass('fa-spinner fa-spin');
                $('.register_btn i').addClass('fa-long-arrow-alt-right');
                $('.partner-home .custom_error').addClass('hide');
                if (response.success) {
                    $('.partner-home .custom_success').text(response.message).removeClass('hide');
                    setTimeout(function(){
                        $('.custom_success').addClass('hide');
                    },2000);
                }else if (response.errors) {
                    $.each(response.errors, function(key, val) {
                        $("input[name="+key+"], select[name="+key+"]").addClass('error');
                        $("input[name="+key+"], select[name="+key+"]").after('<span for="'+key+'" generated="true" class="error">'+val[0]+'</span>');
                    });
                }else {
                    $('.partner-home .custom_error').text(response.message).removeClass('hide');
                }
            }
        });
    });
</script>
@endpush