@extends('admin.layouts.app')

@section('title', trans('common.testimonials'))

@section('plugins.Datatables', true)

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1>{{ trans('common.testimonials') }}</h1>

    @include('admin.partials.breadcrumbs', ['breadcrumbs' => [
    	trans('common.testimonials')
    ]])
    
  </div>
  <div class="col-sm-6">
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-success bg-gradient-success btn-lg float-sm-right">{{ trans('admin.create_testimonial') }}</a>
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
            		<table class="table table-striped table-bordered" id="testimonial-data-table"></table>
            	</div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script type="text/javascript">
	$(function() {
		var table = $('#testimonial-data-table').DataTable({
			processing: true,
			serverSide: true,
			stateSave: true,
			searching: true,
			ajax: { 
	        url: "{!! route('admin.testimonials.index') !!}",
	        type:'GET',
	        data: function (d) {}
	    },
	    columns: [
			/*{data: 'id', name: 'id', title: '{{ trans('auth.id') }}'},*/
			{data: 'name', name: 'name', title: '{{ trans('auth.name') }}'},
			/*{data: 'email', name: 'email', title: '{{ trans('auth.email') }}'},*/
			/*{data: 'description', name: 'description', title: '{{ trans('auth.description') }}', searchable: false, sortable: false},*/
			{data: 'rating', name: 'rating', title: '{{ trans('messages.rating') }}'},
			{data: 'address', name: 'address', title: '{{ trans('auth.address') }}'},
			{data: 'status', name: 'status', title: '{{ trans('messages.waiting_for_approval') }}',className:"approve_wrap"},
			{data: 'created_at', name: 'created_at', title: '{{ trans('auth.created_at') }}', render: function(data, type, row){
                if(type === "sort" || type === "type"){
                    return data;
                }
                return moment(data).format("{{ config('app.admin_date_format') }}");
            }},
			{data: 'action', name: 'action', title: '{{ trans('common.action') }}', searchable: false, sortable: false,className:"action-wrap"},
	    ],
		order: [[4, 'desc']],
		// language: {
		//   processing: '',
		// },
		drawCallback: function () {},
	  	});
	});
</script>
@stop