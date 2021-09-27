@php
    $dobConvert = null;
    if(isset($serviceInfo->dob) && !empty($serviceInfo->dob)) {
        $dobConvert = date('d-m-Y',strtotime($serviceInfo->dob));
    }
@endphp
<div class="container partner-register-form partner_service">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="partner-form-title">{{ trans('messages.my_service') }}</h3>
                </div>
                @if(!empty($serviceInfo))
                <div class="card-body">
                    <div class="custom_error alert alert-danger hide"></div>
                    <div class="custom_success alert alert-success hide"></div>
                    <form method="POST" action="{{ route('profile.service.update') }}" class="register_form" id="partner_service" enctype="multipart/form-data">
                        <input type="hidden" name="partner_id" value="{{ $partnerInfo->id}}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="service_name" class="col-lg-12 col-form-label my-account-lable required">{{ trans('auth.service_name')}}</label>
                                <select id="service_name" class="form-control @error('service_name') is-invalid @enderror" name="service_name">
                                    <option value="">{{ trans('auth.service_name') }}</option>
                                        @foreach($services as $key => $value)
                                            <option value="{{ $value->id }}" @if( isset($serviceInfo->service_id) && ($serviceInfo->service_id == $value->id )) selected="selected" @endif >{{ $value->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="name" class="col-lg-12 col-form-label my-account-lable required">{{ trans('auth.name')}}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset($serviceInfo->name) ? $serviceInfo->name : old('name') }}" autocomplete="name" placeholder="{{ trans('auth.name')}}" autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="father_name" class="col-lg-12 col-form-label my-account-lable required">{{ trans('auth.father_name')}}</label>
                                <input id="father_name" type="text" class="form-control @error('father_name') is-invalid @enderror" name="father_name" value="{{ isset($serviceInfo->father_name) ? $serviceInfo->father_name : old('father_name') }}" autocomplete="father_name" placeholder="{{ trans('auth.father_name')}}" autofocus>
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="qualification" class="col-lg-12 col-form-label my-account-lable required">{{ trans('auth.qualification')}}</label>
                                <input id="qualification" type="text" class="form-control @error('qualification') is-invalid @enderror" name="qualification" value="{{ isset($serviceInfo->qualification) ? $serviceInfo->qualification : old('qualification') }}" autocomplete="qualification" placeholder="{{ trans('auth.qualification')}}" autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="dob" class="col-lg-12 col-form-label my-account-lable">{{ trans('auth.dob')}}</label>
                                <input id="dob" type="text" class="form-control @error('dob') is-invalid @enderror" name="dob" value="{{ isset($dobConvert) ? $dobConvert : old('dob') }}" placeholder="{{ trans('auth.dob') }}">
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="year_of_passing" class="col-lg-12 col-form-label my-account-lable required">{{ trans('auth.year_of_passing')}}</label>
                                <select id="year_of_passing" class="form-control @error('year_of_passing') is-invalid @enderror" name="year_of_passing">
                                    <option value="">{{ trans('auth.year_of_passing') }}</option>
                                        @foreach($year_of_paasing as $key => $value)
                                            <option value="{{ $value }}" @if( isset($serviceInfo->year_of_passing) && ( $serviceInfo->year_of_passing == $value )) selected="selected" @endif>{{ $value }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-12 col-lg-6 register-form-input">
                                <label for="name_of_college" class="col-lg-12 col-form-label my-account-lable required">{{ trans('auth.name_of_the_college')}}</label>
                                <input id="name_of_college" type="text" class="form-control @error('name_of_college') is-invalid @enderror" name="name_of_college" placeholder="{{ trans('auth.name_of_the_college') }}" value="{{ isset($serviceInfo->college_name) ? $serviceInfo->college_name : old('name_of_college') }}">   
                            </div>
                            <div class="col-xs-12 col-lg-6 register-form-input">
                                <label for="currently_working_at" class="col-lg-12 col-form-label my-account-lable required">{{ trans('auth.currently_working_at')}}</label>
                                <input id="currently_working_at" type="text" class="form-control @error('currently_working_at') is-invalid @enderror" name="currently_working_at" placeholder="{{ trans('auth.currently_working_at') }}" value="{{ isset($serviceInfo->working_at) ? $serviceInfo->working_at : old('currently_working_at') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="area_of_specialization" class="col-lg-12 col-form-label my-account-lable required">{{ trans('auth.area_of_specialization')}}</label>
                                <input id="area_of_specialization" type="text" class="form-control @error('area_of_specialization') is-invalid @enderror" name="area_of_specialization" value="{{ isset($serviceInfo->specialization_area) ? $serviceInfo->specialization_area : old('area_of_specialization') }}" autocomplete="area_of_specialization" placeholder="{{ trans('auth.area_of_specialization') }}">
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="total_year_of_experience" class="col-lg-12 col-form-label my-account-lable required">{{ trans('auth.total_year_of_exp')}}</label>
                                <input id="total_year_of_experience" type="text" class="form-control @error('total_year_of_experience') is-invalid @enderror" name="total_year_of_experience" value="{{ isset($serviceInfo->total_experience) ? $serviceInfo->total_experience :  old('total_year_of_experience') }}" autocomplete="total_year_of_experience" placeholder="{{ trans('auth.total_year_of_exp') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="preferred_shift_time" class="col-lg-12 col-form-label my-account-lable required">{{ trans('auth.preferred_shift_time')}}</label>
                                <select id="preferred_shift_time" class="form-control @error('preferred_shift_time') is-invalid @enderror" name="preferred_shift_time">
                                    <option value=""> {{ trans('auth.preferred_shift_time') }}</option>
                                    @foreach( $shifts as $key => $value)
                                        <option value="{{ $key }}" @if( isset($serviceInfo->shift_timings) && ($serviceInfo->shift_timings ==  $key ) ) selected="selected" @endif> {{ $value }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                 <label for="charges" class="col-lg-12 col-form-label my-account-lable required">{{ trans('auth.charges')}}</label>
                                <input id="charges" type="text" class="form-control @error('charges') is-invalid @enderror" name="charges" value="{{ isset($serviceInfo->charges) ? $serviceInfo->charges : old('charges') }}" autocomplete="charges" placeholder="{{ trans('auth.charges') }}">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="current_address" class="col-lg-12 col-form-label my-account-lable required">{{ trans('auth.current_address')}}</label>
                                <textarea id="current_address" row="5" class="form-control @error('current_address') is-invalid @enderror" name="current_address" autocomplete="current_address" placeholder="{{ trans('auth.current_address') }}"> {{ isset($serviceInfo->address) ? $serviceInfo->address : old('current_address') }}</textarea>
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="any_additional_info" class="col-lg-12 col-form-label my-account-lable">{{ trans('auth.any_additional_info')}}</label>
                                <textarea id="any_additional_info" row="5" class="form-control @error('any_additional_info') is-invalid @enderror" name="any_additional_info" placeholder="{{ trans('auth.any_additional_info') }}"> {{ isset($serviceInfo->additional_info) ? $serviceInfo->additional_info : old('any_additional_info') }} </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="qualification_certificate" class="col-lg-12 col-form-label my-account-lable">{{ trans('auth.qualification_certificate')}}</label>
                                <label for="qualification_certificate" class="custom-file-upload my-accout-file"> {{ isset($medias[0]) ? substr($medias[0]->source, -25 ) :  trans('auth.qualification_certificate') }}</label>
                                <input id="check_qul_img" type="hidden" name="check_qul_img" value="{{ isset($medias[0]) ? $medias[0]->source : ''}}">
                                <input id="qualification_certificate" type="file" name="qualification_certificate" />
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input media-div">
                                @if (count($medias) > 0)
                                    @foreach($medias as $key => $value)
                                        <div class="col-md-3">
                                            @if($value['type'] != "file")
                                            <a href="{{ asset('storage/'.App\Models\Partner::SERVICE_MEDIA_PATH.$value['source']) }}" target="_blank">
                                                <img src="{{ asset('storage/'.App\Models\Partner::SERVICE_MEDIA_PATH.$value['source']) }}" width="250" height="250" class="service-image">
                                            </a>
                                            @else
                                                <a href="{{ asset('storage/'.App\Models\Partner::SERVICE_MEDIA_PATH.$value['source']) }}" target="_blank" class="service-file"> {{ substr ($value['source'], -25) }} </a>
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
	$('#dob').datepicker({
        format: 'dd-mm-yyyy',
        endDate: '+0d',
        autoclose: true
    });
    $('#qualification_certificate').on('change',function(){
        var file_name = $(this).val();
        $('.custom-file-upload').html(file_name);
        $('#check_qul_img').val(file_name);

        // upload image show
        $('.service-image').attr('src', '').hide();
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            $(reader).load(function(e) {
                $('.service-image').attr('src', e.target.result);
            });
            reader.readAsDataURL(this.files[0]);
            
            $('.service-image').load(function(e) {
                $(this).show();
            }).hide();
        }
    });

    //valiation for currency
    $.validator.addMethod("currency", function (value, element) {
        var isValidMoney = /^\d{0,9}(\.\d{0,2})?$/.test(value);
        return this.optional(element) || isValidMoney;
    }, "Please a valid amount");

    // validate for date formate
    $.validator.addMethod("dateFormat",function(value, element) {
        return value.match(/^dd?-dd?-dd$/);
    },"Please enter a date in the format dd-mm-yyyy.");

    $("#partner_service").validate({
        errorElement: 'span',
        ignore: [],
        rules: {
            service_name:{
                required: true,
            },
            name:{
                required: true,
            },
            father_name:{
               required: true,  
            },
            /*dob: {
                required: true,
                //dateFormat:true,
            },*/
            qualification:{
                required:true,
            },
            qualification_certificate:{
                /*required:{
                    depends : function(element) {
                        return $("#check_qul_img").is(":blank");
                    }
                },*/
                extension: "jpeg|jpg|png|bmp|pdf|doc|docx",  
            },
            year_of_passing: {
                required:true,
            },
            name_of_college: {
                required:true,
            },
            currently_working_at: {
                required: true,
            },
            area_of_specialization:{
                required:true,
            },
            total_year_of_experience:{
                required:true,
            },
            preferred_shift_time:{
                required:true,
            },
            charges:{
                required:true,
                currency:true,
            },
            current_address:{
                required:true,
            },
        },
        messages:{
            qualification:{
                extension:'Please upload jpeg,jpg,png,bmp,pdf formats only',
            }
        }
    });

    $('#partner_service').ajaxForm({
        url: base_url + 'profile/service/update',
        beforeSend: function() {
            $('.register_btn i').removeClass('fa-long-arrow-alt-right');
            $('.register_btn i').addClass('fa-spinner fa-spin');
            $('span.error').remove();
            $('#partner_service .error').removeClass('error');
        },
        success: function(response) {
            $('.register_btn i').removeClass('fa-spinner fa-spin');
            $('.register_btn i').addClass('fa-long-arrow-alt-right');
            $('.partner_service .custom_error').addClass('hide');
            if (response.success) {
                $('.partner_service .custom_success').text(response.message).removeClass('hide');
                setTimeout(function(){
                    $('.custom_success').fadeOut();
                },2000);
            } else if (response.errors) {
                $.each(response.errors, function(key, val) {
                    $("input[name="+key+"], select[name="+key+"]").addClass('error');
                    $("input[name="+key+"], select[name="+key+"]").after('<span for="'+key+'" generated="true" class="error">'+val[0]+'</span>');
                });
            } else {
                $('.partner_service .custom_error').text(response.message).removeClass('hide');
            }
        }
    });
});
</script>
@endpush