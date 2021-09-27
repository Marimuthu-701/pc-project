<div class="container search-category-result-container">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
            <div class="left-search-category-panel">
                <div class="left-search-heading">
                    <span class="pull-right rest-filter">Reset Filters</span>
                </div>
                <div class="left-search-categories">
                    <form method="get" id="search-fileter-from">
                        <input type="hidden" name="type" value="{{Request::get('type')}}">
                        <input type="hidden" name="featured" value="{{Request::get('featured')}}">
                        <div class="left-location-search">
                            <div class="form-group">
                                <label for="location"> {{ trans('messages.provider_name') }}</label>
                                <input type="text" class="form-control" name="provider_name" id="provider_name" placeholder="{{ trans('messages.provider_name') }}" @if(Request::get('provider_name')) value="{{ Request::get('provider_name') }}" @endif>
                            </div>
                        </div>
                        <div class="left-location-search">
                            <div class="form-group">
                                <label for="state-serarch"> {{ trans('messages.state') }}</label>
                                <select class="form-control col-xs-12" name="state" id="state-serarch">
                                    <option value=""> {{ trans('messages.select_state') }}</option>
                                    @foreach ($states as $key => $value)
                                        <option value="{{ $value->code }}" @if( Request::get('state') == $value->code) selected="selected" @endif> {{ $value->name }}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                        </div>
                        <div class="left-location-search">
                            <div class="form-group">
                                <label for="location"> {{ trans('messages.city') }}</label>
                                <select class="form-control col-xs-12" name="location" id="location" data-name="location" @if( !Request::get('state')) disabled="disabled" @endif>
                                    <option value=""> {{ trans('messages.select_city') }}</option>
                                    @foreach ($cities as $key => $value)
                                        <option value="{{ $value->name }}" @if( Request::get('location') == $value->name) selected="selected" @endif> {{ $value->name }}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                        </div>
                        <div class="left-location-search">
                            <div class="form-group">
                                <label for="location"> {{ trans('auth.postal_code') }}</label>
                                <input type="text" class="form-control" name="postal_code" id="postal_code" maxlength="6" placeholder="{{ trans('auth.postal_code') }}" @if(Request::get('postal_code')) value="{{ Request::get('postal_code') }}" @endif>
                            </div>
                        </div>
                        <div class="lef-service-category">
                            @include('partials.search-left-service-category')
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12 search-result-right-panel">
            <img src="{{ asset('images/loader.gif') }}" class="search-loader text-center">
            <div class="search-result-body">
                @include('partials.search-right-panel')
            </div>
        </div>
    </div>
