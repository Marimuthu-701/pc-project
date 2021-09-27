@php
    $dobConvert = null;
    if(isset($serviceInfo->dob) && !empty($serviceInfo->dob)) {
        $dobConvert = date('d-m-Y',strtotime($serviceInfo->dob));
    }
    $fees_type = null;
    $fees_amount = null;
    if(isset($serviceInfo->fees_per_shift) && !empty($serviceInfo->fees_per_shift)) {
        $fees_type = App\Models\PartnerService::FEE_PER_SHIFT;
        $fees_amount = $serviceInfo->fees_per_shift;
    } else if (isset($serviceInfo->fees_per_day) && !empty($serviceInfo->fees_per_day)) {
        $fees_type = App\Models\PartnerService::FEE_PER_DAY;
        $fees_amount = $serviceInfo->fees_per_day;
    }
    $shareUrl = urlencode(Request::url()); 
@endphp
<div class="container">
    <div class="row justify-content-center home-service-detail">
        <div class="col-lg-12">
            <span>
                <a href="{{ route('search', ['service_id'=>$serviceInfo->service_id]) }}" class="go-to-search">
                    <i class="fas fa-server"></i>
                    {{ __('Service') }} / {{ isset($serviceInfo->name) ? $serviceInfo->name : '-'  }}
                </a>
            </span>
            <div class="card">
                <div class="card-body">
                    <input type="hidden" name="content_id" id="content_id" value="{{$serviceInfo->id}}">
                    <input type="hidden" name="content_type" id="content_type" value="{{$type}}">
                    <div class="detail-title detail-title-rent text-center" style="display: none;">
                      <h1 class="home-service-detail-title">{{  isset($serviceInfo->name) ? $serviceInfo->name : '-'  }}</h1>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 status-badge-div">
                            <div class="verified-status-badge">
                                @if($serviceInfo->verified)
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle"></i> {{ trans('messages.verified_badge') }}
                                </span>
                                @endif
                            </div>
                            <div class="verified-status-badge">
                                @if($serviceInfo->govt_approved)
                                <span class="badge badge-success">
                                    <i class="fas fa-shield-alt"></i> {{ trans('messages.govt_approved') }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <?php /*<div class="row">
                        @if(count($bannerImage) > 0)
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div id="homeServiceCarousel" class="carousel slide" data-ride="carousel">
                                <!-- Indicators -->
                                @if(count($bannerImage) > 1)
                                <ol class="carousel-indicators">
                                    <li data-target="#homeServiceCarousel" data-slide-to="0" class="active"></li>
                                    <li data-target="#homeServiceCarousel" data-slide-to="1"></li>
                                    <li data-target="#homeServiceCarousel" data-slide-to="2"></li>
                                </ol>
                                @endif
                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                @if(count($bannerImage) > 0)
                                    @foreach ($bannerImage as $key => $value)  
                                    <div class="item @if($key == 0) active @endif">
                                        <img src="{{ $value['img_url'] }}" alt="home-image" class="home-slide-image">
                                    </div>
                                    @endforeach
                                @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div> */?>
                    @if(!$avatar_url)
                        <div class="row rating-starts">
                            <div class="col-lg-1 col-md-1 col-sm-2 col-xs-12">
                                <input type="hidden" name="rating" value="{{ isset($getAverage[0]['avarage']) ? $getAverage[0]['avarage'] : 0 }}" class="customer-rating">
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                <span class="float-right rating-count">
                                    <a href="{{ route('type.slug', ['type'=> $type, 'slug'=>$slug]) }}#reviews" class="go-to-reviews-n">
                                        @if(count($getRatingDetail) > 1) 
                                            ({{ count($getRatingDetail) }} reviews) 
                                        @else 
                                            ({{ count($getRatingDetail) }} review) 
                                        @endif
                                    </a>
                                </span>
                            </div>
                        </div>
                    @endif 
                    <div class="row form-group">
                        <!-- Home And Service Address Details -->
                        @if($avatar_url)
                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 form-group">
                            <div class="imag-gallery-container profile-image-banner">
                                <a href="javascript:void(0);" data-url="{{ $avatar_url }}" class="image-preview">
                                    <img src="{{ $avatar_thumb }}" alt="Another alt text"  class="detail-avator">
                                </a>
                            </div>
                            <div class="search-rating">
                                <input type="hidden" name="rating" value="{{ isset($getAverage[0]['avarage']) ? $getAverage[0]['avarage'] : 0 }}" class="customer-rating">
                                <div class="serch-rating-number" >
                                    <a href="{{ route('type.slug', ['type'=> $type, 'slug'=>$slug]) }}#reviews" class="go-to-reviews-n">
                                    @if(count($getRatingDetail) > 1) 
                                            ({{ count($getRatingDetail) }} reviews) 
                                        @else 
                                            ({{ count($getRatingDetail) }} review) 
                                        @endif
                                    </a>
                                </div>
                            </div>
                            <div class="custom_success alert alert-success hide"></div>
                            <div class="custom_error alert alert-danger hide"></div>
                             <div class="row form-group">
                                <div class="col-xs-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="share-bookmark">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-share-alt"></i><span>Share</span><i class="fas fa-caret-down"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="https://www.facebook.com/sharer.php?u={{$shareUrl}}" target="_blank">
                                                    <i class="fab fa-facebook-f facebook-icon"></i>
                                                    <span>Facebook</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://twitter.com/intent/tweet?url={{$shareUrl}}" target="_blank">
                                                    <i class="fab fa-twitter twitter-icon"></i>
                                                    <span>Twitter</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="http://www.linkedin.com/shareArticle?mini=true&url={{$shareUrl}}" target="_blank">
                                                    <i class="fab fa-linkedin-in linkedin-icon"></i>
                                                    <span>Linkedin</span>
                                                </a>
                                            </li>
                                            <li class="hide">
                                                <a href="https://www.google.com" target="_blank">
                                                    <i class="far fa-envelope email-icon"></i>
                                                    <span>Mail</span>
                                                </a>
                                            </li>
                                        </ul>
                                        @if(count($bookmarked) > 0)
                                            <button type="button" class="btn btn-secondary bookmarked" data-toggle="tooltip" data-placement="top" title="Already in Bookmark">
                                                <i class="fas fa-bookmark bookmark-icon"></i>
                                                <span>Bookmark</span>
                                            </button>
                                        @else
                                            @if (Auth::guest())
                                                <button type="button" class="btn btn-secondary guest-to-auth-bookmark" data-toggle="tooltip" data-placement="top" title="Add to Bookmark">
                                                    <i class="far fa-bookmark bookmark-icon add-bookmark-icon"></i>
                                                    <span>Bookmark</span>
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-secondary add-to-bookmark" data-toggle="tooltip" data-placement="top" title="Add to Bookmark">
                                                    <i class="far fa-bookmark bookmark-icon add-bookmark-icon"></i>
                                                    <i class="fas fa-spinner fa-spin process_icon hide"></i>
                                                    <span>Bookmark</span>
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                            <div class="detail-title detail-title-rent ">
                                <h1 class="home-service-detail-title">{{  isset($serviceInfo->name) ? $serviceInfo->name : '-'  }}</h1>
                            </div>
                            <div class="form-datas">
                                @if ($form_set == App\Models\Service::FORM_SET_1)
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-server form-lable-padding"></i>{{ trans('auth.service_name') }}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                              {{ isset($serviceName->name) ? $serviceName->name : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-male form-lable-icon"></i>
                                                &nbsp;{{ trans('auth.name') }}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{  isset($serviceInfo->name) ? $serviceInfo->name : '-'  }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-neuter form-lable-icon"></i>
                                                {{ trans('messages.gender')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->gender) ? ucfirst($serviceInfo->gender) : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-phone form-lable-icon"></i>{{ trans('auth.contact_phone')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                @include('partials.mask-popup', ['data'=>$serviceInfo->contact_phone, 'mobile'=>true])
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-envelope-open form-lable-icon"></i>{{ trans('auth.email')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                @include('partials.mask-popup', ['data'=>$serviceInfo->contact_email, 'email'=>true])
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-graduation-cap form-lable-padding"></i>{{trans('auth.qualification')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->qualification) ? $serviceInfo->qualification : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-calendar-alt form-lable-icon"></i>
                                                {{ trans('messages.years_of_experience')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->total_experience) ? $serviceInfo->total_experience : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-chart-area form-lable-icon"></i>{{ trans('auth.area_of_specialization')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->specialization_area) ? $serviceInfo->specialization_area : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-rupee-sign form-lable-icon"></i>
                                                {{ trans('messages.fees')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                @include('partials.mask-popup', ['data'=>$fees_amount, 'fees_amount'=>true, 'fees_type'=>'nurse', 'fees' =>$fees_type])
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-flag form-lable-icon"></i>{{ trans('auth.state')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($stateName) ? $stateName : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-building form-lable-icon"></i>{{ trans('messages.city')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->city) ? $serviceInfo->city : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-envelope-open form-lable-icon"></i>{{ trans('auth.postal_code')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->postal_code) ? $serviceInfo->postal_code : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                @elseif ($form_set == App\Models\Service::FORM_SET_2)
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-server form-lable-padding"></i>{{ trans('auth.service_name') }}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                              {{ isset($serviceName->name) ? $serviceName->name : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-male form-lable-icon"></i>
                                                &nbsp;{{ trans('auth.name') }}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{  isset($serviceInfo->name) ? $serviceInfo->name : '-'  }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-id-badge form-lable-icon"></i>
                                                {{ trans('auth.contact_person')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                @include('partials.mask-popup', ['data'=>$serviceInfo->contact_person, 'contact_person'=>true])
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-phone form-lable-icon"></i>{{ trans('auth.contact_phone')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                @include('partials.mask-popup', ['data'=>$serviceInfo->contact_phone, 'mobile'=>true])
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-tty form-lable-icon"></i>{{ trans('messages.landline_number')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                @include('partials.mask-popup', ['data'=> $serviceInfo->landline_number, 'landline'=>true])
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="far fa-address-card form-lable-icon"></i>
                                                {{ trans('auth.address')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->address) ? $serviceInfo->address : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-flag form-lable-icon"></i>
                                                {{ trans('auth.state')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($stateName) ? $stateName : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-building form-lable-icon"></i>
                                                {{ trans('messages.city')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->city) ? $serviceInfo->city : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-envelope-open form-lable-icon"></i>
                                                {{ trans('auth.postal_code')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->postal_code) ? $serviceInfo->postal_code : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                @elseif ($form_set == App\Models\Service::FORM_SET_4)
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-server form-lable-padding"></i>{{ trans('auth.service_name') }}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                              {{ isset($serviceName->name) ? $serviceName->name : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-male form-lable-icon"></i>
                                                &nbsp;{{ trans('auth.name') }}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{  isset($serviceInfo->name) ? $serviceInfo->name : '-'  }}
                                            </h5>
                                        </div>
                                    </div>
                                    
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-id-badge form-lable-icon"></i>
                                                {{ trans('auth.contact_person')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                @include('partials.mask-popup', ['data'=>$serviceInfo->contact_person, 'contact_person'=>true])
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-phone form-lable-icon"></i>{{ trans('auth.contact_phone')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                @include('partials.mask-popup', ['data'=>$serviceInfo->contact_phone, 'mobile'=>true])
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-tty form-lable-icon"></i>{{ trans('messages.landline_number')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                @include('partials.mask-popup', ['data'=> $serviceInfo->landline_number, 'landline'=>true])
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="far fa-address-card form-lable-icon"></i>{{ trans('auth.address')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->address) ? $serviceInfo->address : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-flag form-lable-icon"></i>
                                                {{ trans('auth.state')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($stateName) ? $stateName : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-building form-lable-icon"></i>
                                                {{ trans('messages.city')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->city) ? $serviceInfo->city : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-envelope-open form-lable-icon"></i>
                                                {{ trans('auth.postal_code')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->postal_code) ? $serviceInfo->postal_code : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                @elseif ($form_set == App\Models\Service::FORM_SET_5)
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-server form-lable-padding"></i>{{ trans('auth.service_name') }}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                              {{ isset($serviceName->name) ? $serviceName->name : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-male form-lable-icon"></i>
                                                &nbsp;{{ trans('auth.name') }}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{  isset($serviceInfo->name) ? $serviceInfo->name : '-'  }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-id-badge form-lable-icon"></i>{{ trans('auth.contact_person')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                @include('partials.mask-popup', ['data'=>$serviceInfo->contact_person, 'contact_person'=>true])
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-phone form-lable-padding"></i>{{ trans('auth.contact_phone')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                @include('partials.mask-popup', ['data'=>$serviceInfo->contact_phone, 'mobile'=>true])
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="far fa-envelope-open form-lable-padding"></i>{{ trans('messages.contact_email')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                @include('partials.mask-popup', ['data'=>$serviceInfo->contact_email, 'email'=>true])
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-tty form-lable-icon"></i>{{ trans('messages.landline_number')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                @include('partials.mask-popup', ['data'=> $serviceInfo->landline_number, 'landline'=>true])
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="far fa-address-card form-lable-icon"></i>{{ trans('auth.address')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->address) ? $serviceInfo->address : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-flag form-lable-icon"></i>
                                                {{ trans('auth.state')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($stateName) ? $stateName : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-building form-lable-icon"></i>
                                                {{ trans('messages.city')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->city) ? $serviceInfo->city : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-envelope-open form-lable-icon"></i>
                                                {{ trans('auth.postal_code')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->postal_code) ? $serviceInfo->postal_code : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-server form-lable-icon"></i>
                                                {{ trans('messages.service_provider')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->services_provided) ? $serviceInfo->services_provided : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                @elseif ($form_set == App\Models\Service::FORM_SET_6)
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-server form-lable-padding"></i>{{ trans('auth.service_name') }}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                              {{ isset($serviceName->name) ? $serviceName->name : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-male form-lable-icon"></i>
                                                &nbsp;{{ trans('auth.name') }}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{  isset($serviceInfo->name) ? $serviceInfo->name : '-'  }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-tasks form-lable-icon"></i>{{ trans('messages.project_name')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->project_name) ? $serviceInfo->project_name : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-id-badge form-lable-icon"></i>
                                                {{ trans('auth.contact_person')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                @include('partials.mask-popup', ['data'=>$serviceInfo->contact_person, 'contact_person'=>true])
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-phone form-lable-icon"></i>{{ trans('auth.contact_phone')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                @include('partials.mask-popup', ['data'=>$serviceInfo->contact_phone, 'mobile'=>true])
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-tty form-lable-icon"></i>{{ trans('messages.landline_number')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                @include('partials.mask-popup', ['data'=> $serviceInfo->landline_number, 'landline'=>true])
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="far fa-envelope-open form-lable-icon"></i>{{ trans('messages.contact_email')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                @include('partials.mask-popup', ['data'=>$serviceInfo->contact_email, 'email'=>true])
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-flag form-lable-icon"></i>
                                                {{ trans('auth.state')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($stateName) ? $stateName : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-building form-lable-icon"></i>
                                                {{ trans('messages.city')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->city) ? $serviceInfo->city : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-envelope-open form-lable-icon"></i>
                                                {{ trans('auth.postal_code')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->postal_code) ? $serviceInfo->postal_code : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                @elseif ($form_set == App\Models\Service::FORM_SET_3)
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-server form-lable-padding"></i>{{ trans('auth.service_name') }}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                              {{ isset($serviceName->name) ? $serviceName->name : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-male form-lable-icon"></i>
                                                &nbsp;{{ trans('auth.name') }}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{  isset($serviceInfo->name) ? $serviceInfo->name : '-'  }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-shield-alt form-lable-icon"></i>{{ trans('messages.govt_approved') }}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{  $serviceInfo->govt_approved == true ? trans('common.verified') : trans('common.not_verified')  }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-id-badge form-lable-padding"></i>
                                                {{ trans('auth.contact_person')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                @include('partials.mask-popup', ['data'=>$serviceInfo->contact_person, 'contact_person'=>true])
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-phone form-lable-padding"></i>{{ trans('auth.contact_phone')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                @include('partials.mask-popup', ['data'=>$serviceInfo->contact_phone, 'mobile'=>true])
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-tty form-lable-icon"></i>{{ trans('messages.landline_number')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                @include('partials.mask-popup', ['data'=> $serviceInfo->landline_number, 'landline'=>true])
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-bed form-lable-padding"></i>{{ trans('auth.number_of_rooms')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->no_of_rooms) ? $serviceInfo->no_of_rooms : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-rupee-sign form-lable-icon"></i>
                                                {{ trans('messages.room_rent')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->room_rent) ? 'Rs. ' .currency($serviceInfo->room_rent).' '.App\Models\PartnerService::RENT_PER_MONTH : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-address-card form-lable-icon"></i>
                                                {{ trans('auth.address')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->address) ? $serviceInfo->address : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-flag form-lable-icon"></i>
                                                {{ trans('auth.state')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($stateName) ? $stateName : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-building form-lable-icon"></i>
                                                {{ trans('messages.city')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->city) ? $serviceInfo->city : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span>
                                                <i class="fas fa-envelope-open form-lable-icon"></i>
                                                {{ trans('auth.postal_code')}}
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <h5 class="semi-bold">
                                                {{ isset($serviceInfo->postal_code) ? $serviceInfo->postal_code : '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                @endif
                                 <!-- Website link -->
                    @if ($form_set == App\Models\Service::FORM_SET_2)
                        <div class="row form-group">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-datas">
                                <span>
                                    <i class="fas fa-link form-lable-icon"></i>{{ trans('messages.website_link')}}
                                </span>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <h5 class="semi-bold">
                                    @include('partials.mask-popup', ['data'=>$serviceInfo->website_link, 'web_link'=>true])
                                </h5>
                            </div>
                        </div>
                    @elseif ($form_set == App\Models\Service::FORM_SET_4)
                        <div class="row form-group">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-datas">
                                <span>
                                    <i class="fas fa-link form-lable-icon"></i>{{ trans('messages.website_link')}}
                                </span>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <h5 class="semi-bold">
                                   <a href="{{ isset($serviceInfo->website_link) ? $serviceInfo->website_link : '-' }}" target="_blank"> {{ isset($serviceInfo->website_link) ? $serviceInfo->website_link : '-' }}</a>
                                </h5>
                            </div>
                        </div>
                    @elseif ($form_set == App\Models\Service::FORM_SET_5)
                         <div class="row form-group">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-datas">
                                <span>
                                    <i class="fas fa-link form-lable-icon"></i>{{ trans('messages.website_link')}}
                                </span>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <h5 class="semi-bold">
                                    @include('partials.mask-popup', ['data'=>$serviceInfo->website_link, 'web_link'=>true])
                                </h5>
                            </div>
                        </div>
                    @elseif ($form_set == App\Models\Service::FORM_SET_6)
                        <div class="row form-group">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-datas">
                                <span>
                                    <i class="fas fa-link form-lable-icon"></i>{{ trans('messages.website_link')}}
                                </span>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <h5 class="semi-bold">
                                    @include('partials.mask-popup', ['data'=>$serviceInfo->website_link, 'web_link'=>true])
                                </h5>
                            </div>
                        </div>
                    @elseif ($form_set == App\Models\Service::FORM_SET_3)
                        <div class="row form-group">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-datas">
                                <span>
                                    <i class="fas fa-link form-lable-icon"></i>{{ trans('messages.website_link')}}
                                </span>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-9 col-xs-12">
                                <p class="semi-bold">
                                    @include('partials.mask-popup', ['data'=>$serviceInfo->website_link, 'web_link'=>true])
                                </p>
                            </div>
                        </div>
                    @endif
                    <!-- End Website link -->
                            </div>
                        </div>
                        <!-- End Home data Address Details -->
                    </div>
                   

                    <!-- Review section without image time -->
                    @if(count($bannerImage) <= 0)
                    <div class="row rating-starts">
                        <div class="col-lg-1 col-md-1 col-sm-2 col-xs-12">
                            <input type="hidden" name="rating" value="{{ isset($getAverage[0]['avarage']) ? $getAverage[0]['avarage'] : 0 }}" class="customer-rating">
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                            <span class="float-right rating-count">
                                <a href="{{ route('type.slug', ['type'=> $type, 'id'=>$slug]) }}#reviews" class="go-to-reviews-n">
                                    @if(count($getRatingDetail) > 1) 
                                        ({{ count($getRatingDetail) }} reviews) 
                                    @else 
                                        ({{ count($getRatingDetail) }} review) 
                                    @endif
                                </a>
                            </span>
                        </div>
                    </div>
                    @endif
                    
                    @if ($form_set == App\Models\Service::FORM_SET_4)
                    <!-- Machine equipment Detail -->
                    <div class="row form-group">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <span class="detail-title-border">{{ trans('messages.equipement_details') }}</span>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ trans('messages.equipment_name') }}</th>
                                <th>{{ trans('auth.description') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($equipmentsDetail) > 0)
                                @foreach($equipmentsDetail as $key => $value)
                                    <tr>
                                        <td>{{ isset($value['name']) ? $value['name'] : '-' }}</td>
                                        <td>{{ isset($value['description']) ? $value['description'] : '-' }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" style="text-align: center;">Record Not found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <!-- End Machine equipment Detail -->                                
                    @endif

                    @if ($form_set == App\Models\Service::FORM_SET_2)
                    <!-- Start List of provider -->
                    <div class="row form-group">
                        <div class="col-xs-12 col-lg-12 col-md-12">
                            <div class="row form-group">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-datas">
                                    <span>
                                        <i class="fa fa-server form-lable-icon" aria-hidden="true"></i>{{ trans('messages.list_of_tests_provided')}}
                                    </span>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 additional_info">
                                    <h5 class="semi-bold">
                                        {{ isset($serviceInfo->tests_provided) ? $serviceInfo->tests_provided : '-'}}
                                    </h5>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <!-- End Start List of provider -->
                    @endif 

                    @if ($form_set == App\Models\Service::FORM_SET_3)
                    <!-- Other Facilities -->
                    <div class="row form-group">
                        <div class="col-xs-12 col-lg-12 col-md-12">
                            <div class="row form-group">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-datas">
                                    <span>
                                        <i class="fa fa-building form-lable-icon" aria-hidden="true"></i>{{ trans('auth.other_facilities')}}
                                    </span>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 additional_info">
                                    <h5 class="semi-bold">
                                        {{ isset($serviceInfo->other_facilities) ? $serviceInfo->other_facilities : '-'}}
                                    </h5>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <!-- End Other Facilities -->
                     @endif   
            
                    <!-- Additional Information -->
                    @if(isset($serviceInfo->additional_info) && $serviceInfo->additional_info)
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                <span class="detail-title-border">{{ trans('auth.additional_info') }}</span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 additional_info form-group">
                                <h5 class="semi-bold">
                                    {{ isset($serviceInfo->additional_info) ? $serviceInfo->additional_info : '-' }}
                                </h5>
                            </div>
                        </div>
                    @endif
                    <!-- End Additional Information-->
                    
                    @if ($form_set == App\Models\Service::FORM_SET_3)
                    <!-- Available facility list -->
                    <div class="row ">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <span class="detail-title-border">{{ trans('auth.facilities') }}</span>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <span>
                                <i class="fa fa-building form-lable-icon" aria-hidden="true"></i>
                                {{ trans('auth.facilities_available') }}
                            </span>
                        </div>
                    </div>
                    <div class="row @if (count($facilityName) > 0) form-group @endif">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <div class="available-facility">
                                @if (count($facilityName) > 0)
                                <ul>
                                    @foreach ($facilityName as $value)
                                       <li class="semi-bold"><i class="fas fa-star"></i>
                                          {{ isset($value->name) ? $value->name : '-' }}
                                       </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- End Available facility list -->
                    @endif
                    <!-- Gallery and Review section -->
                    @include('partials.home-service-image-review')
                    <!-- End Gallery and Review section  -->
                </div>
            </div>
        </div>
  </div>
</div>