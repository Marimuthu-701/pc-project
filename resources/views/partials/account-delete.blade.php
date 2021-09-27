<div class="account-delete-container">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <h4>{{ trans('messages.delete_account_text') }}</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12 text-left">
            <h5>{{ trans('messages.delete_account_sub_text') }}</h5>
            <div class="delete-btn-section text-right">
                <button type="submit" class="btn btn-danger account-delete-btn">{{ trans('common.delete') }}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i></button>
            </div>
        </div>
    </div>
</div>

<!-- Account Delete your message and reason popup -->
<div class="modal fade" id="delete-account" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="deleteAccount" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title delete-account-title">Delete your {{ env('APP_NAME') }} Account</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form method="POST" action="{{ url('account-delete-email') }}" id="account-delete-email">
                        @csrf
                        <div class="col-md-12 user-name-section">
                            <div class="custom_error alert alert-danger hide"></div>
                            <div class="custom_success alert alert-success hide"></div>
                            <span> Hi, {{ Auth::user()->first_name }}</span>
                        </div>
                        <div class="col-md-12">
                            <p class="user-message-text">{{ trans('messages.sorry_message_text', ['site_name'=> env('APP_NAME')]) }} </p>
                            <p class="help-message-text">{{ trans('messages.reason_question_text') }}</p>
                        </div>
                        <div class="col-md-12 reason-textarea">
                            <textarea row="5" class="form-control @error('reason') is-invalid @enderror" name="reason" placeholder="{{ trans('messages.reason') }} *"></textarea>
                        </div>
                        <div class="col-md-12 user-content">
                            <p>{{ trans('messages.ok_process_message') }}</p>
                        </div>
                        <div class="col-md-12 text-center ok-button">
                            <button type="submit" class="btn btn-primary ok-btn">{{ trans('auth.submit') }}&nbsp;&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>