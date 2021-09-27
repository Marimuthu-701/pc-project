@extends('layouts.app')
@section('content')
<div class="main-container" id="services-list">
	<div class="container">
		<div class="service-list-container">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sx-12 text-center">
					<div class="service-left-panel ">
						<img src="{{ asset('images/services/physiotherapy.jpg') }}"  class="service-img">
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sx-12">
					<div class="service-right-panel text-justify">
						<div class="card">
							<div class="card-body">
								<h1 class="card-title">Physiotherapy</h1>
								<p class="card-text">
								Physiotherapists @ Home work to a personalized healing plan based on the patient's problem to help them regain mobility and provide them comfort from the pain and convenience @ their home. Our physiotherapsists are well-trained and experienced across many pressing health issues like back pain, neck pain, knee pain, and ligament issues to Parkinsons, Paralysis, Cerebral Palsy, and more. Our physiotherapists can heal both chronic and acute problems at home.</p>
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