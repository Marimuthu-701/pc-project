@extends('layouts.app')
@section('content')
<div class="main-container" id="services-list">
	<div class="container">
		<div class="service-list-container">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sx-12 text-center">
					<div class="service-left-panel ">
						<img src="{{ asset('images/services/ambulance.png') }}" class="service-img">
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sx-12">
					<div class="service-right-panel text-justify">
						<div class="card">
							<div class="card-body">
								<h1 class="card-title">Ambulance Services</h1>
								<p class="card-text">
								Patient care is paramount to us and our objective is to always provide the best possible medical transportation to our patients. This service is mainly intended to transport the patients or to move the bed-ridden seniors from their home to the nearest hospital. We are committed to provide the highest level of care available to our patients during transportation.</p>
								<!-- <h2 class="card-subtitle">How To Book The Ambulance</h6>
								    <ul class="detail-list">
									<li>Open TAH app</li>
									<li>Click Ambulance service</li>
									<li>Search &amp; find the ambulances  available.</li>
									<li>Click the confirm (now or later)option.</li>
									<li>Ambulance which accept first your request will be ready to move.</li> 
									<li>It will have option of book for others and could enter user phone number also.</li>
									<li>It could be used also for non-emergency care for patients, and transport them to and from their homes, hospitals and other medical facilities.</li>
								</ul> -->
								<p class="note-title">Please note :</p>
								<ul>
									<li>If any service provider in this app is not available, please try other options</li>
									<li>Service is extended through partners registered with us</li>
									<li>We act as facilitators to book the request through us to reach service providers</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="vl"></div>
		</div>
	</div>
</div>
@endsection