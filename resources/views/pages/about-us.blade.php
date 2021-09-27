@extends('layouts.app')

@section('meta_title')
{{ metaTitle('Abour Us') }}
@stop

@section('content')
<div class="main-container">
  	<section id="about-as-banner"></section>
  	<section id="about-as-content">
  		<div class="container footer-page-container about-us-container">
  			<div class="row">
  				<div class="col-lg-12">
		  			<div class="card">
						<div class="card-body">
							<h5 class="card-title page-title about-us-title">About Us</h5>
							<p class="card-text">
								Theparentscare.com offers families and individuals looking for elder care, a safe way to connect with a network of compassionate Care providers offering Home Nursing, Trained Attendants, Physiotherapists, Medical Equipment Rentals, Old Age Paid Homes and other Elder support services.
							</p>
							<p class="card-text">
								The main objective behind theparentscare.com is to allow Care seekers visibility into all the different Care providers in their area at affordable cost. We help to facilitate better decision making in this delicate and crucial process. Moreover <a href="{{ env('APP_URL') }}">theparentscare.com</a> allows Care providers/Companies to list their services on the website to give even more visibility and create more transparency.
							</p>
							<p class="card-text">
								Our mission is to directly connect Care seekers with a wide variety of Care providers without any listing fee. <a href="{{ env('APP_URL') }}">Theparentscare.com</a> is an absolutely transparent and free platform.
						</div>
					</div>
  				</div>
			</div>
			<!-- <div class="row about-us-detail hide">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 about-us-people">
					<div class="card">
						<img class="card-img-top" src="{{ asset('images/about-us/about-us-doctor.png')}}" alt="Card image cap" width="100%">
						<div class="card-body">
							<div class="icon-wrapper text-center">
								<a href=""><i class="fas fa-heartbeat"></i></a>
							</div>
							<h3 class="card-title text-center people-title">Our Directors</h3>
							<div class="about-us-description">
								<p class="card-text text-justify">
									Each TriBeCa founder has had personal experiences managing an older parent’s health & feel passionately about the need of professional services for the elderly in India. They bring 100+ years’ combined management experience globally.
								</p>
							</div>
							<div class="view-more-detail text-center">
								<a href="#" class="btn btn-primary">View Detail</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 about-us-people">
					<div class="card">
						<img class="card-img-top" src="{{ asset('images/about-us/about-us-management.jpg')}}" alt="Card image cap" width="100%" >
						<div class="card-body">
							<div class="icon-wrapper text-center">
								<a href=""><i class="fas fa-check-circle"></i></a>
							</div>
							<h3 class="card-title text-center people-title">Our Management Team</h3>
							<div class="about-us-description">
								<p class="card-text text-justify">
									The strong leadership of TriBeCa Care is ably supported by a carefully chosen operational team with diverse expertise across marketing, operations and communications in service oriented organisation, with the focus on creating the best elder care platform in India.
								</p>
							</div>
							<div class="view-more-detail text-center">
								<a href="#" class="btn btn-primary">View Detail</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 about-us-people">
					<div class="card">
						<img class="card-img-top" src="{{ asset('images/about-us/about-us-managers.jpg')}}" alt="Card image cap" width="100%">
						<div class="card-body">
							<div class="icon-wrapper text-center">
								<a href="#"><i class="fas fa-graduation-cap"></i></a>
							</div>
							<h3 class="card-title text-center people-title">Our Care Managers</h3>
							<div class="about-us-description">
								<p class="card-text text-justify">
									With a trusted Care Manager driven monitoring system, we provide peace of mind to the elderly and their primary carers. They ensure a no-hassles service spanning Elder Care, Post-Operative Care and other specialised care situations at home.
								</p>
							</div>
							<div class="view-more-detail text-center">
								<a href="#" class="btn btn-primary">View Detail</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row our-mission-vision hide">
				<div class="col-lg-6 col-md-6 col-sx-6 col-xs-12">
					<div class="our-mission">
						<div class="card">
							<div class="card-body">
								<h3 class="card-title"><span class="detail-title-border">Our Mission</span></h3>
								<p class="card-text">
									Our mission is to directly connect Care seekers with a wide variety of Care providers without any listing fee. <a href="{{ env('APP_URL') }}">Theparentscare.com</a> is an absolutely transparent and free platform.
								</p>
								<p class="card-text hide">
									We view ourselves as transparent and trustworthy partners to our customers, our employees our community and our environment.
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sx-6 col-xs-12">
					<div class="our-vision">
						<div class="card">
							<div class="card-body">
								<h3 class="card-title"><span class="detail-title-border">Our Vision</span></h3>
								<p class="card-text">
									The main objective behind theparentscare.com is to allow Care seekers visibility into all the different Care providers in their area at affordable cost. We help to facilitate better decision making in this delicate and crucial process. Moreover <a href="{{ env('APP_URL') }}">theparentscare.com</a> allows Care providers/Companies to list their services on the website to give even more visibility and create more transparency.
								</p>
							</div>
						</div>
					</div>
				</div>
			</div> -->
  		</div>
  	</section>
</div>
@endsection