@if (isset($view) && ($view === true))
	<a class="btn btn-primary table-view-btn" href="{{ route('admin.'. $source .'.'. $view_path, $item->id) }}" data-toggle="tooltip" data-placement="top" title="View"><i class="fas fa-eye"></i></a>&nbsp;
@endif

@if(isset($show) && ($show == true))
	<a class="btn btn-primary table-view-btn" href="{{ route('admin.'. $source .'.show', $item->id) }}" data-toggle="tooltip" data-placement="top" title="View"><i class="fas fa-eye"></i></a>&nbsp;
@endif

@if(isset($approval) && ($approval === true))
	<a class="btn btn-success" href="{{ route('admin.'. $source .'.'. $approval_path, $item->id) }}">{{ trans('common.approval') }}</a>&nbsp;&nbsp;
@else
	<a class="btn btn-primary table-edit-btn" href="{{ route('admin.'. $source .'.edit', $item->id) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;
	@if(isset($delete) && !$delete)
	@else
	<form method="POST" action="{{ route('admin.'. $source .'.destroy', $item->id) }}" class="list-inline-item item-delete-form">
	    {{ csrf_field() }}
	    {{ method_field('DELETE') }}
	    <button {{ isset($disabled) && $disabled ? 'disabled' : '' }} class="btn btn-danger table-delete-btn" type="submit" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash-alt"></i></button>
	</form>
	@endif
@endif