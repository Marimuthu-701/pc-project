@extends('admin.layouts.app')

@section('title', trans('admin.users'))

@section('plugins.Datatables', true)

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1>{{ trans('admin.users') }}</h1>

    @include('admin.partials.breadcrumbs', ['breadcrumbs' => [
    	trans('admin.users')
    ]])
    
  </div>
  <div class="col-sm-6">
    <!-- <a href="{{ route('admin.users.create') }}" class="btn btn-success bg-gradient-success btn-lg float-sm-right">{{ trans('admin.create_user') }}</a> -->
    <div class="text-right advance-search">
    	<button type="button" class="btn export-btn">
    		<a href="{{ url('/admin/users-export') }}"><i class="fas fa-file-excel"></i> Export</a>
    	</button>
		<button type="submit" class="btn btn-primary advance_filter_btn">Advanced Filter</button>
	</div>
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
				<form name="advanced_filter" id="user_advance_search" method="POST" action="{{ route('admin.users.index') }}">
					@csrf
					<div id="advanced-filter" class="collapse advanced-search-container">
				    	<div class="row">
				    		
				    		<div class="col-md-3">
				    			<div class="form-group">
					    			<label for="name">{{ trans('auth.name') }}</label>
			                    	<input type="text" class="form-control" name="name" id="name">
			                	</div>
				    		</div>
				    		<div class="col-md-3">
				    			<div class="form-group">
									<label for="email">{{ trans('auth.email') }}</label>
			                    	<input type="email" class="form-control" name="email" id="email">
			                	</div>
				    		</div>
				    		<div class="col-md-3">
				    			<div class="form-group">
									<label for="mobile_number">{{ trans('auth.mobile_number') }}</label>
			                    	<input type="text" class="form-control" maxlength="10" name="mobile_number" id="mobile_number">
			                	</div>
				    		</div>
				    		<div class="col-md-3">
				    			<div class="form-group">
									<label for="state">{{ trans('auth.state') }}</label>
									<select class="form-control search-state" name="state" id="state">
										<option value="" ></option>
			                              @foreach($states as $key => $state)
			                                <option value="{{ $state->code }}" >{{ $state->name }}</option>
			                              @endforeach
			                        </select>
			                	</div>
				    		</div>
				    		
				    		<div class="col-md-3">
				    			<div class="form-group">
									<label for="city">{{ trans('auth.city') }}</label>
									<select class="form-control city-drop-list" name="city" id="city">
										<option value="" ></option>
			                              @foreach($cities as $key => $city)
			                                <option value="{{ $city->name }}" >{{ $city->name }}</option>
			                              @endforeach
			                        </select>
			                	</div>
				    		</div>
							<div class="col-md-3">
				    			<div class="form-group">
									<label for="postal_code">{{ trans('auth.postal_code') }}</label>
			                    	<input type="text" class="form-control"  maxlength="6" name="postal_code" id="postal_code">
			                	</div>
				    		</div>
				    		<div class="col-md-3">
				    			<div class="form-group">
									<label for="status">{{ trans('auth.status') }}</label>
			                    	<select class="form-control" name="status" id="status">
			                    		<option value=" "></option>
			                              @foreach($userStatus as $key => $value)
			                                <option value="{{ $key }}" >{{ $value }}</option>
			                              @endforeach
			                        </select>
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
			                    			<input type="text" class="form-control"  name="created_at_to" id="created_to_date">
			                    		</div>
			                    	</div>
			                	</div>
				    		</div>
				    	</div>
				    	<div class="row">
				    		<div class="col-md-12 text-right filter-btn-section">
				    			<button type="button" class="btn btn-primary user-search-btn">{{trans('common.search')}}</button>
				    			<button type="reset" class="btn btn-info user-reset-btn">Reset</button>
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
            		<table class="table table-striped table-bordered" id="users-data-table"></table>
            	</div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script type="text/javascript">
	$(function() {
		var table = $('#users-data-table').DataTable({
			processing: true,
			serverSide: true,
			stateSave: true,
			searching: true,
			ajax: { 
	        url: "{!! route('admin.users.index') !!}",
	        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       		},
	        type:'POST',
	        data: function (d) {
	        	d.name  = $('#name').val();
	        	d.email = $('#email').val();
	        	d.mobile_number = $('#mobile_number').val();
	        	d.state = $('#state').val();
	        	d.city = $('#city').val();
	        	d.postal_code = $('#postal_code').val();
	        	d.status = $('#status').val();
	        	d.created_from = $('#created_from_date').val();
	        	d.created_to  = $('#created_to_date').val();
	        	d.updated_from = $('#updated_from_date').val();
	        	d.updated_to = $('#updated_to_date').val();
	        }
	    },
	    columns: [
			/*{data: 'id', name: 'id', title: '{{ trans('auth.id') }}'},*/
			{data: 'first_name', name: 'first_name', title: '{{ trans('auth.name') }}'},
			{data: 'email', name: 'email', title: '{{ trans('auth.email') }}'},
			{data: 'mobile_number', name: 'mobile_number', title: '{{ trans('auth.mobile_number') }}'},
			{data: 'city', name: 'city', title: '{{ trans('auth.city') }}'},
			{data: 'state', name: 'state', title: '{{ trans('auth.state') }}'},
			{data: 'postal_code', name: 'postal_code', title: '{{ trans('auth.postal_code') }}'},
			{data: 'status', name: 'status', title: '{{ trans('auth.status') }}'},
			{data: 'created_at', name: 'created_at', title: '{{ trans('auth.created_at') }}', render: function(data, type, row){
                if(type === "sort" || type === "type"){
                    return data;
                }
                return moment(data).format("{{ config('app.admin_date_format') }}");
            }},
			{data: 'updated_at', name: 'updated_at', title: '{{ trans('auth.updated_at') }}', render: function(data, type, row){
                if(type === "sort" || type === "type"){
                    return data;
                }
                return moment(data).format("{{ config('app.admin_date_format') }}");
            }},
			{data: 'action', name: 'action', title: '{{ trans('common.action') }}', searchable: false, sortable: false, className:"action-wrap"},
	    ],
		order: [[7, 'desc']],
		// language: {
		//   processing: '',
		// },
		drawCallback: function () {},
	  	});

	  	$('body').on('click', '.user-search-btn', function() {
	  		table.draw();
	  	});

	  	$('body').on('click', '.user-reset-btn', function() {
	  		$('#user_advance_search').trigger('reset');
	  		table.draw();
	  	});

	  	$('body').on('click', '.advance_filter_btn', function(){
	        $('.collapse').slideToggle(200);
	        $('.advance-search').hide();
	    });

	    $(".collapse").on('show.bs.collapse', function(){
	        $('.advance-search').hide();
	    });

	    $('body').on('click', '.advance-search-closed', function() {
	        $('.collapse').slideToggle(200);
	        $('#user_advance_search').trigger('reset');
	        table.draw();
	        $('.advance-search').show();
	    });
	});
</script>
@stop