@extends('layouts.app')

@section('meta_description')
Contact the best home healthcare providers near you. We provide details of Paid Old Age Homes, Caregivers, Home Nurses, Physiotherapist, Home Health Care Agency, Retirement Homes, Ambulance, Occupational Therapist, Medical Equipment Rental, Homeopathy, Ayurveda, Siddha, Naturopathy, Touch Theraphy, Acupuncture, Acupressure, Reflexology Doctors, Pharmacy, Labs near you. Available in Chennai, Coimbatore, Delhi, Bangalore, Mysore, Hyderabad, Mumbai, Pune, Kochi, Trivandrum, Kolkota, Ludhiana, Ahmedabad, Vadodara..all over India
@stop

@section('content')
<div class="main-container">
   <section id="banner" class="page-section">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="7000">
            <div class="carousel-inner  animatedParent" role="listbox">
                <div class="carousel-item item active" style="background-image: url('{{ asset("images/home-banner/banner-one.jpg") }}?v=1')">
                    <div class="carousel-caption d-none d-md-block zoomInDown go">
                        <h1>{{ trans('messages.home_banner_heading') }}</h1>
                      </div>
                </div>
                <div class="carousel-item item " style="background-image: url('{{ asset("images/home-banner/banner-two.jpg") }}?v=1')">
                    <div class="carousel-caption d-none d-md-block zoomInDown go">
                        <h1>{{ trans('messages.home_banner_heading') }}</h1>
                      </div>
                </div>
            </div>
             <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
        </div>
    </section>
    <!-- START SEARCH FOR SECTION -->
    <section id="search_for">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="page-title">
                        <h3>Search for</h3>
                        <p>{!! Str::limit($featureServicesList, 110, ' and more...') !!}</p>
                    </div>
                    <div class="search_section_inner">
                      <form method="get" action="{{ route('search') }}" id="serach-form">
                        <div class="row">
                            <div class="col-lg-1 col-md-1 col-sm-6 col-xs-12"></div>
                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                              <span class="home-category-asterisk">*</span>
                                <div class="form-group">
                                  <select class="form-control" id="search-category" required="required" name="service_id">
                                    <option value="">Search by Category</option>
                                    @if(count($category) > 0)
                                        @foreach ($category as $key=>$value)
                                            <option value="{{$value['id'] }}"> {{ $value['name'] }}</option>
                                        @endforeach
                                    @endif
                                  </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <select class="form-control search-state" id="search-state" name="state">
                                    <option value="">Search by State</option>
                                    @foreach ($states as $state)
                                      <option value="{{ $state->code }}">{{ $state->name }}</option>
                                    @endforeach
                                  </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <select class="form-control city-drop-list" id="search-location" name="location" disabled="disabled">
                                    <option value="">Search by City</option>
                                      @if (count($cities) > 0)
                                          @foreach ($cities as $city)
                                              <option value="{{$city->name }}"> {{ $city->name }} </option>      
                                          @endforeach
                                      @endif
                                  </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <input type="text" class="form-control"  name="postal_code" placeholder="{{ trans('auth.postal_code') }}" maxlength="6">
                                </div>
                            </div>
                            <!-- <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 search-more hide">
                                <a href="#">more search options <i class="fas fa-plus"></i></a>
                            </div> -->
                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 ">
                                <div class="main_button search-button">
                                  <button type="submit" class="btn btn-primary">{{ trans('messages.search') }}&nbsp;&nbsp;
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                  </button>
                                    <!-- <a href="{{ route('search') }}">Search<i class="fas fa-long-arrow-alt-right"></i></a> -->
                                </div>
                            </div>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END SEARCH FOR SECTION -->

    <!-- START FEATURED HOME GROUP -->
    @if (count($featureHomes) > 0)
    <section id="home-groups">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="page-title">
                        <h3>Featured Care Home Groups</h3>
                        <p><img src="{{ asset('images/title_icon.png') }}" alt="#"></p>
                    </div>
                    <div class="home-group-list">
                        <div class="homes-list slider">
                                @foreach ($featureHomes as $key => $value)
                                    <div class="slide">
                                      <a href="{{ route('type.slug', ['type'=> $value['type'], 'slug'=> $value['slug']]) }}" style="color: unset;">
                                        <div class="card">
                                            <div class="home-image">
                                                <div class="home-name">
                                                    <h4>{{isset($value['homeName']) ? ucfirst($value['homeName']) : ''}}</h4>
                                                </div>
                                                <img src="{{ isset($value['imagePath']) ? $value['imagePath'] : asset('images/home1.jpg') }}" class="card-img-top feature-homes" alt="Home Image">
                                            </div>
                                            
                                            <div class="card-body">
                                                @if(isset($value['room_rent']) && $value['room_rent'])
                                                  <h5 class="card-title"><i><img src="{{ asset('images/rupee-icon-.png') }}" alt="#"> </i> <span class="feature-home-rent">{{ isset($value['room_rent']) ? '₹'.currency($value['room_rent']) : '-'}}</span></h5>
                                                @endif
                                                <p class="card-text"><i><img src="{{ asset('images/location-marker.png') }}" alt="#"> </i> 
                                                <span class="feature-home-address">{!! Str::limit($value['homeAddress'], 50,' ...')  !!}</span></p>
                                                <div class="review">
                                                    <i><img src="{{ asset('images/rating-hand.png') }}" alt="#"> </i>
                                                    <ul class="feature-homes-rating">
                                                        <li> <input type="hidden" name="rating" value="{{ isset($value['averageRating']) ? $value['averageRating'] : 0 }}" class="customer-rating"></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                            </a>
                                    </div>
                                @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- END FEATURED HOME GROUP -->

    <!-- START HOME REVIEW SECTION -->
    @if (count($recentReviewArray) > 0)
    <section id="home-review">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="page-title">
                        <h3>Latest Care Home Reviews</h3>
                        <p>{{ trans('messages.customer_reviews') }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="carousel slide" data-ride="carousel" id="home-review-inner">
              <!-- Bottom Carousel Indicators -->
              @if(count($recentReviewArray) > 1)
                <ol class="carousel-indicators">
                  @foreach ($recentReviewArray as $key => $value)
                    <li data-target="#home-review-inner" data-slide-to="{{$key}}" @if($key == 0) class="active" @endif></li>
                    <!-- <li data-target="#home-review-inner" data-slide-to="1"></li>
                    <li data-target="#home-review-inner" data-slide-to="2"></li> -->
                  @endforeach
                </ol>
              @endif
              <div class="carousel-inner">
                @foreach ($recentReviewArray as $key => $value)
                <div class="item @if($key == 0) active @endif">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-offset-3 col-sm-offset-3">
                    <div class="review-inner">
                        <h4>{{ trans('messages.review_for').' '.$value['home_name_city_state'] }}</h4>
                          <ul>
                              <li>
                                <input type="hidden" name="rating" value="{{ isset($value['rating']) ? $value['rating'] : 0 }}" class="customer-rating">
                              </li>
                          </ul>
                        <span>{{ $value['post_date'] }}</span>
                        <p>{!! Str::limit($value['review_content'], 200, '...') !!}</p>
                        <div class="main_button">
                            <a href="{{ route('type.slug', ['type'=> $value['type'], 'slug'=>$value['slug'] ]) }}">Read Full Review &nbsp;<i class="fas fa-long-arrow-alt-right"></i></a>
                        </div>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
    </section>
    @endif
    <!-- END HOME REVIEW SECTION -->

    <!-- START SERVICE PROVIDER SECTION -->
    @if (count($featureServiceList) > 0)
    <section id="service-providers">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="page-title">
                        <h3>Featured Service Providers</h3>
                        <p><img src="{{ asset('images/title_icon.png') }}" alt="#"></p>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <ul class="featured-services">
                  @foreach($featureServiceList as $key => $value)
                      <li>
                          <a href="{{ route('search', ['service_id'=>$value['service_id'], 'featured'=>true]) }}">
                              <div class="services-list">
                                  <i><img src="{{ $value['service_icon'] }}" alt="icon" class="service-providers_icon"></i>
                                  <p>{{ $value['service_name'] }}</p>
                              </div>
                          </a>
                      </li>
                  @endforeach
                  </ul>
                </div>
                <!--  <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                   <a href="{{ route('services.nurse') }}" target="_blank">
                       <div class="services-list">
                           <i><img src="{{ asset('images/service2.png') }}" alt="icon" class="service-providers_icon"></i>
                           <p>Nursing</p>
                       </div>
                   </a>
               </div>
               <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                   <a href="{{ route('services.physiotherapy') }}" target="_blank">
                       <div class="services-list">
                           <i><img src="{{ asset('images/service3.png') }}" alt="icon" class="service-providers_icon"></i>
                           <p>Physiotherapy</p>
                       </div>
                   </a>
               </div>
               <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                   <a href="{{ route('services.attendant') }}" target="_blank">
                       <div class="services-list">
                           <i><img src="{{ asset('images/service4.png') }}" alt="icon" class="service-providers_icon"></i>
                           <p>Trained Attendant</p>
                       </div>
                   </a>
               </div>
               <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                   <a href="{{ route('services.lab') }}" target="_blank">
                       <div class="services-list">
                           <i><img src="{{ asset('images/service5.png') }}" alt="icon" class="service-providers_icon"></i>
                           <p>Lab Tests</p>
                       </div>
                   </a>
               </div>
               <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                   <a href="{{ route('services.medical') }}" target="_blank">
                       <div class="services-list">
                           <i><img src="{{ asset('images/service6.png') }}" alt="icon" class="service-providers_icon"></i>
                           <p>Medical Equipment</p>
                       </div>
                   </a>
               </div>
               <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                   <a href="{{ route('services.pharmacy') }}" target="_blank">
                       <div class="services-list">
                           <i><img src="{{ asset('images/service7.png') }}" alt="icon" class="service-providers_icon"></i>
                           <p>Speciality Pharmacy</p>
                       </div>
                   </a>
               </div>
               <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                   <a href="{{ route('services.critical-care') }}" target="_blank">
                       <div class="services-list">
                           <i><img src="{{ asset('images/service8.png') }}" alt="icon" class="service-providers_icon"></i>
                           <p>Critical Care</p>
                       </div>
                   </a>
               </div> -->
            </div>
        </div>
    </section>
    @endif
    <!-- END SERVICE PROVIDER SECTION -->

    <!-- START HOW IT WORK SECTION -->
    <section id="how-it-works">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="page-title">
                        <h3>{{ trans('messages.how_it_work_title') }}</h3>
                        <p>{{ trans('messages.how_it_work_answer') }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="steps-arrow"></div>
                    <div class="card">
                        <div class="card-img">
                            <span><img src="{{ asset('images/step1.png') }}" alt="icon"></span>
                        </div>
                        <div class="card-body">
                            <h4 class="how-to-work-title">{{ trans('messages.step_one_title')}}</h4>
                            <p class="card-text text-justify how-to-work-text">{{ trans('messages.step_one_discription') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="steps-arrow"></div>
                    <div class="card">
                        <div class="card-img">
                            <span><img src="{{ asset('images/step2.png') }}" alt="icon"></span>
                        </div>
                        <div class="card-body">
                            <h4 class="how-to-work-title">{{ trans('messages.step_two_title')}}</h4>
                            <p class="card-text text-justify how-to-work-text">{{ trans('messages.step_two_discription') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-img">
                            <span><img src="{{ asset('images/step3.png') }}" alt="icon"></span>
                        </div>
                        <div class="card-body">
                            <h4 class="how-to-work-title">{{ trans ('messages.step_three_title')}}</h4>
                            <p class="card-text text-justify how-to-work-text">{{ trans ('messages.step_three_discription') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="main_button">
                        <a href="{{ route('search') }}">Begin Your Search <i class="fas fa-search begin-search-icon"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END HOW IT WORK SECTION -->
     
    <section id="help">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="partner-register">
                        <div class="help-register-content">
                            <div class="page-title contact-left-panel">
                                <h3>{{ trans('messages.contact_left_panel_title') }}</h3>
                                <p>{!! Str::limit($featureServicesList, 110, ' and more...') !!}</p>
                                <div class="main_button">
                                    <a href="{{ route('provider.register') }}">Register&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <div class="need-help">
                        <div class="page-title contact-form-title">
                            @if(Session::has('message'))
                                <div class="custom_success alert alert-success">
                                    {{ Session::get('message') }}
                                </div>
                            @endif
                            <div class="custom_error alert alert-danger hide"></div>
                            <div class="custom_success alert alert-success hide"></div>
                            <h3>{{ trans('messages.customer_need_help') }}</h3>
                            <p>{{ trans('messages.customer_need_help_description') }}</p>
                            <div class="text-center contact-call-us">
                                <p>{{ trans('messages.or') }}</p>
                                <span>{{ trans('messages.contact_call_us', ['contact_no'=> config('app.contact_number')]) }}</span>
                            </div>
                        </div>
                        <form method="post" action="{{ route('contact.email') }}" id="contact-form">
                            @csrf
                          <div class="form-group">
                            <input type="text" class="form-control" id="name" name="contact_name" placeholder="{{ trans('auth.name') }} *">
                            <input type="email" class="form-control" id="email_address" name="contact_email" placeholder="{{ trans('auth.email_address') }}">
                            <input type="text" class="form-control" id="mobile_number" name="contact_mobile" maxlength="10" placeholder="{{ trans('auth.mobile_number') }} *">
                            <textarea id="message" row="5" class="form-control @error('message') is-invalid @enderror" name="message" value="{{ old('message') }}" placeholder="{{ trans('messages.message') }} *"></textarea>
                          </div>
                          <div class="contact_button">
                              <button type="submit" class="btn btn-primary contact_btn">{{ trans('auth.submit') }}&nbsp;&nbsp;
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                </button>
                          </div> 
                            <!-- <div class="main_button">
                                <a href="">Submit<i class="fas fa-long-arrow-alt-right"></i></a>
                            </div> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if(count($getTestimonials) > 0)
      <section id="testimonials">
          <div class="container">
              <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <div class="page-title">
                          <h3>Our Testimonials</h3>
                      </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <div class="carousel slide" data-ride="carousel" id="home-testi-inner">
                          <!-- Bottom Carousel Indicators -->
                          @if(count($getTestimonials) > 1)
                          <ol class="carousel-indicators">
                            @foreach($getTestimonials as $key => $value)
                              <li data-target="#home-testi-inner" data-slide-to="{{$key}}" @if($key == 0) class="active" @endif></li>
                              <!-- <li data-target="#home-testi-inner" data-slide-to="1"></li>
                              <li data-target="#home-testi-inner" data-slide-to="2"></li> -->
                            @endforeach
                          </ol>
                          @endif
                          <!-- Carousel Slides / Quotes -->
                          <div class="carousel-inner">
                            <!-- Quote 1 -->
                            @foreach($getTestimonials as $key => $value)
                              <div class="item @if($key ==0) active @endif">
                                <div class="row">
                                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="testi-inner">
                                        <div class="testi-profile hide">
                                            <i><img src="{{ asset('images/testi_1.jpg') }}" alt="#"></i>
                                        </div>
                                        <p class="testimonials-content">{{ $value->description }}</p>
                                        <p><input type="hidden" name="rating" value="{{ $value->rating }}" class="customer-rating"></p>
                                        <h4>{{ $value->name }} <span> {{$value->address}}</span> </h4>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            @endforeach

                            <!-- <div class="item">
                              <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                  <div class="testi-inner">
                                      <div class="testi-profile">
                                          <i><img src="{{ asset('images/testi_1.jpg') }}" alt="#"></i>
                                      </div>
                                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                      <h4>Garreth Smitah<span>Marketing Manager</span> </h4>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="item">
                              <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                  <div class="testi-inner">
                                      <div class="testi-profile">
                                          <i><img src="{{ asset('images/testi_1.jpg') }}" alt="#"></i>
                                      </div>
                                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                      <h4>Garreth Smitah<span>Marketing Manager</span> </h4>
                                  </div>
                                </div>
                              </div>
                            </div> -->
                          </div>
                        </div>
                  </div>
              </div>
          </div>
      </section>
    @endif
    @include('partials.near-me-home-service')
</div>
    <!-- This popup for approval message -->
    @if($approvalStatus == App\Models\User::STATUS_PENDING)
        <div class="modal fade" id="approval-popup" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="approval-message" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered" role="document">
              <div class="modal-content">
                  <div class="modal-header hide">
                      <h5 class="modal-title" id="approval-title">Are you sure?</h5>
                  </div>
                  <div class="modal-body">
                      <button type="button" class="close equipment-close-btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      {{trans('messages.approval_message') }}
                  </div>
              </div>
            </div>
        </div>
    @endif
@endsection