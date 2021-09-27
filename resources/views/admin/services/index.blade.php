@extends('admin.layouts.app')

@section('title', trans('common.services'))

@section('plugins.Datatables', true)

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1>{{ trans('common.services') }}</h1>

    @include('admin.partials.breadcrumbs', ['breadcrumbs' => [
    	trans('common.services')
    ]])
    
  </div>
  <div class="col-sm-6">
    <a href="{{ route('admin.services.create') }}" class="btn btn-success bg-gradient-success btn-lg float-sm-right">{{ trans('admin.create_service') }}</a>
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
            		<table class="table table-striped table-bordered" id="services-data-table"></table>
            	</div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script type="text/javascript">
	$(function() {
		var table = $('#services-data-table').DataTable({
			processing: true,
			serverSide: true,
			stateSave: true,
			searching: true,
			ajax: { 
	        url: "{!! route('admin.services.index') !!}",
	        type:'GET',
	        data: function (d) {}
	    },
	    columns: [
			/*{data: 'id', name: 'id', title: '{{ trans('auth.id') }}'},*/
			{data: 'name', name: 'name', title: '{{ trans('auth.name') }}'},
			/*{data: 'description', name: 'description', title: '{{ trans('auth.description') }}'},*/
			{data: 'status', name: 'status', title: '{{ trans('auth.status') }}'},
			{data: 'is_featured', name: 'is_featured', title: '{{ trans('auth.feature') }}'},
			{data: 'position', name: 'position', title: '{{ trans('auth.position') }}'},
			/*{data: 'icon', name: 'icon', title: '{{ trans('messages.icon_image') }}', searchable: false, sortable: false},
			{data: 'banner', name: 'banner', title: '{{ trans('messages.banner_image') }}', searchable: false, sortable: false},*/
			{data: 'form_set', name: 'form_set', title: '{{ trans('messages.form_set') }}'},
			{data: 'created_at', name: 'created_at', title: '{{ trans('auth.created_at') }}', render: function(data, type, row){
                if(type === "sort" || type === "type"){
                    return data;
                }
                return moment(data).format("{{ config('app.admin_date_format') }}");
            }},
			{data: 'action', name: 'action', title: '{{ trans('common.action') }}', searchable: false, sortable: false, className:"action-wrap"},
	    ],
		order: [[5, 'desc']],
		// language: {
		//   processing: '',
		// },
		drawCallback: function () {},
	  	});
	});
</script>
@stop