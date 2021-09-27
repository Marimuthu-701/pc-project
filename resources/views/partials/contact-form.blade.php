<div class="container partner-register-form contact-form-title">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header contact-form-page-title">
                    <h3 class="partner-form-title">{{ trans('messages.customer_need_help') }}</h3>
                    <p>{{ trans('messages.customer_need_help_description') }} {{ trans('messages.or') }}</p> 
                    <div class="contact-call-us">
                        <span>{{ trans('messages.contact_call_us', ['contact_no'=> config('app.contact_number')]) }}</span>
                    </div>
                </div>
                <div class="card-body">
                    @if(Session::has('message'))
                        <div class="custom_success alert alert-success">
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    <div class="custom_error alert alert-danger hide"></div>
                    <div class="custom_success alert alert-success hide"></div>
                    <form method="POST" action="{{ route('contact.email') }}" id="contact-form" class="register_form" id="contact-form">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                 <input type="text" class="form-control" id="name" name="contact_name" placeholder="{{ trans('auth.name')}} *">
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <input type="email" class="form-control" id="email_address" name="contact_email" placeholder="{{ trans('auth.email_address') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <input type="text" class="form-control" id="mobile_number" name="contact_mobile" maxlength="10" placeholder="{{ trans('auth.mobile_number')}} *">
                            </div>
                            <div class="col-lg-6 col-xs-12 register-form-input">
                            	<textarea id="message" row="5" class="form-control @error('message') is-invalid @enderror" name="message" value="{{ old('message') }}" placeholder="{{ trans('messages.message')}} *"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6 col-xs-12 register-form-input">
                                <button type="submit" class="btn btn-primary register_btn contact_btn">
                                    {{ trans('auth.submit') }}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i>
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