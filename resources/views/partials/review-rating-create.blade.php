<div class="row justify-content-center">
    <div class="col-lg-12">
        <span>
        	@if($type && $slug)
        	<a href="{{ route('type.slug', ['type'=> $type, 'slug'=>$slug]) }}" class="go-to-home">
        		@if($type != App\Models\Partner::TYPE_HOME)
                	<i class="fas fa-server"></i>
                @else
                	<i class="fas fa-home"></i>
                @endif
                {{ ucfirst($type) }} / {{ trans('messages.add_review') }}
            </a>
        	@else
            <a href="{{ route('home') }}" class="go-to-home">
                <i class="fas fa-home"></i>
                {{ __('Home') }} / {{ trans('messages.add_review') }}
            </a>
            @endif
        </span>
        <div class="card">
            <div class="card-body">
                <div class="text-center">
					<h1 class="card-title page-title">{{ trans('messages.add_review') }}</h1>
                </div>
                <div class="row">
                	<div class="col-lg-6 col-md-6 col-md-offset-3">
						<div class="review-rating-form-container">
							<div class="custom_success alert alert-success hide"></div>
                			<div class="custom_error alert alert-danger hide"></div>
	                		<form method="POST" action="{{ route('review-rating.store') }}" id="review-rating-form">
	                        	@csrf
	                        	<input type="hidden" name="partner_type" value="{{ $type }}">
								<input type="hidden" name="partner_id" value="{{ $id }}">
		                        <div class="form-group row">
		                            <div class="col-lg-12 col-xs-12 pull-left provider-name">
		                            	<h4>{{ $providerName ? $providerName : '-' }}</h4>
		                            </div>
		                        </div>
					            <!-- <div class="form-group row">
					            									<div class="col-md-12">
					            										<input id="name" name="title" type="text" placeholder="{{ trans('messages.title') }} *" class="form-control">
					            									</div>
					            </div> -->
					            <div class="form-group row">
					            	<div class="col-md-12">
					                	<textarea class="form-control review-input-box"  name="comments" placeholder="{{ trans('messages.question_comments') }} *" rows="4"></textarea>
					             	</div>
					            </div>
					            <div class="form-group row">
								 	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
	                        			<label for="rating" class="col-lg-12 col-form-label my-account-lable required">Rating</label>
	                        		</div>
					              	<div class="col-md-12">
					              		<input id="rating" type="hidden" name="rating">
					              	</div>
					              <div class="rating-error" id="rating-error"></div>
					            </div>
		                        <div class="form-group row">
		                            <div class="col-lg-12 col-xs-12 text-center">
		                                <button type="submit" class="btn btn-primary post-btn">
		                                    {{ trans('messages.post_review') }}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i>
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
@push('script')
<script>
    $(document).ready(function () {

        var $inp = $('#rating');
            $inp.rating({
                min: 0,
                max: 5,
                step: 1,
                size: 'sm',
                showClear: true,
            });

        $("#review-rating-form").validate({
	        errorElement: 'span',
	        rules: {
	            /*title:{
	                required: true,
	            },*/
	            rating:{
	                required:true,
	            },
	            comments:{
	            	required:true,
	            }
	        },
	        messages:{
	        	rating : "{{ trans('messages.rating_require_msg') }}"
	        },
	        errorPlacement: function(error, element) {
                var terms = element.attr("name");
                if (terms == 'rating') {
                    error.insertAfter('#rating-error');
                }else {
                    error.insertAfter(element);
                }
            }
    	});
	    $('#review-rating-form').ajaxForm({
	        beforeSend: function() {
	            $('.post-btn i').removeClass('fa-long-arrow-alt-right');
	            $('.post-btn i').addClass('fa-spinner fa-spin');
	            $('.post-btn').prop('disabled', true);
	            $('span.error').remove();
	            $('#review-rating-form .error').removeClass('error');
	        },
	        success: function(response) {
	            $('.post-btn i').removeClass('fa-spinner fa-spin');
	            $('.post-btn i').addClass('fa-long-arrow-alt-right');
	            $('.review-rating-form-container .custom_error').addClass('hide');
	            if (response.success) {
	                $('.review-rating-form-container .custom_success').text(response.message).removeClass('hide');
	                setTimeout(function(){
	                    $('.custom_success').addClass('hide');
	                    window.location.href = response.redirect_url;
	                },2000);
	            } else if(response.data) {
	            	$('.post-btn').prop('disabled', false);
	            	$('.review-rating-form-container .custom_error').text(response.message).removeClass('hide');
                    setTimeout(function(){ $('.custom_error').addClass('hide'); }, 2000);
	            }
	            else {
	            	$('.post-btn').prop('disabled', false);
                    $('.review-rating-form-container .custom_error').text(response.message).removeClass('hide');
                    setTimeout(function(){ $('.custom_error').addClass('hide'); }, 2000);
                    window.location.href = base_url+'login';
	            }
	        }
	    });
    });
</script>
@endpush