</div>
@push('script')
<script>
    var formData = '';
    var timeout;
    var magicalTimeout = 1000;
    var currentUrl = window.location.href;
    $(document).ready(function(){
        // Enter key disabled
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        
        // Get State Data
        $('#state-serarch').on('change',function(){
            $('#location').val('');
            $('[name="type"]').val('');
            formData = $("#search-fileter-from").serializeArray();
            getFilterDate(formData);
            servicesAndCount(formData);
        });

        // get city value
        $('#location').on('change',function(){
            $('[name="type"]').val('');
            formData = $("#search-fileter-from").serializeArray();
            getFilterDate(formData);
            servicesAndCount(formData);
        });

        // get postal code data
        $('#postal_code').on('keyup', function(e) {
            formData = $("#search-fileter-from").serializeArray();
            clearTimeout(timeout);
            timeout = setTimeout(function(){
                getFilterDate(formData);
                servicesAndCount(formData);
            },magicalTimeout);
        });
        

        // get Provider Name data
        $('#provider_name').on('keyup', function(e) {
            formData = $("#search-fileter-from").serializeArray();
            clearTimeout(timeout);
            timeout = setTimeout(function(){
                getFilterDate(formData);
                servicesAndCount(formData);
            },magicalTimeout);
        });

        //Service category
        $('body').on('change', 'input[name="service_id"]', function (e) {
            e.preventDefault();
            $('[name="type"]').val('');
            $('[name="featured"]').val('');
            var category = $(this).data('category');
            serviceCategory = [];
            $('input[name="service_id"]:checked').each(function() {
                serviceCategory.push($(this).val());
            });
            //$('#category').val(category);
            formData = $("#search-fileter-from").serializeArray();
            getFilterDate(formData);
            servicesAndCount(formData);
        });

        //Reset Filter all Filter
        $('.rest-filter').on('click', function() {
            $('#search-fileter-from').trigger("reset");
            $('#state-serarch').val('');
            $('[name="type"]').val('');
            $('[name="postal_code"]').val('');
            $('#provider_name').val('');
            $('[name="featured"]').val('');
            $('#location').prop('disabled', true).val('');
            //$('#category').val('service');
            $('.service-checkbox input[type="radio"]').prop('checked', false);
            formData = $("#search-fileter-from").serializeArray();
            getFilterDate(formData);
            servicesAndCount(formData);
        });

        // pagination 
        $(document).on('click', '.pagination a',function(event){
            event.preventDefault();
            $('li').removeClass('active');
            $(this).parent('li').addClass('active');
            var pageUrl = $(this).attr('href').replace(/&?_=[0-9]*/, '');
            var page = $(this).attr('href').split('page=')[1];
            window.history.pushState("", "", pageUrl);
            getData(page);
        });

    });
    
    //Pagenation Datas
    function getData(page){
        formData = $("#search-fileter-from :input[value!='']").filter(function(index, element) {
                    return $(element).val() != ''; }).serializeArray();
        $(".search-result-body").empty();
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data:formData,
            url: "{{ route('search') }}?page=" + page,
            type: "GET",
            cache: false,
        }).done(function(data){
            $(".search-result-body").html(data);
            popoverRatingTrigger();
        }).fail(function(jqXHR, ajaxOptions, thrownError){
            alert('No response from server');
        });
    }
    //Select Filete records
    function getFilterDate(formData){
        formData = $("#search-fileter-from :input[value!='']").filter(function(index, element) {
                    return $(element).val() != ''; }).serializeArray();
        $('.search-result-body').empty();
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: "GET",
            data  : formData,
            url:"{{ route('search') }}",
            cache: false,
            beforeSend:function(){
                $('.search-loader').show();
            },
            success:function(data){
                var qeuryString = $.param(formData);
                if(formData.length > 0) {
                    var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?'+qeuryString;
                } else {
                    var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                }
                window.history.replaceState(null, null, newurl);
                $('.search-loader').hide();
                $('.search-result-body').html(data);
                popoverRatingTrigger();
            }
        });
    }
    //popover and rating recall
    function popoverRatingTrigger(){
        $('.customer-rating').rating({
            min: 0,
            max: 5,
            step: 1,
            size: 'xs',
            showClear: false,
            displayOnly:true,
            showCaption:false
        });
    }

    //Get Service List Count
    function servicesAndCount(formData){
        formData = $("#search-fileter-from :input[value!='']").filter(function(index, element) {
                    return $(element).val() != ''; }).serializeArray();
        $('lef-service-category').empty();
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: "POST",
            data  : formData,
            url:"{{ url('/service-category') }}",
            success:function(data){
                $('.lef-service-category').html(data);
            }
        });
    }

    // State By city
    $('#state-serarch').on('change',function(){
        var state_code = $(this).val();
        $('#location').prop('disabled',false);
        if(state_code =='') {
            $('#location').val('');
            $('#location').prop('disabled',true);
        }
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: "POST",
            url: "{{ url('/get-locations') }}",
            data :{"state_code": state_code},
            success: function(response) {
              $('#location').html(response);
            }
        });
    });

    $('body').on('click', '.wish-list-add-guest', function() {
        var redirectUrl = $(this).data('redirect-url');
        $('[name="previous_url"]').val(redirectUrl);
        $('.login-popup').modal('show');
    });

    //Add to Wish List
    $(document).ready(function() {        
        $('body').on('click', '.wish-list-add', function() {
            var contenKey  = $(this).data('content');
            var contenType = $('#content_type_'+contenKey).val();
            var contentId  = $('#content_id_'+contenKey).val();
            var data = {"content_type":contenType,"content_id":contentId};
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: "POST",
                data  : data,
                url:"{{ route('wishlist.store') }}",
                beforeSend:function(){
                    $('#added_befor_'+contenKey).addClass('hide');
                    $(".wish_list_process_"+contenKey).show();
                },
                success:function(data){
                    if (data.success) {
                        $(".wish_list_process_"+contenKey).hide();
                        $('.search-result-body .custom_success').text(data.message).removeClass('hide');
                        $('#added_befor_'+contenKey).addClass('hide');
                        $('#added_after_'+contenKey).show();
                        $('#wish_list_image_'+contenKey).html('<img src="{{ asset('images/whish_list.png') }}" data-toggle="tooltip" title="Wish listed" id="added_after_'+contenKey+'">');
                        setTimeout(function(){ $('.custom_success').addClass('hide'); }, 2000);
                    } else if(data.data) {
                        $(".wish_list_process_"+contenKey).hide();
                        $('#added_after_'+contenKey).show();
                        $('.search-result-body .custom_error').text(data.message).removeClass('hide');
                        setTimeout(function(){ $('.custom_error').addClass('hide'); }, 2000);
                    } else if(data.errors) {
                        $(".wish_list_process_"+contenKey).hide();
                        $('#added_befor_'+contenKey).removeClass('hide')
                        $('.search-result-body .custom_error').text(data.message).removeClass('hide');
                        setTimeout(function(){ $('.custom_error').addClass('hide'); }, 2000);
                    } else {
                        $(".wish_list_process_"+contenKey).hide();
                        $('#added_befor_'+contenKey).removeClass('hide')
                        $('.search-result-body .custom_error').text("{{ trans('messages.login_failed') }}").removeClass('hide');
                        setTimeout(function(){ $('.custom_error').addClass('hide'); }, 2000);
                        window.location.href = base_url+'login?redirect_url='+currentUrl;
                    }
                }
            });
        });
    });
</script>
@endpush