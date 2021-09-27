@extends('layouts.app')
@section('content')
<div class="main-container" id="services-list">
	<div class="container">
		<div class="service-list-container">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sx-12 text-center">
					<div class="service-left-panel ">
						<img src="{{ asset('images/services/critical_care.jpg') }}" class="service-img">
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sx-12">
					<div class="service-right-panel text-justify">
						<div class="card">
							<div class="card-body">
								<h1 class="card-title">Critical Care</h1>
								<p class="card-text">
								Medicines delivery @ Home provides our patients the comfort of getting medicines delivered at their location and prevents them from the hassle of seaching for and across the pharmacies for medicines. This works simple. Patients need to select a pharmacy near to them ,search through a list of OTC (Over-The-Counter) Medicines (or) upload prescription given by the doctor, and place the order to the pharmacy to get the medicines delivered at their convenient time through our app.</p>
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