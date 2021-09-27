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
            		<table class="table table-striped table-bordered" id="incompleted-data-table"></table>
            	</div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script type="text/javascript">
	$(function() {
		var table = $('#incompleted-data-table').DataTable({
			processing: true,
			serverSide: true,
			stateSave: true,
			searching: true,
			ajax: { 
	        url: "{!! route('admin.partners.incomplete') !!}",
	        type:'GET',
	        data: function (d) {}
	    },
	    columns: [
			/*{data: 'id', name: 'id', title: '{{ trans('auth.id') }}'},*/
			{data: 'email', name: 'email', title: '{{ trans('auth.email') }}'},
			{data: 'mobile_number', name: 'mobile_number', title: '{{ trans('auth.mobile_number') }}'},
			//{data: 'status', name: 'status', title: '{{ trans('auth.status') }}'},
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
		order: [[2, 'desc']],
		// language: {
		//   processing: '',
		// },
		drawCallback: function () {},
	  	});
	});
</script>
@stop