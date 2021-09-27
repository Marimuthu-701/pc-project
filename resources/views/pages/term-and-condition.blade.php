@extends('layouts.app')

@section('meta_title')
{{ metaTitle('Terms & Conditions') }}
@stop

@section('content')
<div class="main-container">
	<div class="container footer-page-container terms-conditions">
	    <div class="row justify-content-center">
	        <div class="col-lg-12">
	            <span>
	                <a href="{{ route('home') }}" class="go-to-home" style="text-transform: ;">
	                    <i class="fas fa-home"></i>
	                    {{ __('Home') }} / {{ trans('messages.terms_conditions') }}
	                </a>
	            </span>
	            <div class="card">
	                <div class="card-body">
	                    <div class="text-center">
							<h1 class="card-title page-title tc-and-policy" style="text-transform: uppercase;">{{ trans('messages.terms_conditions') }}</h1>
							<h2 class="card-subtitle page-subtitle confidential hide">{{ trans('messages.confidentiality') }}</h2>
	                    </div>
	                    <p class="card-text">
	                    Welcome to "The Parents Care"! By continuing to browse and use this website, you hereby agree to comply with, and be bound by the following terms and conditions of use, which together with our privacy policy govern theparentscare.com association with you in relation to this website.</p>
	                    <p class="card-text">
						<a href="{{env('APP_URL')}}">www.theparentscare.com</a> (TPC) website is part of M/s. EXTATICA HOME CARE SERVICES PRIVATE LTD., whose registered office is situated at Plot No. 25, First Main Road, First Cross Street, Sabari Nagar Extn, Mugalivakkam, Chennai- 600125, herein after called TPC, is an open platform, where Customers and Care providers register themselves to benefit each other in health care related services. The term <a href="{{env('APP_URL')}}">www.theparentscare.com</a> or "us" or "TPC" or "we" refers to the owner of the website M/s. EXTATICA HOME CARE SERVICES PRIVATE LTD. The term “you” refers to the viewer or user of this website or Care providers listed in this website.</p>
						<p class="card-text">
						TPC facilitates Customers in finding and comparing prospective health care service providers in a particular location/city across India. We are an online aggregator website between Customer and Health Care providers.</p>
						<p class="card-text">
						At <a href="env('APP_URL')">www.theparentscare.com </a> website, we display Health Care provider’s information like name, mobile number, email id, education, years of experience, location, profile image, service fee, area of specialization etc.; hence by registering your profile( Care provider) at TPC website you are agreeing to display all these information on our website. The guest/registered user can see your information as mentioned above, and contact you directly to avail your health care services.</p>
						<p class="card-text">
						Customers are requested to verify Care provider’s identity before engaging them for health care service. Customers and Care providers need to discuss requirements in detail and agree to each other’s terms & conditions before availing the services. TPC is not responsible for any loss or damage or any liabilities. It is the Customer’s responsibility to carefully check everything before engaging the Care provider. TPC is not responsible for any sort of liabilities related to Care providers and Customers in terms of mistake/misconduct/fault.</p>
						<p class="card-text">
						Fees and Payment related to Care providers are to be paid directly to them. TPC does not handle any payment between Customer and Care provider. Customers and Care providers are advised to finalise the fees before start of the service. TPC will in no way indulge in any negotiation or dispute(s) in terms of payments between Care providers and Customers.</p>
						<p class="card-text">
						Care providers are advised to fill in correct and accurate data in the website. Customer will choose the Care provider based on the education, experience, location and review feedback. Care provider has the freedom to accept or deny Customer's request any time before accepting terms and conditions of Customer. It is important for the Care provider to treat the patient with utmost care and provide best treatment to the patient.</p>
						<p class="card-text">
						TPC is involved only in connecting Care providers to the Customers in a specific location. All the booking, payment, appointment, shift timing and cancellation will be done outside the TPC website. Therefore, Customer and Care providers are requested to agree each other’s terms and conditions before rendering services.</p>
						<p class="card-text">
						TPC reserves the right to modify these terms and conditions at any time in future, without any prior notification. Please review the latest version of the terms and conditions before proceeding to avail the service. If you continue to use our service, it shall be deemed that you agree and abide by the current terms and conditions of TPC, prevailing as on that date.</p>
						<p class="card-text">
						We request you to carefully go through these terms and conditions before you decide to avail the services of TPC by registering with us. You irrevocably accept all the obligations stipulated in these terms and conditions and agree to abide by them. Accessing the <a href="{{env('APP_URL')}}">www.theparentscare.com</a> website through any medium is also subjected to these terms and conditions. These terms and conditions supersede all previous terms and conditions. By using TPC Website, you signify your agreement to these Terms and conditions. We reserve the right to modify or terminate any section of the website or the services offered by TPC for any reason, without any prior notice and without liability to you or any third party. To make sure you are aware of any changes, you are requested to review these terms and conditions periodically.</p>
						<p class="card-text">
						TPC is committed towards maintaining the privacy of the information uploaded by you on the TPC website. Our website is secured and safe. However, if any security breach happens from any external source, you acknowledge that TPC will not be liable for any loss incurred by you. </p>
						<p class="card-text">
						We ensure that every effort is made to keep the website up and running seamlessly to be available always. However, TPC takes no responsibility for, and will not be liable for, the website being temporarily unavailable due to technical issues beyond our control.</p>
						<p class="card-text">
						Unauthorized use of this website may give rise to a claim for damages and/or be a criminal offence.</p>
						<p class="card-text">
						You may not create a link to this website from another website or document without our prior written consent.</p>
						<p class="card-text">
						Your use of this website and any dispute arising out of such use of the website is subject to the laws of India and all disputes are subject to Chennai, Tamil Nadu jurisdiction.
	                	</p>
	                </div>
	            </div>
	        </div>
	  	</div>
	</div>
</div>
@endsection