@php
    $searchBy = null;
    $categoryName = null;
    if($serviceName) {
        $categoryName = isset($data[0]->service_name) ? $data[0]->service_name : null;
    }
    
    if(Request::get('postal_code') && !$serviceName && !Request::get('state') && !Request::get('location')){
        $searchBy = trans('messages.search_by_pin_code', ['postal_code'=>Request::get('postal_code')]);
    }

    if(Request::get('featured')) {
        $serviceName = trans('common.is_fuatured');
        $categoryName = trans('common.is_fuatured');
    }
    if($data->total() > 1) {
        $profile = 'Profiles ';
    } else {
        $profile = 'Profile ';
    }
@endphp
<div class="custom_error alert alert-danger hide"></div>
<div class="custom_success alert alert-success hide"></div>
<p class="total-result-count"> 
    @if($serviceName && !$title_message)
        {{ $data->total() ? $data->total().' '.$categoryName.' Found' : null }}  
    @elseif($title_message)
        {{ $data->total() ? $data->total().' '.$profile.$title_message : null }}
    @elseif($searchBy)
        {{ $data->total() ? $data->total().' '.$profile.$searchBy : null }}
    @else
        {{ $data->total() ? $data->total().' Found ' : null }}
    @endif
</p>

@if (count($featureData) > 0)
    @foreach ($featureData as $key => $value)
        <div class="right-search-result-panel">
            <div class="media search-results">
                @if(Auth::check())
                    <span class="wish-list-add pull-right" data-content="{{$key}}">
                        <input type="hidden" name="content_id" id="content_id_{{$key}}" value="{{ $value['content_id']}}">
                        <input type="hidden" name="content_type" id="content_type_{{$key}}" value="{{ $value['content_type']}}">
                        <div class="wish_images" id="wish_list_image_{{$key}}">
                            @if(in_array($value['content_id'], $value['wish_list']))
                                <img src="{{ asset('images/whish_list.png') }}" data-toggle="tooltip" title="Wish listed" id="added_after_{{$key}}">
                            @else
                                <img src="{{ asset('images/whish_add.png') }}"  data-toggle="tooltip" title="Add to wish list" id="added_befor_{{$key}}">
                            @endif
                        </div>
                        <i class="fas fa-spinner fa-spin wish_list_process_{{$key}}" style="display: none;"></i>
                    </span>
                @else
                    <span class="wish-list-add-guest pull-right" data-redirect-url="{{ Request::url() }}">
                        <img src="{{ asset('images/whish_add.png') }}"  data-toggle="tooltip" title="Add to wish list">
                    </span>
                @endif 
                <div class="media-left media-middle">
                    <a href="{{ route('type.slug', ['type'=>$value['content_type'], 'slug'=>$value['slug']]) }}">
                        <img src="{{ $value['imagePath'] }}" class="media-object custom-media pull-left media-avator">
                    </a>
                    @if($value['feature_list'])
                        <div class="feature-padge">
                            <span class="badge badge-pill badge-success">Featured</span>
                        </div>
                    @endif
                </div> 
                <a href="{{ route('type.slug', ['type'=>$value['content_type'], 'slug'=>$value['slug']]) }}"> 
                    <div class="media-body">
                        <div class="media-body-container"> 
                            <h4 class="media-heading partner-title"> 
                                {{ ucfirst($value['name'])}}
                                @if($value['verified'])
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle"></i> {{ trans('messages.verified_badge') }}
                                    </span>
                                @endif
                            </h4>
                            <div class="search-rating">
                                <input type="hidden" name="rating" value="{{ isset($value['rating']) ? $value['rating'] : 0 }}" class="customer-rating">
                                <div class="serch-rating-number" ><a href="{{ route('type.slug', ['type'=>$value['content_type'], 'slug'=>$value['slug']]) }}#reviews">{{ $value['reviews'] }}</a></div>
                            </div>
                            <div class="address-detail">
                                <p>
                                    <i class="fas fa-map-marker-alt"></i>&nbsp;{{ $value['city'] }}, {{$value['state']}}
                                </p>
                                @if ($value['service_slug'] == App\Models\Service::FORM_SET_3)
                                    @if($value['room_rent'])
                                       <p>{{ trans('messages.search_room_rent') }}&nbsp;&nbsp;<i class="fas fa-rupee-sign"></i>&nbsp;{{ currency($value['room_rent']) }} </p>
                                    @endif
                                @elseif($value['service_slug'] ==  App\Models\Service::FORM_SET_1)
                                    <p>
                                        <i class="fas fa-phone"></i>&nbsp;
                                        @include('partials.mask-popup', ['data'=>$value['contact_no'], 'search'=>true, 'mobile'=>true])
                                        &nbsp;<i class="fas fa-envelope-open"></i>&nbsp;
                                        @include('partials.mask-popup', ['data'=>$value['contact_email'], 'search'=>true, 'email'=>true])
                                    </p>
                                    <p>
                                        <i class="fas fas fa-graduation-cap"></i>&nbsp;
                                        {{ $value['qualification'] }}
                                        &nbsp;<i class="fas fa-calendar-alt"></i>&nbsp;
                                        {{ trans('messages.years_of_experience') }}: {{ $value['total_experience'] }} 
                                    </p>
                                    @if($value['fees'])
                                        <p>{{ trans('messages.service_fee_per', ['fee_type'=>$value['fees_type']]) }}&nbsp;&nbsp;<i class="fas fa-rupee-sign"></i>
                                        @include('partials.mask-popup', ['data'=>currency($value['fees']), 'search'=>true, 'fees_amount'=>true])
                                        </p>
                                    @endif
                                @elseif($value['service_slug'] == App\Models\Service::FORM_SET_6)
                                    <p><i class="fas fa-tasks"></i>&nbsp;{{ $value['project_name'] }}</p>
                                @endif
                            </div>
                        </div>
                        @if($value['service_slug'] == App\Models\Service::FORM_SET_1)
                            <p>{!! Str::limit($value['specialization_area'], 250,' ...')  !!} </p>
                        @endif
                    </div>
                </a> 
            </div>
        </div>
    @endforeach
@else
    <div class="right-search-result-panel">
        <div class="search-not-found text-center">
            <span class="not-found-icon">
                <i class="fa fa-search" aria-hidden="true"></i>
            </span>
            <h4>{{ trans('messages.search_not_found', ['category'=> $serviceName]) }}</h4>
            <p>{{ trans('messages.please_try_other') }}</p>
        </div>
    </div>
@endif
<div class="col-lg-12 col-sm-12 col-xs-12 text-center">
    {{ $data->onEachSide(1)->links() }}
</div>