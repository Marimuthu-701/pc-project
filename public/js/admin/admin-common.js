$(document).ready(function() {
	$('#created_from_date').datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,        
        //startDate: '-d', 
        autoclose: true,
        onClose: function (selectedDate) {
            $("#created_to_date").datepicker("option", "minDate", selectedDate);
        }
    });

    $('#created_to_date').datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,        
        //startDate: '-d', 
        autoclose: true,
        onClose: function (selectedDate) {
            $("#created_from_date").datepicker("option", "maxDate", selectedDate);
        }
    });

    /*$('#updated_from_date').datepicker({
        format: 'dd-mm-yyyy',
        endDate: '+0d', 
        autoclose: true,
    }).on('changeDate', function (selected) {
        var startDate = new Date(selected.date.valueOf());
        $('#updated_to_date').datepicker('setStartDate', startDate);
    }).on('clearDate', function (selected) {
        $('#updated_to_date').datepicker('setStartDate', null);
    });

    $('#updated_to_date').datepicker({
        format: 'dd-mm-yyyy',
        endDate: '+0d', 
        autoclose: true,
    }).on('changeDate', function (selected) {
       var endDate = new Date(selected.date.valueOf());
       $('#updated_from_date').datepicker('setEndDate', endDate);
    }).on('clearDate', function (selected) {
       $('#updated_from_date').datepicker('setEndDate', null);
    }); */
    
    $('#featured_from_date').datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        //startDate: '-d', 
        autoclose: true,
        onClose: function (selectedDate) {
            $("#featured_to_date").datepicker("option", "minDate", selectedDate);
        }
    });

    $('#featured_to_date').datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,        
        //startDate: '-d', 
        autoclose: true,
        onClose: function (selectedDate) {
            $("#featured_from_date").datepicker("option", "maxDate", selectedDate);
        }
    });
    
});

$(document).on("focusin",".date-of-birth", function () {
    $(this).datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy', maxDate:  new Date(), 
        yearRange: "-100:+0",
        autoclose: true,
    });
});

$('body').on('click', '.admin-equipment-photo-delete', function() {
    var provider_id = $(this).data('id');
    var media_id = $(this).data('media-id');
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: "GET",
        data:{"id":provider_id, 'media_id':media_id },
        url:admin_base_url +'equipment-photo-delete',
        success:function(response) {
           if (response.success) {
                if(response.media_count == 0) {
                    $('#update-equipment-image').val('');
                }
                $('#eqp_photo_'+media_id).remove();
                $('#admin_equipment_update .custom_success').text(response.message).removeClass('hide');
                    setTimeout(function(){
                        $('.custom_success').addClass('hide');
                    },2000);
            } else {
                $('#admin_equipment_update .custom_error').text(response.message).removeClass('hide');
            }
        }
    });
});