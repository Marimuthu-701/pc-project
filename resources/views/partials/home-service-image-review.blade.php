<!--Start Add bookmark and Share option -->
@php
    $shareUrl = urlencode(Request::url()); 
@endphp
@if(!$avatar_url)
<div class="col-md-4 col-md-offset-4 custom_success alert alert-success hide"></div>
<div class="col-md-4 col-md-offset-4 custom_error alert alert-danger hide"></div>
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
@endif
<!-- End  Add bookmark and Share option -->

<!-- Image Gallery and Review Detail  -->
<div class="row">
    <span class="anchor-url" id="reviews"></span>
    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
        <ul class="nav nav-tabs gallery-reviews-nav" id="gallery-reviews" role="tablist">
            <li class="nav-item active">
                <a class="nav-link" id="home-tab" data-toggle="tab" href="#images" role="tab" aria-controls="home" aria-selected="true">Images&nbsp;
                @if(isset($mediaInfo[0]['type']) && $mediaInfo[0]['type'] == App\Models\User::BANNER_TYPE)
                    {{ '(0)'}}
                @else
                    {{ '('.count($mediaInfo).')'}}
                @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#review" role="tab" aria-controls="profile" aria-selected="false">
                    @if(count($getRatingDetail) > 1) 
                        Reviews&nbsp;({{ count($getRatingDetail) }}) 
                    @else 
                        Review&nbsp; ({{ count($getRatingDetail) }}) 
                    @endif
                </a>
            </li>
            @if(count($equipmentsDetail) > 0)
                <li class="nav-item">
                    <a class="nav-link" id="medical-equipment" data-toggle="tab" href="#medicalEquipment" role="tab" aria-controls="profile" aria-selected="false">
                    @if($equiptmentImageCount > 1)
                        {{ __('Equipment Images').' ('.$equiptmentImageCount.')' }}
                    @else
                        {{ __('Equipment Images').' ('.$equiptmentImageCount.')' }}
                    @endif
                    </a>
                </li>
            @endif
        </ul>
        <!-- Tab panes -->
        <div class="tab-content gallery-review-tab">
            <div class="tab-pane active" id="images" role="tabpanel" aria-labelledby="home-tab">
                <div class="row">
                    @if(isset($mediaInfo[0]['type']) && $mediaInfo[0]['type'] == App\Models\User::BANNER_TYPE)
                        <div class="col-lg-12 col-md-12 col-xs-12 text-center">
                            <p class="not-found-avatar">{{ trans('messages.image_not_found') }}</p>
                        </div>
                    @elseif(count($mediaInfo) > 0)
                        @foreach($mediaInfo as $key=>$value)
                            <div class="col-lg-3 col-md-4 col-xs-12 col-sm-6">
                                <div class="imag-gallery-container">
                                    <a href="javascript:void(0);" data-url="{{ $value['img_url'] }}" class="image-preview">
                                        <img src="{{ $value['image_thump'] }}" alt="Another alt text"  class="detail-image-gallery">
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                    <div class="col-lg-12 col-md-12 col-xs-12 text-center">
                        <p class="not-found-avatar">{{ trans('messages.image_not_found') }}</p>
                    </div>
                    @endif
                </div>
            </div>
            <div class="tab-pane" id="review" role="tabpanel" aria-labelledby="profile-tab">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <div class="pull-right write_review">
                            @if (Auth::guest())
                            <a href="{{ route('login') }}" class="btn btn-primary guest-to-auth-rating">
                                <i class="fas fa-pencil-alt"></i> {{ trans('messages.write_review') }}
                            </a>
                            @else
                            <a href="{{ route('type.id.reviews.add', ['type'=>$type, 'id'=>$id]) }}" class="btn btn-primary">
                                <i class="fas fa-pencil-alt"></i> {{ trans('messages.write_review') }}
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if( count ($getRatingDetail) > 0)
                        <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
                            <div class="reviews-comments-container">
                                <ul>
                                    @foreach ($getRatingDetail as $key => $value)
                                        <li>
                                            <div class="reviews-comments">
                                                <p class="reviewed-user">
                                                    <i class="fas fa-user-circle"></i> {{ $value['user_name'] }} 
                                                    <span>{{ $value['created_at'] }}</span>
                                                </p>
                                                <div class="row">
                                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                                        <input type="hidden" name="rating" value="{{ $value['rating'] }}" class="customer-rating">
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12" style="display: none;">
                                                        <p class="rating-points">{{ number_format($value['rating'], 2) }}</p>
                                                    </div>
                                                </div>
                                                <p>{{ $value['comments'] ? $value['comments'] : '-' }}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @else
                        <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12 text-center">
                            <p class="not-found-review-image">{{ trans('messages.review_not_found') }}</p>
                        </div>
                    @endif
                </div>
            </div>            
            <div class="tab-pane" id="medicalEquipment" role="tabpanel" aria-labelledby="medical-equipment">
                <div class="row">
                    @if($equipmentsDetail > 0)
                        @foreach($equipmentsDetail as $key => $value)
                            @if(count($value['imagePath']) > 0)
                                @foreach($value['imagePath'] as $ikey => $ivalue)
                                    <div class="col-lg-3 col-md-4 col-xs-12 col-sm-6">
                                        <div class="imag-gallery-container">
                                            <a href="javascript:void(0);" data-url="{{ $ivalue }}" class="image-preview">
                                                <img src="{{ $value['imagePathThumb'][$ikey] }}" alt="Another alt text" class="detail-image-gallery" >
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    @else
                    <div class="col-lg-12 col-md-12 col-xs-12 text-center">
                        <p class="not-found-review-image">{{ trans('messages.image_not_found') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="service-mage-preview" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="serviceImagePreview" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close equipment-close-btn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 text-center">
                    <a href="#" target="_blank" id="image-preview-tab">
                        <img src="" id="image-preview-mode" style="width: 100%;">
                    </a>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<!-- End Image Gallery and Review Detail  -->
@push('script')
<script type="text/javascript">
    var loginUrl = "{{ route('login') }}";
    $('#gallery-reviews a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    });
    // Url Fragment
    var reviewFragment = window.location.hash.substr(1);
    if(reviewFragment) {
        $('a[href="#review"]').tab('show');
    }
    $('.go-to-reviews-n').on('click', function(e) {
        $('a[href="#review"]').tab('show');
         //$('html, body').animate({ scrollTop: 600 }, 1000);
    });

    var currentUrl = window.location.href;
    $('.guest-to-auth-rating').confirm({
        title: "{{ trans('messages.rating_confirm_title') }}",
        content:"{{ trans('messages.confirm_content_for_review') }}",
        buttons: {
            Cancel: function () { },
            somethingElse: {
                text: 'Sign in / Sign up',
                btnClass: 'btn-blue confirm-btn',
                keys: ['enter'],
                action: function(){
                    $('[name="previous_url"]').val(currentUrl);
                    $('.login-popup').modal('show');
                    //location.href = loginUrl+'?redirect_url='+currentUrl;
                }
            }
        }
    });
    $('.guest-to-auth-bookmark').confirm({
        title: "{{ trans('messages.bookmark_confirm_title') }}",
        content:"{{ trans('messages.confirm_content_for_bookmark') }}",
        buttons: {
            Cancel: function () { },
            somethingElse: {
                text: 'Sign in / Sign up',
                btnClass: 'btn-blue confirm-btn',
                keys: ['enter'],
                action: function(){
                    $('[name="previous_url"]').val(currentUrl);
                    $('.login-popup').modal('show');
                    //location.href = loginUrl+'?redirect_url='+currentUrl;
                }
            }
        }
    });
    $('body').on('click', '.image-preview', function() {
        var image_url = $(this).data('url');
        $('#image-preview-mode').attr('src', image_url);
        $('#image-preview-tab').attr('href', image_url);
        $('#service-mage-preview').modal('show');
    });
    $('body').on('click', '.mask-popvoer', function() {
        var redirectUrl = $(this).data('redirect-url');
        $('[name="previous_url"]').val(redirectUrl);
        $('.login-popup').modal('show');
    });

    $(document).ready(function() {
        $('body').on('click', '.add-to-bookmark, .bookmarked', function() {
            var contenType = $('#content_type').val();
            var contentId  = $('#content_id').val();
            var data = {"content_type":contenType,"content_id":contentId};
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: "POST",
                data  : data,
                url:"{{ route('wishlist.store') }}",
                beforeSend:function(){
                    $(".add-bookmark-icon").addClass('hide');
                    $(".process_icon").removeClass('hide');
                },
                success:function(data){
                    if (data.success) {
                        $('.process_icon').addClass('hide');
                        $('.add-to-bookmark').addClass('hide');
                        $('.home-service-detail-parent .custom_success').text("{{ trans('messages.added_bookmar') }}").removeClass('hide');
                        $('.dropdown-menu').after(`<button type="button" class="btn btn-secondary bookmarked" data-toggle="tooltip" data-placement="top" title="Already in Bookmark"><i class="fas fa-bookmark bookmark-icon"></i>
                            <span>Bookmark</span></button>`);
                        setTimeout(function(){ $('.custom_success').addClass('hide'); }, 2000);
                    } else if(data.data) {
                        $('.process_icon').addClass('hide');
                        $(".add-bookmark-icon").removeClass('hide');
                        $('.home-service-detail-parent .custom_error').text("{{ trans('messages.exist_bookmar') }}").removeClass('hide');
                        setTimeout(function(){ $('.custom_error').addClass('hide'); }, 2000);
                    } else if(data.errors) {
                        $('.process_icon').addClass('hide');
                        $(".add-bookmark-icon").removeClass('hide');
                        $('.home-service-detail-parent .custom_error').text(data.message).removeClass('hide');
                        setTimeout(function(){ $('.custom_error').addClass('hide'); }, 2000);
                    } else {
                        $('.process_icon').addClass('hide');
                        $(".add-bookmark-icon").removeClass('hide');
                        $('.home-service-detail-parent .custom_error').text("{{ trans('messages.login_failed') }}").removeClass('hide');
                        setTimeout(function(){ $('.custom_error').addClass('hide'); }, 2000);
                        window.location.href = base_url+'login';
                    }
                }
            });
        });
    });
</script>
@endpush