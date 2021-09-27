@extends('layouts.app')
@section('content')
<div class="main-container" id="mobile_number_verification">
    <section id="partner-register">
        <div class="container otp-verification-container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="text-center verify-head">{{ trans('messages.verify_otp') }} </h1>
                        </div>
                        <div class="card-body">
                            <div class="custom_success alert alert-success hide"></div>
                            <div class="custom_error alert alert-danger hide"></div>
                            <div class="row form-group">
                                <div class="col-lg-12 col-md-12 col-xs-12 text-center">
                                    <div class="otp-user-message">
                                        {{ trans('messages.please_enter_otp') }}<br/>
                                            <label>{{ $email }}</label>
                                    </div>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('account.delete.otp.verify') }}" id="delete-account-otp" class="form-group" name="otp-verify">
                                @csrf
                                <input type="hidden" class="form-control"  name="email"  value="{{ isset($email) ? $email : null }}">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="otp-number-box">
                                            <input type="text" class="form-control otp-input-box" name="otp_number" maxlength="6" placeholder="{{ trans('messages.enter_otp')}} *" maxlength="6">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12 text-center">
                                        <button type="submit" class="btn btn-primary verify-btn">
                                            {{ trans('messages.verify_btn') }}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('partials.near-me-home-service')
</div>

<!-- Account delete confirmation -->
<div class="modal fade" id="account-delete" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="deleteAccount" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header" id="confirmation-header-popup">
            <button type="button" class="close account-delete-close-btn" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h5 class="modal-title" id="confirm-popup-title">{{ trans('messages.account_delete_confirmation') }}</h5>
        </div>
        <form name="account_delete_form" id="account_delete_form" method="post" action="{{ route('account.delete') }}">
            @csrf
        <div class="modal-body">
            <div class="custom_success alert alert-success hide popoup-response-div"></div>
            <div class="custom_error alert alert-danger hide"></div>
            <div class="delete-message">
                Do you really want to delete this account? This process cannot be undone.
            </div>
        </div>
        <div class="modal-footer" id="delete-model-footer">
            <a href="{{ route('profile.edit') }}"  class="btn btn-primary account-close-btn">{{ trans('common.cancel') }}</a>
            <button type="submit" class="btn btn-danger account-delete-btn">{{ trans('common.delete') }}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i></button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Account delete confirmation -->
@endsection