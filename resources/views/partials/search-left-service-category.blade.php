@php 
    $serviceCatory = '';
    if(!empty(Request::get('service_id'))){    
        $serviceCatory = Request::get('service_id');
    }
@endphp
<div class="left-service">
    <label for="left-service" class="category-title-label"> {{ trans('messages.services') }}</label>
    @foreach ($services as $key=> $value)
        <div class="radio service-checkbox">
            <label for="{{ $value['name'] }}">
                <input type="radio" value="{{ $value['id'] }}" id="{{ $value['name'] }}" name="service_id" @if($value['id'] == $serviceCatory) checked  @endif data-category="{{ $value['category'] }}">
                <span class="cr"><i class="cr-icon fa fa-circle"></i></span>{{ $value['name'] }}
            </label>
            
            @if(count($serviceCategoryCount) > 0)
                @foreach ($serviceCategoryCount as $service)
                    @if ( isset($service['service_id']) && ($service['service_id'] == $value['id']) )
                        <span class="badge badge-pill badge-success count-badge">{{ $service['service_count'] }}</span>
                    @endif
                @endforeach
            @endif
        </div>
    @endforeach
</div>