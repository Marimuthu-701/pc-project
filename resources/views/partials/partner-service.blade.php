<div class="container partner-register-form partner_service">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="partner-form-title">{{ trans('auth.partner_service') }}</h3>
                </div>
                <div class="card-body">
                    <div class="custom_error alert alert-danger hide"></div>
                    <div class="custom_success alert alert-success hide"></div>
                    <form method="POST" action="{{ route('partner.register') }}/{{ $type }}" class="register_form" id="partner_service_form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <select id="service_name" class="form-control @error('service_name') is-invalid @enderror" name="service_name">
                                    <option value="">{{ trans('auth.service_name') }} *</option>
                                        @foreach($seriveName as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" placeholder="{{ trans('auth.name')}} *" autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <input id="father_name" type="text" class="form-control @error('father_name') is-invalid @enderror" name="father_name" value="{{ old('father_name') }}" autocomplete="father_name" placeholder="{{ trans('auth.father_name')}} *" autofocus>
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <input id="qualification" type="text" class="form-control @error('qualification') is-invalid @enderror" name="qualification" value="{{ old('qualification') }}" autocomplete="qualification" placeholder="{{ trans('auth.qualification')}} *" autofocus>
                                <!-- <input id="qualification" type="file" class="form-control @error('qualification') is-invalid @enderror" name="qualification" autocomplete="qualification"> -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <label for="qualification_certificate" class="custom-file-upload"> {{ trans('auth.qualification_certificate') }}</label>
                                <input id="qualification_certificate" type="file" name="qualification_certificate" />
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <input id="dob" type="text" class="form-control @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob') }}" placeholder="{{ trans('auth.dob') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-12 col-lg-6 register-form-input">
                                <select id="year_of_passing" class="form-control @error('year_of_passing') is-invalid @enderror" name="year_of_passing">
                                    <option value="">{{ trans('auth.year_of_passing') }} *</option>
                                        @foreach($year_of_paasing as $key => $value)
                                            <option value="{{ $value }}">{{ $value }}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-xs-12 col-lg-6 register-form-input">
                                <input id="name_of_college" type="text" class="form-control @error('name_of_college') is-invalid @enderror" name="name_of_college" placeholder="{{ trans('auth.name_of_the_college') }} *" value="{{ old('name_of_college') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <input id="currently_working_at" type="text" class="form-control @error('currently_working_at') is-invalid @enderror" name="currently_working_at" placeholder="{{ trans('auth.currently_working_at') }} *" value="{{ old('currently_working_at') }}">
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <input id="area_of_specialization" type="text" class="form-control @error('area_of_specialization') is-invalid @enderror" name="area_of_specialization" value="{{ old('area_of_specialization') }}" autocomplete="area_of_specialization" placeholder="{{ trans('auth.area_of_specialization') }} *">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <input id="total_year_of_experience" type="text" class="form-control @error('total_year_of_experience') is-invalid @enderror" name="total_year_of_experience" value="{{ old('total_year_of_experience') }}" autocomplete="total_year_of_experience" placeholder="{{ trans('auth.total_year_of_exp') }} *">
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <select id="preferred_shift_time" class="form-control @error('preferred_shift_time') is-invalid @enderror" name="preferred_shift_time">
                                    <option value=""> {{ trans('auth.preferred_shift_time') }} *</option>
                                    @foreach( $shifts as $key => $value)
                                        <option value="{{ $key }}"> {{ $value }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <input id="charges" type="text" class="form-control @error('charges') is-invalid @enderror" name="charges" value="{{ old('charges') }}" autocomplete="charges" placeholder="{{ trans('auth.charges') }} *">
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input"></div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <textarea id="current_address" row="5" class="form-control @error('current_address') is-invalid @enderror" name="current_address" value="{{ old('current_address') }}" autocomplete="current_address" placeholder="{{ trans('auth.current_address') }} *"></textarea>
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input">                                
                                <textarea id="any_additional_info" row="5" class="form-control @error('any_additional_info') is-invalid @enderror" name="any_additional_info" value="{{ old('any_additional_info') }}" placeholder="{{ trans('auth.any_additional_info') }}"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <button type="submit" class="btn btn-primary register_btn">
                                    &nbsp;&nbsp;&nbsp;{{ trans('auth.submit') }}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i>
                                </button>
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input"></div>
                        </div>
                    </form>
                </div>
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

        $("#partner_service_form").validate({
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
                    //required:true,
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

        $('#partner_service_form').ajaxForm({
            url: base_url + 'partner/register/service',
            beforeSend: function() {
                $('.register_btn i').removeClass('fa-long-arrow-alt-right');
                $('.register_btn i').addClass('fa-spinner fa-spin');
                $('span.error').remove();
                $('#partner_service_form .error').removeClass('error');
            },
            success: function(response) {
                $('.register_btn i').removeClass('fa-spinner fa-spin');
                $('.register_btn i').addClass('fa-long-arrow-alt-right');
                $('.partner_service .custom_error').addClass('hide');
                if (response.success) {
                    $('.partner_service .custom_success').text(response.message).removeClass('hide');
                    setTimeout(function(){
                        $('.custom_success').addClass('hide'); 
                        window.location.href = response.redirect_url;
                    }, 2000);
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