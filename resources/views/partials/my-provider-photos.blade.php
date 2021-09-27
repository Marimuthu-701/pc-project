<div class="row">
    <div class="col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3" id="photo-deleted-response">
        <div class="custom_error alert alert-danger hide"></div>
        <div class="custom_success alert alert-success hide"></div>
    </div>
</div>
<div class="form-group row">
    @if (count($medias) > 0)
        @foreach($medias as $key => $value)
            <div class="col-lg-2 col-xs-6 col-sm-3 register-form-input text-center" id="provider_photo_{{$value['id']}}">
                <div class="photo-container">
                    <span class="photo-delete-icon" data-toggle="tooltip" data-id="{{$value['id']}}" data-placement="top" title="Delete">
                        <i class="fas fa-times-circle"></i>
                    </span>
                    <a href="{{ $value['full_source'] }}" target="_blank" class="provider-photo">
                        <img src="{{ $value['thumb_source'] }}" class="service-image">
                    </a>
                </div>
            </div>
        @endforeach
    @endif
</div>