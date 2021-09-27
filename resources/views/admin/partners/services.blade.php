@extends('admin.layouts.app')

@section('title', trans('common.partner_services'))

@section('plugins.Datatables', true)

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1>{{ trans('common.partner_services') }}</h1>

    @include('admin.partials.breadcrumbs', ['breadcrumbs' => [
    	trans('common.partner_services')
    ]])
  </div>
  <div class="col-sm-6">
    <a href="{{ route('admin.partners.create') }}" class="btn btn-success bg-gradient-success btn-lg float-sm-right">{{ trans('admin.create_service') }}</a>
	<button type="submit" class="btn btn-primary advance_filter_btn service-ad-fbtn float-sm-right">Advanced Filter</button>
	<button type="button" class="btn export-btn float-sm-right service-export-btn">
    	<a href="{{ route('admin.partners.services.export') }}"><i class="fas fa-file-excel"></i> Export</a>
    </button>
  </div>
</div>
@stop

@section('content')
<div class="row">
	<div class="col-md-12">
        @include('flash::message')
    </div>
    <div class="col-md-12">
		<div class="row">
			<div class="col-md-12">
				<form name="advanced_filter" id="service_provider_advance_search" method="POST" action="{{ route('admin.partners.services') }}">
					@csrf
					<div id="advanced-filter" class="collapse advanced-search-container">
				    	<div class="row">
				    		<div class="col-md-3">
				    			<div class="form-group">
					    			<label for="name">{{ trans('auth.name') }}</label>
			                    	<input type="text" class="form-control"  name="name" id="name">
			                	</div>
				    		</div>
				    		<div class="col-md-3">
				    			<div class="form-group">
									<label for="email">{{ trans('auth.email') }}</label>
			                    	<input type="email" class="form-control"  name="email" id="email">
			                	</div>
				    		</div>
				    		<div class="col-md-3">
				    			<div class="form-group">
									<label for="mobile_number">{{ trans('auth.mobile_number') }}</label>
			                    	<input type="text" class="form-control"  maxlength="10" name="mobile_number" id="mobile_number">
			                	</div>
				    		</div>
				    		<div class="col-md-3">
				    			<div class="form-group">
									<label for="state">{{ trans('messages.service_type') }}</label>
									<select class="form-control" name="service_type" id="service_type">
										<option value="" ></option>
			                              @foreach($services as $key => $service)
			                                <option value="{{ $service->id }}" >{{ $service->name }}</option>
			                              @endforeach
			                        </select>
			                	</div>
				    		</div>
				    		<div class="col-md-3">
				    			<div class="form-group">
									<label for="status">{{ trans('auth.verified') }}</label>
			                    	<select class="form-control" name="verified" id="verified">
			                    		<option value=""></option>
			                              @foreach($getVerifiedStatus as $key => $value)
			                                <option value="{{ $key }}" >{{ $value }}</option>
			                              @endforeach
			                        </select>
			                	</div>
				    		</div>
				    		<div class="col-md-3">
				    			<div class="form-group">
									<label for="status">Approved Status</label>
			                    	<select class="form-control" name="approval" id="approval">
			                    		<option value=""></option>
			                            <option value="{{ App\Models\User::STATUS_ACTIVE }}" >Approved</option>
			                            <option value="{{ App\Models\User::STATUS_PENDING }}" >Not Approved</option>
			                        </select>
			                	</div>
				    		</div>
				    		<div class="col-md-3">
				    			<div class="form-group">
									<label>{{ trans('common.featured_on') }}</label>
									<div class="form-group row">
										<label for="featured_from_date" class="col-sm-3 col-form-label sub-label">{{ trans('common.from') }}</label>
										<div class="col-sm-9">
				                    		<input type="text" class="form-control" name="featured_from" style="margin-bottom: 10px;" id="featured_from_date">
				                    	</div>
				                    	<label for="featured_to_date" class="col-sm-3 col-form-label sub-label">{{ trans('common.to') }}</label>
				                    	<div class="col-sm-9">
				                    		<input type="text" class="form-control"  name="featured_to" id="featured_to_date">
				                    	</div>	
			                    	</div>
			                	</div>
				    		</div>
				    		<div class="col-md-3">
				    			<div class="form-group">
									<label>{{ trans('common.created_on') }}</label>
									<div class="form-group row">
										<label for="created_from_date" class="col-sm-3 col-form-label sub-label">{{ trans('common.from') }}</label>
										<div class="col-sm-9">
			                    			<input type="text" class="form-control" name="created_at_from" style="margin-bottom: 10px;" id="created_from_date">
			                    		</div>
			                    		<label for="created_to_date" class="col-sm-3 col-form-label sub-label">{{ trans('common.to') }}</label>
			                    		<div class="col-sm-9">
			                    			<input type="text" class="form-control" name="created_at_to" id="created_to_date">
			                    		</div>
			                    	</div>
			                	</div>
				    		</div>
				    	</div>
				    	<div class="row">
				    		<div class="col-md-12 text-right filter-btn-section">
				    			<button type="button" class="btn btn-primary service-search-btn advance-search-btn">{{trans('common.search')}}</button>
				    			<button type="reset" class="btn btn-info service-reset-btn advance-search-btn">Reset</button>
					    		<button type="button" class="btn btn-danger advance-search-closed">Cancel</button>
				    		</div>
				    	</div>
				  	</div>
			  	</form>
			</div>
		</div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-overflow table-responsive">
            		<table class="table table-striped table-bordered" id="partners-data-table"></table>
            	</div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script type="text/javascript">
	$(function() {
		var table = $('#partners-data-table').DataTable({
			processing: true,
			serverSide: true,
			stateSave: true,
			searching: true,
			ajax: { 
	        url: "{!! route('admin.partners.services') !!}",
	        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       		},
	        type:'POST',
	        data: function (d) {
	        	d.name  = $('#name').val();
	        	d.email = $('#email').val();
	        	d.mobile_number = $('#mobile_number').val();
	        	d.service_type = $('#service_type').val();
	        	d.verified = $('#verified').val();
	        	d.created_from = $('#created_from_date').val();
	        	d.created_to  = $('#created_to_date').val();
	        	d.featured_from = $('#featured_from_date').val();
	        	d.featured_to = $('#featured_to_date').val();
	        	d.approval = $('#approval').val();
	        }
	    },
	    columns: [
			/*{data: 'id', name: 'id', title: '{{ trans('auth.id') }}'},*/
			{data: 'name', name: 'name', title: '{{ trans('auth.name') }}'},
			{data: 'email', name: 'email', title: '{{ trans('auth.email') }}'},
			{data: 'mobile_number', name: 'mobile_number', title: '{{ trans('auth.mobile_number') }}'},
			{data: 'service_type', name: 'service_type', title: '{{ trans('messages.service_type') }}'},
			/*{data: 'registration_number', name: 'registration_number', title: '{{ trans('messages.registration_no') }}'},*/
			
			/*{data: 'city', name: 'city', title: '{{ trans('messages.city') }}'},
			{data: 'state', name: 'state', title: '{{ trans('auth.state') }}'},
			{data: 'postal_code', name: 'postal_code', title: '{{ trans('auth.postal_code') }}'},*/
			/*{data: 'featured_from', name: 'featured_from', title: '{{ trans('auth.featured_from_date') }}', searchable: false, sortable: false},
			{data: 'featured_to', name: 'featured_to', title: '{{ trans('auth.featured_to_date') }}', searchable: false, sortable: false},*/
			{data: 'featured', name: 'featured', title: '{{ trans('auth.featured') }}', searchable: false, sortable: false, className: 'featured-wrap'},
			{data: 'position', name: 'position', title: '{{ trans('auth.position') }}', searchable: false},
			{data: 'verified', name: 'verified', title: '{{ trans('auth.verified') }}', searchable: false},
			{data: 'created_at', name: 'created_at', title: '{{ trans('auth.created_at') }}', render: function(data, type, row){
                if(type === "sort" || type === "type"){
                    return data;
                }
                return moment(data).format("{{ config('app.admin_date_format') }}");
            }, searchable: false},
			{data: 'status', name: 'status', title: '{{ trans('messages.waiting_for_approval') }}'},
			{data: 'action', name: 'action', title: '{{ trans('common.action') }}', searchable: false, sortable: false, className:"action-wrap"},
	    ],
		order: [[7, 'desc']],
		// language: {
		//   processing: '',
		// },
		drawCallback: function () {},
	  	});

	  	$('body').on('click', '.service-search-btn', function() {
	  		table.draw();
	  	});

	  	$('body').on('click', '.service-reset-btn', function() {
	  		$('#service_provider_advance_search').trigger('reset');
	  		table.draw();
	  	});

	  	$('body').on('click', '.advance_filter_btn', function(){
	        $('.collapse').slideToggle(200);
	        $('.service-ad-fbtn').hide();
	    });

	    $(".collapse").on('show.bs.collapse', function(){
	        $('.service-ad-fbtn').hide();
	    });

	    $('body').on('click', '.advance-search-closed', function() {
	        $('.collapse').slideToggle(200);
	        $('#service_provider_advance_search').trigger('reset');
	        table.draw();
	        $('.service-ad-fbtn').show();
	    });
	});
</script>
@stop