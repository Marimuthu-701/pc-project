<table class="table table-bordered">
    <thead>
        <tr>
            <th>{{ trans('messages.equipment_name') }}</th>
            <th>{{ trans('auth.description') }}</th>
            <th>{{ trans('messages.rent_type_lable') }}</th>
            <th>{{ trans('messages.rent') }}</th>
            <!-- <th>{{ trans('messages.equipment_photo') }}</th> -->
            <th>{{ trans('common.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @if(count($equipmentsDetail) > 0)
            @foreach($equipmentsDetail as $key => $value)
                <tr>
                    <td>{{ isset($value['name']) ? $value['name'] : '-' }}</td>
                    <td>{{ isset($value['description']) ? Str::limit($value['description'], 50, '...') : '-' }}</td>
                    <td>{{ isset($value['rent_type']) ? ucfirst(str_replace('_', ' ', $value['rent_type'])) : '-' }}</td>
                    <td>{{ isset($value['rent']) ? currency($value['rent']) : '-' }}</td>
                    <td>
                        <button type="button" class="btn btn-primary view-btn" data-id="{{ $value['id'] }}">{{ trans('common.view') }}</button>
                        <button type="button" class="btn btn-primary update-btn" data-id="{{ $value['id'] }}">{{ trans('common.edit') }}</button>
                        <button type="button" class="btn btn-danger delete-btn" data-id="{{ $value['id'] }}" id="delete_alert_{{$value['id']}}">{{ trans('common.delete') }}</button>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6" style="text-align: center;">Record Not found</td>
            </tr>
        @endif
    </tbody>
</table>