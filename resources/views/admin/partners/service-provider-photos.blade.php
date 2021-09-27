 <div class="row">
    @foreach($serviceMedia as $key => $value)
        <div class="col-md-2">
            <div class="photo-container">
                <span class="admin-photo-delete" data-toggle="tooltip" data-placement="top" title="Delete">
                    <a href="{{ route('admin.provider.photo.delete', ['id'=>$value['id']]) }}"><i class="fas fa-times-circle"></i></a>
                </span>
                <a href="{{$value['url']}}" target="_blank"><img src="{{ $value['thumb_url'] }}" class="service-image"></a>
            </div>
        </div>
    @endforeach
</div>