/* Custom scripts */
var slug_array  = ['login', 'register', 'password'];
var setPosition = 100;
/* Get mobile are web*/
if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
    isMobile = true;
    setPosition = 70;
}
$(window).scroll(function() {
    $('.sticky-wrapper').css('height', 0);
})

$(document).keydown(function(event) {
    if (event.keyCode == 27) {
        $('#approval-popup').modal('hide');
        $('#help-video-popup').modal('hide');
        $('.login-popup').modal('hide');
    }
});

/* Similarly for mobile number */
$.validator.addMethod("mobileValidation",
    function(value, element) { return !value.match(/^(\d)\1+$/g); },
"Mobile number is invalid");

$(document).ready(function() {
    $('.homes-list').show();
    $(document).on('click', '#my-button', function(e){
        e.preventDefault();
        $('.login-popup').modal('show');
        openLoginRegister('login', true);
        /*$('html, body').animate({ scrollTop: 0 }, 800);
        if (isMobile) {
            $('#bs-example-navbar-collapse-1').removeClass('show');
            $('.navbar-toggle').removeClass('uarr');
        }*/
    });

    $(document).on('click', '.register-popup, .login-popup-btn, .password-reset-btn', function(e){
        e.preventDefault();
        var type = '';
        if ($(this).hasClass('login-popup-btn')) {
            type = 'login';
        } else if($(this).hasClass('register-popup')) {
            type = 'register';
        } else if($(this).hasClass('password-reset-btn')){
            type = 'password';
        }
        openLoginRegister(type, true);            
    });
    $('body').on('click', '.signup-close-btn', function() {
        window.history.pushState(null, null, base_url);
    });
    $('#logout_box').bPopup({
        positionStyle: 'fixed',
        autoClose: 5000,
    });

    $('#approval-popup').modal('show');
    $('.homes-list').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1500,
        arrows: true,
        dots: false,
        pauseOnHover: false,
        prevArrow:'<span class="slick-slide-prev"><i class="fas fa-angle-left"></i></span>',
        nextArrow:'<span class="slick-slide-next"><i class="fas fa-angle-right"></i></span>',
        
        responsive: [{
            breakpoint: 980,
            settings: {
                slidesToShow: 2
            }
        }, {
            breakpoint: 580,
            settings: {
                slidesToShow: 1
            }
        },
        {
            breakpoint: 1200,
            settings: {
                slidesToShow: 3,
                width:275
            }
        }]
    });

    var help_video_url = $("#help-video-iframe").attr('src');
    $(document).on('click', '.help-video-popup', function(){
        $("#help-video-iframe").attr('src', help_video_url);
        $('#help-video-popup').modal('show');
    });
    
    $("#help-video-popup").on('hide.bs.modal', function(){
        $("#help-video-iframe").attr('src', '');
    });

    /* Contack form send email function */
    $("#contact-form").validate({
        errorElement: 'span',
        rules: {
            contact_name:{
                required: true,
            },
            contact_mobile:{
                required: true,
                minlength:10,
                maxlength:10,
                number: true,
                mobileValidation:true
            },
            contact_email:{
                /*required:true,*/
                email: true,
            },
            message:{
                required:true,
            }
        },
    });

    $('#contact-form').ajaxForm({
        url: base_url + 'contact-form-email',
        beforeSend: function() {
            $('.contact_btn i').removeClass('fa-long-arrow-alt-right');
            $('.contact_btn i').addClass('fa-spinner fa-spin');
            $('.contact_btn').prop('disabled', true);
            $('span.error').remove();
            $('#partner_home_form .error').removeClass('error');
        },
        success: function(response) {
            $('.contact_btn i').removeClass('fa-spinner fa-spin');
            $('.contact_btn i').addClass('fa-long-arrow-alt-right');
            $('.contact_btn').prop('disabled', false);
            $('.contact-form-title .custom_error').addClass('hide');
            if (response.success) {
                location.reload(true);
            }else if (response.errors) {
                $.each(response.errors, function(key, val) {
                    $("input[name="+key+"]").addClass('error');
                    $("input[name="+key+"]").after('<span for="'+key+'" generated="true" class="error">'+val[0]+'</span>');
                });
            }else {
                $('.contact-form-title .custom_error').text(response.message).removeClass('hide');
            }
        }
    });

    /*State By city*/
    $('body').on('change','.search-state',function(){
        var state_code = $(this).val();
        if (state_code) {
            $('.city-drop-list').prop('disabled',false); 
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: "POST",
                url: base_url + 'get-locations',
                data :{"state_code": state_code},
                success: function(response) {
                  $('.city-drop-list').html(response);
                }
            });
        } else {
            $('.city-drop-list').prop('disabled',true);
            $('.city-drop-list').html('<option value="">Select city</option>'); 
        }
    });

    /*Social login redirect url fragment remove*/
    $('body').tooltip({selector: '[data-toggle="tooltip"]'});
    /*using otp input filed pincodeinput*/
    $('.otp-input-box').pincodeInput({inputs:6, hidedigits:false,});
   
    /*Rating*/
    $('.customer-rating').rating({
        min: 0,
        max: 5,
        step: 1,
        size: 'xs',
        showClear: false,
        displayOnly:true,
        showCaption:false,
    });

    $('.carousel').carousel();

    if (window.location.href.indexOf('#_=_') > 0) {
        window.location = window.location.href.replace(/#.*/, '');
    }
    
    $('body').on('focus', '.date-of-birth', function() {
        $(this).datepicker({
            /*format: 'dd-mm-yyyy',
            endDate: '+0d',*/
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy', maxDate:  new Date(), 
            yearRange: "-100:+0",
            autoclose: true,
        });
    });

    $('body').on('click', '.mask-popvoer', function() {
        var redirectUrl = $(this).data('redirect-url');
        $('[name="previous_url"]').val(redirectUrl);
        $('.login-popup').modal('show');
    });

    // My account page photo Delete
    $(document).on('click', '.photo-delete-icon', function() {
        var media_id = $(this).data('id');
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            method: "POST",
            url: base_url + 'provider-photo-delete',
            data :{"media_id": media_id},
            success: function(response) {
                if (response.success) {
                    $('#photo-deleted-response').removeClass('hide');
                    $('#provider_photo_'+media_id).remove();
                    $('#photo-deleted-response .custom_success').text(response.message).removeClass('hide');
                    if(response.media_count == 1) {
                        $('label.my-accout-file').text('Photo');
                    }
                    setTimeout(function(){
                        $('#photo-deleted-response .custom_success').addClass('hide');
                    },2000);
                } else {
                    $('#photo-deleted-response .custom_error').text(response.message).removeClass('hide');
                    setTimeout(function(){
                        $('#photo-deleted-response .custom_error').addClass('hide');
                    },2000);
                }
            }
        });
    });

    // Account Delete otp verification And Delete Account script
    $("#delete-account-otp").validate({
        errorElement: 'span',
        ignore: [],
        rules: {
            otp_number:{
                required: true,
                minlength:6,
                maxlength:6,
                number: true,
            }
        },
    });

    $('#delete-account-otp').ajaxForm({
        beforeSend: function() {
            $('.verify-btn i').removeClass('fa-long-arrow-alt-right');
            $('.verify-btn i').addClass('fa-spinner fa-spin');
            $('.verify-btn').prop('disabled', true);
            $('span.error').remove();
            $('#delete-account-otp .error').removeClass('error');
        },
        success: function(response) {
            $('.verify-btn i').removeClass('fa-spinner fa-spin');
            $('.verify-btn i').addClass('fa-long-arrow-alt-right');
            $('.otp-verification-container .custom_error').addClass('hide');
            if (response.success) {
                $('.verify-btn').addClass('hide');
                $('.otp-verification-container .custom_success').text(response.message).removeClass('hide');
                setTimeout(function(){
                    $('.otp-verification-container').addClass('hide');
                    $('#account-delete').modal('show');
                }, 0);
            } else {
                $('.verify-btn').prop('disabled', false);
                $('.otp-verification-container .custom_error').text(response.message).removeClass('hide');
                setTimeout(function(){
                    $('.custom_error').addClass('hide');
                }, 2000);
            }
        }
    });

    $('#account_delete_form').ajaxForm({
        beforeSend: function() {
            $('.account-delete-btn i').removeClass('fa-long-arrow-alt-right');
            $('.account-delete-btn i').addClass('fa-spinner fa-spin');
            $('.account-delete-btn').prop('disabled', true);
            $('span.error').remove();
            $('#delete-account-otp .error').removeClass('error');
        },
        success: function(response) {
            $('.account-delete-btn i').removeClass('fa-spinner fa-spin');
            $('.account-delete-btn i').addClass('fa-long-arrow-alt-right');
            $('.otp-verification-container .custom_error').addClass('hide');
            if (response.success) {
                $('.account-delete-btn').addClass('hide');
                $('.delete-message').addClass('hide');
                $('#confirmation-header-popup').addClass('hide');
                $('#delete-model-footer').addClass('hide');
                $('#account_delete_form .custom_success').text(response.message).removeClass('hide');
                setTimeout(function(){
                    window.location.href = response.redirect_url;
                }, 3000);
            }else {
                $('.account-delete-btn').prop('disabled', false);
                $('#account_delete_form .custom_error').text(response.message).removeClass('hide');
                setTimeout(function(){
                    $('.custom_error').addClass('hide');
                }, 2000);
            }
        }
    });

    $(document).on('click', '.account-delete-close-btn', function() {
        window.location.href = base_url + 'profile/edit';
    });

});

