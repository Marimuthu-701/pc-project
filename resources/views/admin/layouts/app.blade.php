@extends('adminlte::page')

@push('css')
<!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->
<link rel="stylesheet" href="{{ asset('css/admin/style.css?v=8') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/admin/dashboard.css?v=3') }}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datepicker.min.css') }}"> -->
<link rel="stylesheet" type="text/css" href="{{ asset('css/star-rating.css') }}">
@endpush
<script type="text/javascript">
	var admin_base_url = "{{ url('/admin/') }}/";
</script>

@section('footer')
<div id="delete-confirm-modal" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Are you sure?</h4>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<p>Do you really want to delete this record? This process cannot be undone.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-danger" id="delete-confirmed">Delete</button>
			</div>
		</div>
	</div>
</div> 
@stop

@push('js')

<!-- <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script> -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="{{ asset('js/star-rating.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/Jquery_validation/jquery.form.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/admin-common.js?v=2') }}"></script>
<!-- <script type="text/javascript" src="{{ asset('js/app.js') }}"></script> -->
<script type="text/javascript">
	$(document).ready(function() {
		$('body').on('click', '.item-delete-form button', function(e) {
		  var $form = $(this).closest('form');
		  e.preventDefault();
		  $('#delete-confirm-modal').modal({
		      backdrop: 'static',
		      keyboard: false
		  })
		  .on('click', '#delete-confirmed', function(e) {
		      $form.trigger('submit');
		   });
		});

		$('body').on('change', '.search-state', function(){
            var state_code = $(this).val();
            if (state_code) {
                $('.city-drop-list').prop('disabled',false); 
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    method: "POST",
                    url: "{{ url('/get-locations') }}",
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
        $('body').tooltip({selector: '[data-toggle="tooltip"]'});
        $('.customer-rating').rating({
	        min: 0,
	        max: 5,
	        step: 1,
	        size: 'xs',
	        showClear: false,
	        displayOnly:true,
	        showCaption:false,
	    });
	});
</script>
@endpush