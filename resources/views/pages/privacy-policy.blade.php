@extends('layouts.app')

@section('meta_title')
{{ metaTitle('Privacy Policy') }}
@stop

@section('content')
<div class="main-container">
	<div class="container footer-page-container">
	    <div class="row justify-content-center">
	        <div class="col-lg-12">
	            <span>
	                <a href="{{ route('home') }}" class="go-to-home">
	                    <i class="fas fa-home"></i>
	                    {{ __('Home') }} / {{ trans('messages.privacy_policy') }}
	                </a>
	            </span>
	            <div class="card">
	                <div class="card-body">
	                    <div class="text-center">
							<h1 class="card-title page-title tc-and-policy">{{ trans('messages.privacy_policy') }}</h1>
							<h2 class="card-subtitle page-subtitle confidential hide">{{ trans('messages.confidentiality') }}</h2>
	                    </div>
	                    <p class="card-text">
	                    The Parents Care (TPC) is committed to ensure that your information is safe and secure. We take utmost care to protect your privacy and to prevent unauthorized access or disclosure of your information, by putting in place appropriate procedures to safeguard and secure the information we collect online.</p>
						<p class="card-text">
						<a href="{{ env('APP_URL') }}">www.theparentscare.com</a> (TPC) website is part of M/s. EXTATICA HOME CARE SERVICES PRIVATE LTD., whose registered office is situated at Plot No. 25, First Main Road, First Cross Street, Sabari Nagar Extn, Mugalivakkam, Chennai- 600125, herein after called TPC. The term "www.theparentscare.com" or "us" or "TPC" or "we" refers to the owner of the website M/s. EXTATICA HOME CARE SERVICES PRIVATE LTD. The term “you” refers to the viewer or user of this website or Care providers listed in this website.</p>
						<p class="card-text">
						At <a href="{{ env('APP_URL') }}">www.theparentscare.com</a> website, we display Health Care provider’s information like name, mobile number, email id, education, years of experience, location, profile image, service fee, area of specialization etc.; hence by registering your profile( Care provider) at TPC website you are agreeing to display all these information on our website. The guest/registered user can see your information as mentioned above, and contact you directly to avail your health care services.</p>
						<p class="card-text"> 
						We will not sell, distribute or lease, your personal information to third parties unless required by law to do so</p>
						<p class="card-text">
						The information provided by you shall be used by us to contact you whenever necessary. This website may contain links to third parties' websites or apps. We are not responsible for the privacy practices or the content of those websites and apps. This website may also contain links to terms and conditions, and privacy policies of third-party providers who provide tools or services on our website. Therefore, please read carefully any privacy policies on those links or websites before either agreeing to their terms or using those tools, services or websites.</p>
						<p class="card-text">
						Cookies are used to enable the browser to remember specific data so that your needs can be individually addressed. In order to do so, TPC may place both permanent and temporary cookies in your electronic gadget through which you access our website. However, cookie in no way gives us access to your computer or any information about you, other than the data you choose to share with us.
	                	</p>
	                	<p class="card-text">
	                		Despite our endeavours, breaches of security and confidentiality might occur. By signing in to our website you acknowledge that we are not liable for any loss suffered by you as a result of any breaches of security.
	                	</p>
	                	<p class="card-text">
	                		If you have any inquiry about the privacy policy of our website, you can mail us at support@theparentscare.com
	                	</p>
	                	<p class="card-text">
	                		The Parents Care reserves the right to modify any or all the terms of this policy at any time. You are advised to visit this page from time to time to review the current policy.
	                	</p>
	                </div>
	            </div>
	        </div>
	  	</div>
	</div>
</div>
@endsection