function openLoginRegister(type, event_click) {
    $('.custom_error').addClass('hide');
    if (jQuery.inArray(type, slug_array) != '-1') {
        var append_url = '';
        switch(type) {
            case 'register':
                if(!$('#login-popup').is(':visible')) {
                    $('#login-form-container').addClass('hide');
                    $('#password-reset-container').addClass('hide');
                    $('#register_popup_form').trigger('reset');
                    $('#signup-form-container').removeClass('hide');
                    $('.login-popup').modal('show');
                }
                append_url = 'register';
            break;
            case 'login':
                if(!$('#login-popup').is(':visible')) {
                    $('#login_popup_form').trigger('reset');
                    $('#signup-form-container').addClass('hide');
                    $('#password-reset-container').addClass('hide');
                    $('#login-form-container').removeClass('hide');
                    $('.login-popup').modal('show');
                }
                append_url = 'login';
            break;
            case 'password':
                if(!$('#login-popup').is(':visible')) {
                    $('#password-reset-form').trigger('reset');
                    $('#login-form-container').addClass('hide');
                    $('#password-reset-container').removeClass('hide');
                    $('.login-popup').modal('show');
                }
                append_url = 'password/reset';
            break;
        }
         window.history.pushState(null, null, base_url + append_url);
    }
}

function getUrlParameter(sParam, url) {
    var sPageURL = url ? url : window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
}