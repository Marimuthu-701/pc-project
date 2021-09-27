@extends('admin.layouts.app')

@section('title', trans('admin.partners'))

@section('plugins.Datatables', true)

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1>{{ trans('admin.partners') }}</h1>

    @include('admin.partials.breadcrumbs', ['breadcrumbs' => [
    	trans('admin.partners')
    ]])

  </div>
  <div class="col-sm-6">
    <a href="{{ route('admin.partners.create') }}" class="btn btn-success bg-gradient-success btn-lg float-sm-right">{{ trans('admin.create_partner') }}</a>
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
                <div class="table-overflow">
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
	        url: "{!! route('admin.partners.index') !!}",
	        type:'GET',
	        data: function (d) {}
	    },
	    columns: [
			/*{data: 'id', name: 'id', title: '{{ trans('auth.id') }}'},*/
			{data: 'email', name: 'email', title: '{{ trans('auth.email') }}'},
			{data: 'mobile', name: 'mobile', title: '{{ trans('auth.mobile') }}'},
			{data: 'company_name', name: 'company_name', title: '{{ trans('messages.company_name') }}'},
			{data: 'service_type', name: 'srvice_type', title: '{{ trans('messages.service') }}'},
			{data: 'created_at', name: 'created_at', title: '{{ trans('auth.created_at') }}', searchable: false},
			{data: 'action', name: 'action', title: '{{ trans('common.action') }}', searchable: false, sortable: false},
	    ],
		order: [[0, 'desc']],
		// language: {
		//   processing: '',
		// },
		drawCallback: function () {},
	  	});
	});
</script>
@stop