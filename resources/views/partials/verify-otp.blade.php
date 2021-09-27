<div class="card-header verify-otp-head">{{ trans('messages.verify_otp') }}</div>
<div class="card-body">
    <div class="alert alert-success custom_success hide"></div>
    <div class="alert alert-danger custom_error hide"></div>
    <div class="row form-group">
        <div class="col-lg-12 col-md-12 col-xs-12 text-center">
            <div class="otp-user-message">
                {{ trans('messages.please_enter_otp') }}<br>
                <label class="send_otp_mobile_no"></label>
            </div>
        </div>
    </div>
    <form method="POST" action="{{ route('verify.otp') }}" id="verify_otp_form" class="form-group" name="verify_otp_form">
        @csrf
        <input type="hidden" name="mobile_number" value="" id="otp_mobile_number">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="otp-number-box">
                    <input id="otp_number" type="text" class="form-control otp-input-box @error('otp_number') is-invalid @enderror" name="otp_number" value="{{ old('otp_number') }}" maxlength="6">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12 text-center">
                <button type="submit" class="btn btn-primary reset_password_btn common-btn">
                    {{ trans('messages.verify_btn') }}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i>
                </button>
            </div>
        </div>
    </form>
    <form method="POST" class="form-group" name="resend-otp" id="resend-otp" action="{{ route('password.email') }}">
        @csrf
        <input type="hidden" class="form-control" name="mobile_number" id="resend_mobile_number">
        <div class="row otp-resend-div">
            <div class="col-lg-12 col-md-12 col-xs-12 form-group text-center">
                Didn't receive the code? <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="Your verification code is on its way! It may take a few minutes to deliver depending on your service provider."></i>
            </div>
            <div class="col-lg-12 col-md-12 col-xs-12 form-group text-center resend-btn-div">
                <button type="submit" class="btn btn-primary resend-btn common-btn">
                    {{ trans('messages.re_send_btn') }}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i>
                </button>
            </div>
        </div>   
    </form>
</div>