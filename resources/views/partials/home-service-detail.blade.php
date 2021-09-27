<div class="container">
    <div class="home-service-detail-parent">
        @if($type == App\Models\Partner::TYPE_SERVICE)
            @include('partials.service-detail')
        @else
            @include('partials.home-detail')
        @endif
    </div>
</div>