@if (!empty($token))
<div class="container reset-password-container reset-sticky-container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">

                    <div class="alert alert-success custom_success hide">                      
                    </div>
                    <div class="alert alert-danger custom_error hide">                    
                    </div>

                    <form method="POST" action="{{ route('password.update') }}" id="reset_password_form">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-lg-12 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-lg-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-new" class="col-lg-12 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-lg-12">
                                <input id="password-new" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-lg-12 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-lg-12">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-lg-12 offset-md-4">
                                <button type="submit" class="btn btn-primary reset_password_btn">
                                    {{ __('Reset Password') }} <i class="fas fa-long-arrow-alt-right"></i>
                                </button>
                            </div>
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
        $("#reset_password_form").validate({
            errorElement: 'span',
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    minlength: 5
                },
                password_confirmation: {
                    minlength : 5,
                    equalTo: '#reset_password_form #password-new',
                },
            },
            messages: {
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                email: "Please enter a valid email address",
            }
        });

        $('#reset_password_form').ajaxForm({
            beforeSend: function() {
                $('span.error').remove();
                $('#reset_password_form .error').removeClass('error');
            },
            success: function(response) {
                $('.reset-password-container .alert').addClass('hide');
                if (response.success) {
                    $('.reset-password-container .custom_success').text(response.message).removeClass('hide');
                    setTimeout(function(){ 
                        window.location.href = response.redirect_url;
                    }, 1500);
                } else {
                    if (response.errors) {
                        $.each(response.errors, function(key, val) {
                            $("input[name="+key+"]").addClass('error');
                            $("input[name="+key+"]").after('<span for="'+key+'" generated="true" class="error">'+val[0]+'</span>');
                        });
                    } else {
                        $('.reset-password-container .custom_error').text(response.message).removeClass('hide');
                    }
                }
            }
        });
    });
</script>
@endpush

@endif