@extends('admin.layouts.app')

@section('title', trans('common.reviews'))

@section('plugins.Datatables', true)

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1>{{ trans('common.reviews') }}</h1>

    @include('admin.partials.breadcrumbs', ['breadcrumbs' => [
    	trans('common.reviews')
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
                <div class="table-overflow">
            		<table class="table table-striped table-bordered" id="reviews-data-table"></table>
            	</div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script type="text/javascript">
	$(function() {
		var table = $('#reviews-data-table').DataTable({
			processing: true,
			serverSide: true,
			stateSave: true,
			searching: true,
			ajax: { 
	        url: "{!! route('admin.reviews.index') !!}",
	        type:'GET',
	        data: function (d) {}
	    },
	    columns: [
			/*{data: 'id', name: 'id', title: '{{ trans('auth.id') }}'},*/
			/*{data: 'body', name: 'body', title: '{{ trans('auth.description') }}', searchable: false, sortable: false},*/
			{data: 'rating', name: 'rating', title: '{{ trans('messages.rating') }}'},
			{data: 'reviewrateable_id', name: 'reviewrateable_id', title: '{{ trans('messages.provider_name') }}'},
			{data: 'average_rating', name: 'average_rating', title: '{{ trans('messages.average_rating') }}'},
			{data: 'author_id', name: 'author_id', title: '{{ trans('common.customer_name') }}'},
			{data: 'recommend', name: 'recommend', title: '{{ trans('auth.feature') }}'},
			{data: 'approved', name: 'approved', title: '{{ trans('messages.waiting_for_approval') }}'},
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
			{data: 'action', name: 'action', title: '{{ trans('common.action') }}', searchable: false, sortable: false,className:"action-wrap"},
	    ],
		order: [[6, 'desc']],
		// language: {
		//   processing: '',
		// },
		drawCallback: function () {},
	  	});
	});
</script>
@stop