@extends('layouts.app')

@section('meta_title')
{{ metaTitle('Add Testimonial') }}
@stop

@section('content')
<div class="main-container testimonial-container">
	<div class="container footer-page-container add_testimonialc-container">
	    <div class="row justify-content-center">
	        <div class="col-lg-12">
	            <span>
	                <a href="{{ route('home') }}" class="go-to-home">
	                    <i class="fas fa-home"></i>
	                    {{ __('Home') }} / {{ trans('messages.add_testimonial') }}
	                </a>
	            </span>
	            <div class="card">
	                <div class="card-body">
	                    <div class="text-center">
							<h1 class="card-title page-title">{{ trans('messages.add_testimonial') }}</h1>
	                    </div>
	                    <div class="row">
	                		<div class="col-lg-6 col-md-6 col-md-offset-3">
								<div class="add_testimonial-form-container">
									<div class="custom_success alert alert-success hide"></div>
		                			<div class="custom_error alert alert-danger hide"></div>
			                		<form method="POST" action="{{ route('testimonials.add') }}" id="add-testimonial-form">
			                        	@csrf
							            <div class="form-group row">
											<div class="col-md-12">
												<input id="name" name="name" type="text" placeholder="{{ trans('auth.name') }} *" class="form-control">
											</div>
							            </div>
							            <div class="form-group row">
							              	<div class="col-md-12">
							              		<input type="email" class="form-control"  placeholder="{{ trans('auth.email') }}" name="email">
							              	</div>
							            </div>
							            <div class="form-group row">
							            	<div class="col-md-12">
							                	<textarea class="form-control"  name="comments" placeholder="{{ trans('messages.message') }} *" rows="4"></textarea>
							             	</div>
							            </div>
							            <div class="form-group row">
							            	<div class="col-md-12">
							                	<textarea class="form-control"  name="address" placeholder="{{ trans('auth.address') }} *" rows="4"></textarea>
							             	</div>
							            </div>
							            <div class="form-group row">
										 	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
			                        			<label for="rating" class="col-lg-12 col-form-label my-account-lable">Rating</label>
			                        		</div>
							              	<div class="col-md-12">
							              		<input id="rating" type="text" name="rating">
							              	</div>
							            </div>
				                        <div class="form-group row">
				                            <div class="col-lg-12 col-xs-12 text-center">
				                                <button type="submit" class="btn btn-primary post-btn">
				                                    {{ trans('auth.submit') }}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i>
				                                </button>
				                            </div>
				                        </div>
			                    	</form>
	                    		</div>
                			</div>
                		</div>
	                </div>
	            </div>
	        </div>
	  	</div>
	</div>
</div>
@endsection
@push('script')
<script>
    $(document).ready(function () {
    	var $inp = $('#rating');
            $inp.rating({
                min: 0,
                max: 5,
                step: 1,
                size: 'xs',
                showClear: true,
            });
        $("#add-testimonial-form").validate({
	        errorElement: 'span',
	        rules: {
	            name:{
	                required: true,
	            },
	            email:{
	                email:true,
	            },
	            comments:{
	            	required:true,
	            },
	            address:{
	            	required:true,
	            },
	        }
    	});
	    $('#add-testimonial-form').ajaxForm({
	        beforeSend: function() {
	            $('.post-btn i').removeClass('fa-long-arrow-alt-right');
	            $('.post-btn i').addClass('fa-spinner fa-spin');
	            $('.post-btn').prop('disabled', true);
	            $('span.error').remove();
	            $('#add-testimonial-form .error').removeClass('error');
	        },
	        success: function(response) {
	            $('.post-btn i').removeClass('fa-spinner fa-spin');
	            $('.post-btn i').addClass('fa-long-arrow-alt-right');
	            $('.add_testimonialc-container .custom_error').addClass('hide');
	            if (response.success) {
	            	window.location.href = response.redirect_url;
	                /*$('.add_testimonialc-container .custom_success').text(response.message).removeClass('hide');
	                setTimeout(function(){
	                    $('.custom_success').addClass('hide');
	                },2000);*/
	            } else {
	            	$('.post-btn').prop('disabled', false);
	            	$('.add_testimonialc-container .custom_error').text(response.message).removeClass('hide');
                    setTimeout(function(){ $('.custom_error').addClass('hide'); }, 2000);
	            }
	        }
	    });
    });
</script>
@endpush