@extends('layouts.app')

@section('meta_title')
{{ metaTitle('Testimonials') }}
@stop

@section('content')
<div class="main-container">
    <div class="container footer-page-container testmonial">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <span>
                    <a href="{{ route('home') }}" class="go-to-home">
                        <i class="fas fa-home"></i>
                        {{ __('Home') }} / {{ trans('messages.our_testimonials') }}
                    </a>
                </span>
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <h1 class="card-title page-title confidential">{{ trans('messages.our_testimonials') }}</h1>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                                <a href="{{route('testimonials.add')}}"  class="btn add-testimonial">{{ __('Add Testimonial') }}</a>
                            </div>
                        </div>
                        @if(Session::has('message'))
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2 custom_success alert alert-success">
                                    {{ Session::get('message') }}
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            @if(count($getTestimonials) > 0)
                                @foreach($getTestimonials as $key => $value)
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 testmonial-content">
                                    <div class="testimonial-feedback">
                                        <div class="rating-div">
                                            <input type="hidden" name="rating" value="5" class="customer-rating">
                                        </div>
                                        <p class="text-justify test-monial-p"> 
                                            <q>{{ $value->description }} </q>
                                        </p>
                                        <div class="pull-right created_by">
                                            <span class="testimonial-user-name">{{ ucfirst($value->name) }}</span> @if($value->address) / @endif 
                                            <span class="created_at_date"> {{ $value->address }}</span>
                                        </div> 
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        @if( $getTestimonials->count() > 0)
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right testmonial-pagenate"> 
                                {{ $getTestimonials->links() }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection