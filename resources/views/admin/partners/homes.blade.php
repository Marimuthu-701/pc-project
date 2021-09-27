@extends('admin.layouts.app')

@section('title', trans('common.partner_homes'))

@section('plugins.Datatables', true)

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1>{{ trans('common.partner_homes') }}</h1>

    @include('admin.partials.breadcrumbs', ['breadcrumbs' => [
    	trans('common.partner_homes')
    ]])

  </div>
</div>
@stop

@section('content')
<div class="row">
	<div class="col-md-12">
        @include('flash::message')
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
	        url: "{!! route('admin.partners.homes') !!}",
	        type:'GET',
	        data: { id : '{{ Request::get('id') }}' }
	    },
	    columns: [
			{data: 'id', name: 'id', title: '{{ trans('auth.id') }}'},
			{data: 'name', name: 'name', title: '{{ trans('auth.business_name') }}'},
			{data: 'home_name', name: 'home_name', title: '{{ trans('auth.home_name') }}'},
			{data: 'address', name: 'address', title: '{{ trans('auth.address') }}'},
			{data: 'no_of_rooms', name: 'no_of_rooms', title: '{{ trans('auth.number_of_rooms') }}'},
			{data: 'facilities', name: 'facilities', title: '{{ trans('auth.facilities_available') }}', searchable: false, sortable: false},
			{data: 'other_facilities', name: 'other_facilities', title: '{{ trans('auth.other_facilities') }}'},
			{data: 'upload_image', name: 'upload_image', title: '{{ trans('auth.upload_image') }}'},
			{data: 'status', name: 'status', title: '{{ trans('auth.status') }}'},
			{data: 'featured_from', name: 'featured_from', title: '{{ trans('auth.featured_from_date') }}', searchable: false, sortable: false},
			{data: 'featured_to', name: 'featured_to', title: '{{ trans('auth.featured_to_date') }}', searchable: false, sortable: false},
			{data: 'verified', name: 'verified', title: '{{ trans('auth.verified') }}', searchable: false, sortable: false},
			{data: 'created_at', name: 'created_at', title: '{{ trans('auth.created_at') }}', searchable: false},
			{data: 'action', name: 'action', title: '{{ trans('common.action') }}', searchable: false, sortable: false},
	    ],
		order: [[7, 'desc']],
		// language: {
		//   processing: '',
		// },
		drawCallback: function () {},
	  	});
	});
</script>
@stop