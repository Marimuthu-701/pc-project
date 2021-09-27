<div class="card-header">{{ __('Reset Password') }}</div>
<div class="card-body">
    <div class="alert alert-success custom_success hide"></div>
    <div class="alert alert-danger custom_error hide"></div>
    <form method="POST" action="{{ route('password.update') }}" id="reset_password_form">
        @csrf
        <div class="form-group row">
            <label for="reset_mobile" class="col-lg-12 col-form-label text-md-right">{{ trans('auth.email') }}</label>
            <div class="col-lg-12">
                <input id="reset_mobile" type="text" class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number" value="{{ old('mobile_number') }}"  autofocus readonly="readonly">
            </div>
        </div>
        <div class="form-group row">
            <label for="reset-password-new" class="col-lg-12 col-form-label text-md-right">{{ trans('auth.password') }}</label>
            <div class="col-lg-12">
                <input id="reset-password-new" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
            </div>
        </div>
        <div class="form-group row">
            <label for="reset-password-confirm" class="col-lg-12 col-form-label text-md-right">{{ trans('auth.confirm_password') }}</label>

            <div class="col-lg-12">
                <input id="reset-password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-lg-12 text-center">
                <button type="submit" class="btn btn-primary reset_password_btn common-btn reset-save-btn">
                    {{ __('Reset Password') }} <i class="fas fa-long-arrow-alt-right"></i>
                </button>
            </div>
        </div>
    </form>
</div>