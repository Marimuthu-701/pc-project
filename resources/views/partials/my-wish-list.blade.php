<div class="" id="search-section">
	<div class="custom_error alert alert-danger hide"></div>
	<div class="custom_success alert alert-success hide"></div>
	@if (count($wishListData) > 0)
	    @foreach ($wishListData as $key => $value)
	        <div class="right-search-result-panel wish_list remov_wish_list_div_{{$key}}" data-url="{{ route('type.slug', ['type'=>$value['content_type'], 'slug'=>$value['slug']]) }}">
	            <div class="media search-results">
	                <span class="wish-list-add wish-list-remove pull-right" data-content="{{$key}}">
	                    <input type="hidden" name="wish_list_id" id="wish_list_id_{{$key}}" value="{{ $value['wish_list_id']}}">
	                    <div class="wish_images" id="wish_list_image_{{$key}}"> 
	                        <img src="{{ asset('images/whish_list.png') }}" data-toggle="tooltip" title="Remove wish list" id="wish_list_{{$key}}">
	                    </div>
	                    <i class="fas fa-spinner fa-spin wish_list_process_{{$key}}" style="display: none;"></i>
	                </span> 
	                <div class="media-left media-middle"> 
	                    <a href="{{ route('type.slug', ['type'=>$value['content_type'], 'slug'=>$value['slug']]) }}">
	                        <img src="{{ $value['imagePath'] }}" class="media-object custom-media pull-left media-avator">
	                    </a>
	                    	<div class="feature-padge">
	                    		@if($value['feature_list'])
	                        		<span class="badge badge-pill badge-success">Featured</span>
	                    		@endif
	                    	</div>
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
			                    <div class="address-detail">
				                    <p>
		                                <i class="fas fa-map-marker-alt"></i>&nbsp;{{ $value['city'] }}, {{$value['state']}}
		                            </p>
		                            @if ($value['content_type'] == App\Models\Partner::TYPE_HOME)
		                                @if ($value['contact_no'])
		                                 <p><i class="fas fa-mobile-alt"></i>&nbsp; {{ $value['contact_no'] }}</p>
		                                @endif
		                            @endif
	                        	</div>
                        	</div>
		                    <!-- <h3 class="media-heading partner-sub-title"> {{ ucfirst($value['sub_title'])}}</h3> -->
		                    <p>{!! Str::limit($value['additional_info'], 250,' ...')  !!}</p>
		                </div> 
	                </a>
	            </div>
	        </div>
	    @endforeach
	@else
		<div class="right-search-result-panel wish_list_empty text-center">
	    	<label class="my-wish-list">Data Not Found</label>
	   </div>
	@endif
</div>
@push('script')
	<script>
		$('body').tooltip({selector: '[data-toggle="tooltip"]'});
		$('body').on('click', '.wish-list-remove', function() {
			var contenKey   = $(this).data('content');
			var id          = $('#wish_list_id_'+contenKey).val();
			$.ajax({
				headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
		        url: base_url+"wishlist/"+id,
		        type: 'DELETE',
		        data: {"id":id },
		        beforeSend:function(){
                    $(".wish_list_process_"+contenKey).show();
                },
		        success: function (data){
		        	$(".wish_list_process_"+contenKey).hide();
		        	if (data.success) {
		        		$('#search-section .custom_success').text(data.message).removeClass('hide');
		        		$('.remov_wish_list_div_'+contenKey).remove();
		        		setTimeout(function(){ $('.custom_success').addClass('hide'); },2000);
		        		if (data.dataCount == 0) {
		        			$('#search-section').html(`<div class="right-search-result-panel wish_list_empty text-center">
	    												<label class="my-wish-list">Data Not Found</label>
	   													</div>`);
		        		}
		        	} else {
		        		$('#search-section .custom_error').text(data.message).removeClass('hide');
		        		setTimeout(function(){ $('.custom_error').addClass('hide'); },2000);
		        	}
		        }
		    });
		});
		/*$('.wish_list').on('click', function() {
			var url = $(this).data('url');
			window.location.href = url;
		});*/
	</script>
@endpush