@php
    $service = App\Models\Service::select('id')->where('form_set', App\Models\Service::FORM_SET_3)->first();
    $service_id = $service->id;
if (Auth::check()) {
    if(Auth::user()->type == App\Models\User::TYPE_USER) {
        $postal_code = isset(Auth::user()->postal_code) ?Auth::user()->postal_code : null;
        $city = isset(Auth::user()->city) ?Auth::user()->city : null;
        $state = isset(Auth::user()->state) ? Auth::user()->state :null;
    }else {
        $serviceDetail = App\Models\PartnerService::whereUserId(Auth::id())->first();
        $city = isset($serviceDetail->city) ? $serviceDetail->city : null;
        $state = isset($serviceDetail->state) ? $serviceDetail->state :null;
        $postal_code = isset($serviceDetail->postal_code) ? $serviceDetail->postal_code : null;
    }
} else {
    $city = null;
    $state = null;
    $postal_code = null;
}
@endphp
<section id="homes-services">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
               <a href="{{route('search', ['service_id'=>$service_id, 'state'=>$state, 'location'=>$city, 'type'=>'home', 'postal_code'=>$postal_code])}}"><img src="{{ asset('images/home_near_me.png') }}" alt="#"></a>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <a href="{{route('search', ['state'=>$state, 'location'=>$city, 'type'=>'service', 'postal_code'=>$postal_code])}}"><img src="{{ asset('images/services_near_me.png') }}" alt="#"></a>
            </div>
        </div>
    </div>
</section>