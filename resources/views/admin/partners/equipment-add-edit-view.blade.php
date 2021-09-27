<div class="modal fade" id="admin-create-equipement" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="adminCreateEquipement" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="create-equipement-title">{{ trans('messages.create_equipment') }}</h5>
        <button type="button" class="close admin-equipment-close-btn" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form name="admin_add_equipment" id="admin_add_equipment" action="{{route('admin.equipment.store')}}" method="post">
        @csrf
        <input type="hidden" name="partner_service_id" value="{{ isset($serviceInfo->id) ? $serviceInfo->id: null }}">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="custom_error alert alert-danger hide"></div>
                    <div class="custom_success alert alert-success hide"></div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{ trans('messages.equipment_name') }}<span class="required">&nbsp;*</span></label>
                        <input type="text" class="form-control {{ $errors->has('equipment_name') ? 'is-invalid' : '' }}" name="equipment_name" value="{{ old('equipment_name') }}" placeholder="{{ trans('messages.equipment_name')}}">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{ trans('auth.description') }}</label>
                        <textarea row="5" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" value="{{ old('description') }}" placeholder="{{ trans('auth.description') }}"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{ trans('messages.rent_type') }}</label>
                        <select name="rent_type" class="form-control">
                            <option value=""> {{ trans('messages.rent_type') }}</option>
                            @foreach ($rentType as $key => $value)
                                <option value="{{$key}}" > {{ $value }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{ trans('messages.rent') }}</label>
                        <input type="text" class="form-control  {{ $errors->has('rent') ? 'is-invalid' : '' }}" name="rent" value="{{ old('rent') }}" placeholder="{{ trans('messages.rent')}} *">
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="equipment_photo" class="custom-file-upload equipment_photo"> {{ trans('messages.equipment_photo') }} *</label><br/>
                    <input id="equipment_photo" type="file" name="equipment_photo[]" accept="image/x-png,image/gif,image/jpeg" multiple/>
                </div>
            </div>
            <div class="form-group row">
                <div class="images_preview_equipment_photo"></div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="text-center">
                <button type="submit" class="btn btn-primary">
                    {{ trans('auth.submit') }}
                </button>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="admin-update-equipement" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="adminUpdateEquipement" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="update-equipement-title">{{ trans('messages.update_equipment') }}</h5>
        <button type="button" class="close admin-equipment-close-btn" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form name="admin_equipment_update" id="admin_equipment_update" method="post" action="{{ route('admin.equipment.update') }}">
            @csrf
        <div class="modal-body">
            <input type="hidden" name="partner_service_id" value="{{ isset($serviceInfo->id) ? $serviceInfo->id: null }}">
            <input type="hidden" name="update-equipment-image" id="update-equipment-image">
            <input type="hidden" name="equipment_id" value="" id="equipment_id">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                    <div class="custom_error alert alert-danger hide"></div>
                    <div class="custom_success alert alert-success hide"></div>
                        <label>{{ trans('messages.equipment_name') }}<span class="required">&nbsp;*</span></label>
                        <input type="text" class="form-control {{ $errors->has('equipment_name') ? 'is-invalid' : '' }}" name="equipment_name" value="{{ old('equipment_name') }}" placeholder="{{ trans('messages.equipment_name')}}" id="admin-equipment-name">
                    </div>
               </div> 
                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{ trans('auth.description') }}</label>
                        <textarea row="5" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" value="{{ old('description') }}" placeholder="{{ trans('auth.description') }}" id="admin-description"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                   <div class="form-group">
                        <label>{{ trans('messages.rent_type') }}</label>
                        <select name="rent_type" class="form-control" id="admin_rent_type">
                            <option value=""> {{ trans('messages.rent_type') }}</option>
                            @foreach ($rentType as $key => $value)
                                <option value="{{$key}}" > {{ $value }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{ trans('messages.rent') }}</label>
                        <input type="text" class="form-control  {{ $errors->has('rent') ? 'is-invalid' : '' }}" name="rent" value="{{ old('rent') }}" placeholder="{{ trans('messages.rent')}}" id="admin_rent">
                    </div>
                </div>
                 <div class="col-md-12">
                    <label for="update_equipment_photo" class="custom-file-upload"> {{ trans('messages.equipment_photo') }} *</label><br/>
                    <input id="update_equipment_photo" type="file" name="update_equipment_photo[]" accept="image/x-png,image/gif,image/jpeg" multiple/>
                </div>
            </div><br>
            <div class="row uploaded-image-gallery"></div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary equipment-update">
                {{ trans('messages.update') }}
            </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- View Model -->
<div class="modal fade" id="admin-view-equipement" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="viewEquipement" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="view-equipement-title">{{ trans('messages.equipement_details') }}</h5>
                <button type="button" class="close admin-equipment-close-btn" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="form-datas">
                        <div class="col-md-12">
                            <div class="row form-group">
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                    <label> {{ trans('messages.equipment_name') }} </label>
                                </div>
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                    <p class="equipment-name"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row form-group">
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                    <label> {{ trans('messages.rent_type_label') }} </label>
                                </div>
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                    <p class="rent-type"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row form-group">
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                    <label> {{ trans('messages.rent') }} </label>
                                </div>
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                    <p class="rent"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label> {{ trans('auth.description')}} </label>
                            <p class="description"></p>
                        </div>
                    </div>
                </div>
                <div class="row equipment-gallery"></div>
            </div>
        </div>
    </div>
</div>
<!-- End view Model -->



<!-- Delete Model -->
<div class="modal fade" id="admin-delete-equipement" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="deleteEquipement" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="delete-equipement-title">Are you sure?</h5>
            <button type="button" class="close admin-equipment-close-btn" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form name="admin_equipment_delete" id="admin_equipment_delete" method="post" action="{{ route('admin.equipment.delete') }}">
            @csrf
            <input type="hidden" name="equipment_id"  id="equipment_delete_id" value="">
            <div class="modal-body">
                Do you really want to delete this record? This process cannot be undone.
            </div>
            <div class="modal-footer" id="delete-model-footer">
                <button type="button" class="btn btn-primary popup-close-btn" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger popup-delete-btn">{{ trans('common.delete') }}</button>
            </div>
      </form>
    </div>
  </div>
</div>
<!-- End delete Model -->