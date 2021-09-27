@extends('layouts.app')
@section('content')
<div class="main-container" id="services-list">
	<div class="container">
		<div class="service-list-container">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sx-12 text-center">
					<div class="service-left-panel ">
						<img src="{{ asset('images/services/trained_attendant.jpeg') }}"  class="service-img">
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sx-12">
					<div class="service-right-panel text-justify">
						<div class="card">
							<div class="card-body">
								<h1 class="card-title">Trained Attendant</h1>
								<p class="card-text">
								Trained Attendant @ Home is for those loved ones who needs support and assistance with daily activities at their home. Our well trained and experienced nurses take care of day-to-day needs like mobility, hygiene and feeding elderly patients and also assist patients recovering from surgery post complex medical issues. The care includes managing the entire medication, drug administration, medical dressing, vaccination needs and also to provide other nursing help at home.</p>
								
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