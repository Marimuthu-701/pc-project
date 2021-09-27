<div class="container footer-page-container services-page-container">
    <div class="row justify-content-center">
	    <div class="col-lg-12">
	        <span>
	            <a href="{{ route('home') }}" class="go-to-home">
	                <i class="fas fa-home"></i>
	                {{ __('Home') }} / {{ trans('messages.services') }}
	            </a>
	        </span>
	        <div class="card">
	            <div class="card-body">
	                <div class="text-center">
						<h1 class="card-title page-title" style="margin-bottom:30px;">{{ trans('messages.services') }}</h1>
	                </div>
					<p class="card-text service-about">
						The Parents Care provides list of the following Care Providers near you, so that you can identify the apt care provider who meets your needs, and, avail their services at the convenience of your home:
					</p>
					<div class="row services-list-row">
					@if(count($services) > 0)
						@foreach($services as $key => $value)
						<?php /*<div class="list-service-div">
							<h2>{{ isset($value->name) ? $value->name : null }}:</h2>
							<div class="service-content">
								<p class="card-text">
									{{ isset($value->description) ? $value->description : null}} 
								</p>
								<p class="card-text find-serice-search">
									<a href="{{ route('search', ['state'=> $state, 'location'=>$city, 'service_id'=> $value->id]) }}" target="_blank">Find {{ $value->name }} near you…</a>
								</p>
							</div>
						</div> */ ?>
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 service-item">
								<div class="card">
									<a href="{{ route('search', ['state'=> $state, 'location'=>$city, 'service_id'=> $value->id, 'postal_code'=>$postal_code]) }}"  class="service-link">
										<div class="service-title">
											<h5 class="card-title service-item-header text-center">{{ isset($value->name) ? $value->name : null }}</h5>
										</div>
										<img class="card-img-top" src="{{ storage_url(App\Models\User::SERVICE_BANNER_MEDIUM_PATH . $value->banner) }}" alt="Card image cap" width="100%">
									</a>
									<!-- <div class="card-body hide">
										<div class="view-more-detail text-center">
											<a href="{{ route('search', ['state'=> $state, 'location'=>$city, 'service_id'=> $value->id]) }}" target="_blank" class="btn btn-primary">Find near you...</a>
										</div>
									</div> -->
								</div>
							</div>
						
						@endforeach
						</div>
					@endif
	            </div>
	        </div>
	    </div>
	</div>
</div>