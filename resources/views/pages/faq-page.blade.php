@extends('layouts.app')

@section('meta_title')
{{ metaTitle('FAQ') }}
@stop

@section('content')
<div class="main-container">
	<div class="container footer-page-container faq-page">
	    <div class="row justify-content-center">
	        <div class="col-lg-12">
	            <span>
	                <a href="{{ route('home') }}" class="go-to-home">
	                    <i class="fas fa-home"></i>
	                    {{ __('Home') }} / {{ __('Faqs') }}
	                </a>
	            </span>
	            <div class="card">
	                <div class="card-body">
	                    <div class="text-center">
							<h1 class="card-title page-title">{{ trans('messages.frequently_asked_question') }}</h1>
	                    </div>
	                    <div id="accordion">
							<div class="card">
								<div class="card-header" id="faq_1">
									<h5 class="mb-0">
										<a  data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">{{ trans('messages.faq_question_1') }}<span class="pull-right open-close-icon"><i class="fas fa-plus"></i></span>
										</a>
									</h5>
								</div>
								<div id="collapseOne" class="collapse show faq_answer" aria-labelledby="faq_1" data-parent="#accordion">
									<div class="card-body">
										<p>"The Parents Care" is an online platform which helps customers to find Care providers as per their requirements. Customers can search based on services required and location of their choice.</p>
										
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="faq_2">
									<h5 class="mb-0">
										<a class="collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">{{ trans('messages.faq_question_2') }}<span class="pull-right open-close-icon"><i class="fas fa-plus"></i></span>
										</a>
									</h5>
								</div>
								<div id="collapseTwo" class="collapse faq_answer" aria-labelledby="faq_2" data-parent="#accordion">
									<div class="card-body">
										<p>"The Parents Care" website showcases list of Care providers in the following categories:</p>
										<ul>
											<li>Home Nursing</li>
											<li>Trained Attendants</li>
											<li>Physiotherapists</li>
											<li>Occupational Therapists</li>
											<li>Medical Equipment Rental</li>
											<li>Old Age Paid Homes</li>
											<li>Retirement Homes</li>
											<li>Ambulance Services</li>
											<li>Lab Services</li>
											<li>Pharmacy Services (Medical & Surgical)</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="faq_3">
									<h5 class="mb-0">
										<a class="collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">{{ trans('messages.faq_question_3') }}<span class="pull-right open-close-icon"><i class="fas fa-plus"></i></span>
										</a>
									</h5>
								</div>
								<div id="collapseThree" class="collapse faq_answer" aria-labelledby="faq_3" data-parent="#accordion">
									<div class="card-body">
										<p>We are PAN India company. Care providers registered on our website are from major cities in India. You can choose the Care providers and their services by searching them based on your location.</p>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="faq_4">
									<h5 class="mb-0">
										<a class="collapsed" data-toggle="collapse" data-target="#collapse_4" aria-expanded="false" aria-controls="collapse_4">{{ trans('messages.faq_question_4') }}<span class="pull-right open-close-icon"><i class="fas fa-plus"></i></span>
										</a>
									</h5>
								</div>
								<div id="collapse_4" class="collapse faq_answer" aria-labelledby="faq_4" data-parent="#accordion">
									<div class="card-body">
										<p>Signing in with our website will enable you to see the Care provider details and their service charges. You could compare various service providers and finalise based on your requirements.</p>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="faq_5">
									<h5 class="mb-0">
										<a class="collapsed" data-toggle="collapse" data-target="#collapse_5" aria-expanded="false" aria-controls="collapse_5">{{ trans('messages.faq_question_5') }}<span class="pull-right open-close-icon"><i class="fas fa-plus"></i></span>
										</a>
									</h5>
								</div>
								<div id="collapse_5" class="collapse faq_answer" aria-labelledby="faq_5" data-parent="#accordion">
									<div class="card-body">
										<p>Yes, once you see the contact details of service provider, you contact the Care provider directly to discuss your requirement and finalise the fees. “The Parents Care” does not charge anything from Care seekers as well as Care providers.</p>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="faq_6">
									<h5 class="mb-0">
										<a class="collapsed" data-toggle="collapse" data-target="#collapse_6" aria-expanded="false" aria-controls="collapse_6">{{ trans('messages.faq_question_6') }}<span class="pull-right open-close-icon"><i class="fas fa-plus"></i></span>
										</a>
									</h5>
								</div>
								<div id="collapse_6" class="collapse faq_answer" aria-labelledby="faq_6" data-parent="#accordion">
									<div class="card-body">
										<p>Yes, however we don't check the authenticity of all profiles. The profiles that are verified by Parents Care will have verified profile flag against their profile. However, as a customer you are required to verify the Care provider details before you avail their services, for your safety. Since we are just an online aggregator of Care providers, “The Parents Care” is not responsible for any losses/liability incurred by Care seekers and/or Care providers.</p>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="faq_7">
									<h5 class="mb-0">
										<a class="collapsed" data-toggle="collapse" data-target="#collapse_7" aria-expanded="false" aria-controls="collapse_7">{{ trans('messages.faq_question_7') }}<span class="pull-right open-close-icon"><i class="fas fa-plus"></i></span>
										</a>
									</h5>
								</div>
								<div id="collapse_7" class="collapse faq_answer" aria-labelledby="faq_7" data-parent="#accordion">
									<div class="card-body">
										<p>“The Parents Care” checks the Care provider details and then marks them as verified profile. For extra safety, we request the customer to verify Care provider’s identity before they start their service. Since we are just an online aggregator of Care providers, “The Parents Care” is not responsible for any losses/liability incurred by Care seekers and/or Care providers.</p>
									</div>
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
<script type="text/javascript">
	$(document).ready(function(){
        // Add minus icon for collapse element which is open by default
        $(".collapse.show").each(function(){
        	$(this).prev(".card-header").find(".fas").addClass("fa-minus").removeClass("fa-plus");
        	$('.fa-minus').css('color', '#005295');
        	$('.fa-plus').css('color', '#555555');
        });
        
        // Toggle plus minus icon on show hide of collapse element
        $(".collapse").on('show.bs.collapse', function(){
        	$(this).prev(".card-header").find(".fas").removeClass("fa-plus").addClass("fa-minus");
        	$('.fa-minus').css('color', '#005295');
        	$('.fa-plus').css('color', '#555555');
        }).on('hide.bs.collapse', function(){
        	$(this).prev(".card-header").find(".fas").removeClass("fa-minus").addClass("fa-plus");
        	$('.fa-minus').css('color', '#005295');
        	$('.fa-plus').css('color', '#555555');
        });
    });
</script>
@endpush