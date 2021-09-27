<div class="container">
    <div class="row justify-content-center home-service-detail">
        <div class="col-lg-12">
            <span>
                <a href="{{ route('search', ['category'=>'home']) }}" class="go-to-search">
                    <i class="fas fa-home"></i>
                    {{ __('Home') }} / {{  isset($homeInfo->name) ? $homeInfo->name : '-'  }}
                </a>
            </span>
            <div class="card">
                <div class="card-body">
                    <input type="hidden" name="content_id" id="content_id" value="{{$homeInfo->id}}">
                    <input type="hidden" name="content_type" id="content_type" value="{{$type}}">
                    <div class="detail-title detail-title-rent text-center">
                      <h1 class="home-service-detail-title">{{  isset($homeInfo->name) ? $homeInfo->name : '-'  }}</h1>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <div class="verified-status-badge">
                                @if($homeInfo->verified)
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle"></i> {{ trans('messages.verified_badge') }}
                                </span>
                                @endif
                                <!-- <span class="badge badge-danger">
                                    <i class="fas fa-times-circle"></i> {{ trans('messages.not_verified_badge') }}
                                </span> -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div id="homeServiceCarousel" class="carousel slide" data-ride="carousel">
                                <!-- Indicators -->
                                @if(count($mediaInfo) > 1)
                                <ol class="carousel-indicators">
                                    <li data-target="#homeServiceCarousel" data-slide-to="0" class="active"></li>
                                    <li data-target="#homeServiceCarousel" data-slide-to="1"></li>
                                    <li data-target="#homeServiceCarousel" data-slide-to="2"></li>
                                </ol>
                                @endif
                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                @if(count($mediaInfo) > 0)
                                    @foreach ($mediaInfo as $key => $value)  
                                    <div class="item @if($key == 0) active @endif">
                                        <img src="{{ $value['img_url'] }}" alt="home-image" class="home-slide-image">
                                    </div>
                                    @endforeach
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row rating-starts">
                        <div class="col-lg-1 col-md-1 col-sm-2 col-xs-12">
                            <input type="text" name="rating" value="{{ isset($getAverage[0]['avarage']) ? $getAverage[0]['avarage'] : 0 }}" class="customer-rating">
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                            <span class="float-right rating-count"> {{ isset($getAverage[0]['avarage']) ? number_format($getAverage[0]['avarage'], 2) : 0 }} 
                                <a href="{{ route('type.slug', ['type'=> $type, 'slug'=>$slug]) }}" class="go-to-reviews-n">
                                    @if(count($getRatingDetail) > 1) 
                                        ({{ count($getRatingDetail) }} reviews) 
                                    @else 
                                        ({{ count($getRatingDetail) }} review) 
                                    @endif
                                </a>
                            </span>
                        </div>
                    </div>
                    <div class="row form-group">
                        <!-- Home And Service Address Details -->
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-datas">
                                <div class="row form-group">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <span>
                                            <i class="fas fa-home form-lable-icon"></i>{{ trans('auth.home_name')}}
                                        </span>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <h5 class="semi-bold">
                                          {{ isset($homeInfo->name) ? $homeInfo->name : old('home_name') }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <span>
                                            <i class="fas fa-bed form-lable-icon"></i>{{ trans('auth.number_of_rooms')}}
                                        </span>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <h5 class="semi-bold">
                                            {{ isset($homeInfo->no_of_rooms) ? $homeInfo->no_of_rooms : '-' }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <span>
                                            <i class="fas fa-id-badge form-lable-icon"></i>{{ trans('auth.contact_person') }}
                                        </span>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <h5 class="semi-bold">
                                            {{ isset($homeInfo->contact_person) ? $homeInfo->contact_person : '-' }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <span>
                                            <i class="fa fa-phone form-lable-icon" aria-hidden="true"></i>{{ trans('auth.contact_phone')}}
                                        </span>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <h5 class="semi-bold">
                                            {{ isset($homeInfo->contact_phone) ? $homeInfo->contact_phone : '-' }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <span>
                                            <i class="fas fa-address-card form-lable-icon"></i>{{ trans('auth.address')}}
                                        </span>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <h5 class="semi-bold">
                                            {{ isset($homeInfo->address) ? $homeInfo->address : '-' }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"></div>
                        <!-- End Home data Address Details -->
                    </div>
                    <!-- Other Facilities -->
                    <div class="row form-group">
                        <div class="col-xs-12 col-lg-12 col-md-12">
                            <div class="row form-group">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <span>
                                        <i class="fa fa-building form-lable-icon" aria-hidden="true"></i>
                                        {{ trans('auth.other_facilities')}}
                                    </span>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 additional_info">
                                    <h5 class="semi-bold">
                                        {{ isset($homeInfo->other_facilities) ? $homeInfo->other_facilities : '-'}}
                                    </h5>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <!-- End Other Facilities -->

                    <!-- Available facility list -->
                    <div class="row">
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
                    <div class="row">
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

                    <!-- Include Image Gallery and Share Bookmark option -->
                    @include('partials.home-service-image-review')
                    <!-- End Include Image Gallery and Share Bookmark option -->
                </div>
            </div>
        </div>
  </div>
</div>