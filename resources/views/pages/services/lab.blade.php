@extends('layouts.app')
@section('content')
<div class="main-container" id="services-list">
	<div class="container">
		<div class="service-list-container">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sx-12 text-center">
					<div class="service-left-panel ">
						<img src="{{ asset('images/services/lab.jpg') }}"  class="service-img">
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sx-12">
					<div class="service-right-panel text-justify">
						<div class="card">
							<div class="card-body">
								<h1 class="card-title">Lab Tests</h1>
								<p class="card-text">
								Lab services @ home simplifies and reduces the discomfort of visiting a lab in the early morning to give the blood samples in empty stomach. Our patients can quickly find a nearest Lab around them and select any of the tests provided (or) upload the lab request form given by the doctor to them for booking the request. Lab reports will be shared through Whatsapp and eMail once ready.</p>
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