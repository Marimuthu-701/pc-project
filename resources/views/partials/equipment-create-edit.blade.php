<div class="modal fade" id="create-equipement" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="createEquipement" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="create-equipement-title">{{ trans('messages.create_equipment') }}</h5>
        <button type="button" class="close equipment-close-btn" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form name="equipment_create_form" id="equipment_create_form" action="{{ route('equipment.store') }}" method="post">
        @csrf
        <input type="hidden" name="partner_service_id" value="{{ isset($serviceInfo->id) ? $serviceInfo->id: null }}">
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12 col-xs-12 register-form-input">
                    <div class="custom_error alert alert-danger hide"></div>
                    <div class="custom_success alert alert-success hide"></div>
                    <input type="text" class="form-control equipment_name @error('equipment_name') is-invalid @enderror" name="equipment_name" value="{{ old('equipment_name') }}" placeholder="{{ trans('messages.equipment_name')}} *">
                </div>
                <div class="col-lg-12 col-xs-12 register-form-input">
                    <textarea row="5" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" placeholder="{{ trans('auth.description') }}"></textarea>
                </div>
                <div class="col-lg-12 col-xs-12 register-form-input">
                    <select name="rent_type" class="form-control">
                        <option value=""> {{ trans('messages.rent_type') }}</option>
                        @foreach ($rentType as $key => $value)
                            <option value="{{$key}}" > {{ $value }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-12 col-xs-12 register-form-input">
                    <input type="text" class="form-control equipment_name @error('rent') is-invalid @enderror" name="rent" value="{{ old('rent') }}" placeholder="{{ trans('messages.rent')}}">
                </div>
                <div class="col-lg-12 col-xs-12 register-form-input">
                    <label for="equipment_photo" class="custom-file-upload equipment_photo"> {{ trans('messages.equipment_photo') }} *</label>
                    <input id="equipment_photo" type="file" name="equipment_photo[]" accept="image/x-png,image/gif,image/jpeg" multiple/>
                </div>
            </div>
            <div class="form-group row">
                <div class="images_preview_equipment_photo"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary equipment-add">
                &nbsp;&nbsp;&nbsp;{{ trans('auth.submit') }}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i>
            </button>
            </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="update-equipement" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="updateEquipement" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="update-equipement-title">{{ trans('messages.update_equipment') }}</h5>
        <button type="button" class="close equipment-close-btn" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form name="equipment_update_form" id="equipment_update_form" method="post" action="{{ route('equipment.update') }}">
            @csrf
        <div class="modal-body">
            <input type="hidden" name="partner_service_id" value="{{ isset($serviceInfo->id) ? $serviceInfo->id: null }}">
            <input type="hidden" name="update-equipment-image" id="update-equipment-image">
            <input type="hidden" name="equipment_id" value="" id="equipment_id">
            <div class="row">
                <div class="col-lg-12 col-xs-12 register-form-input">
                    <div class="custom_error alert alert-danger hide"></div>
                    <div class="custom_success alert alert-success hide"></div>
                    <label class="col-lg-12 col-form-label my-account-lable required"> {{ trans('messages.equipment_name')}}</label>
                    <input type="text" class="form-control equipment_name @error('equipment_name') is-invalid @enderror" name="equipment_name" value="{{ old('equipment_name') }}" placeholder="{{ trans('messages.equipment_name')}}" id="equipment_name">
                </div>
                <div class="col-lg-12 col-xs-12 register-form-input">
                    <label class="col-lg-12 col-form-label my-account-lable"> {{ trans('auth.description')}} </label>
                    <textarea row="5" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="{{ trans('auth.description') }}" id="description"></textarea>
                </div>
                <div class="col-lg-12 col-xs-12 register-form-input">
                    <label class="col-lg-12 col-form-label my-account-lable"> {{ trans('messages.rent_type')}}</label>
                    <select name="rent_type" class="form-control" id="rent_type">
                        <option value=""> {{ trans('messages.rent_type') }}</option>
                        @foreach ($rentType as $key => $value)
                            <option value="{{$key}}" > {{ $value }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-12 col-xs-12 register-form-input">
                    <label class="col-lg-12 col-form-label my-account-lable"> {{ trans('messages.rent')}} </label>
                    <input type="text" class="form-control equipment_name @error('rent') is-invalid @enderror" name="rent" value="{{ old('rent') }}" placeholder="{{ trans('messages.rent')}}" id="rent">
                </div>
                <div class="col-lg-12 col-xs-12 register-form-input">
                    <label class="col-lg-12 col-form-label my-account-lable required"> {{ trans('messages.equipment_photo')}} </label>
                    <label for="update_equipment_photo" class="custom-file-upload my-accout-file equipment-file-name"> {{ trans('messages.equipment_photo') }}</label>
                    <input id="update_equipment_photo" type="file" name="update_equipment_photo[]" accept="image/x-png,image/gif,image/jpeg" multiple/>
                </div>
            </div>
            <div class="form-group row uploaded-image-gallery"></div>
            <div class="form-group row">
                <div class="images_preview_update_equipment_photo"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary equipment-update">
                &nbsp;&nbsp;&nbsp;{{ trans('messages.update') }}&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i>
            </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- View Model -->
<div class="modal fade" id="view-equipement" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="viewEquipement" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="view-equipement-title">{{ trans('messages.equipement_details') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="form-datas">
                        <div class="col-lg-12 col-xs-12 register-form-input">
                            <div class="row form-group">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <span>{{ trans('messages.equipment_name') }}</span>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <h5 class="semi-bold equipment-name"></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-xs-12 register-form-input">
                            <div class="row form-group">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <span>{{ trans('messages.rent_type_label') }}</span>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <h5 class="semi-bold rent-type"></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-xs-12 register-form-input">
                            <div class="row form-group">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <span>{{ trans('messages.rent') }}</span>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <h5 class="semi-bold rent"></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-xs-12 register-form-input">
                            <label class="col-lg-12 col-form-label my-account-lable"> {{ trans('auth.description')}} </label>
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
<div class="modal fade" id="delete-equipement" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="deleteEquipement" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="delete-equipement-title">Are you sure?</h5>
            <button type="button" class="close equipment-close-btn" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form name="equipment_delete_form" id="equipment_delete_form" method="post" action="{{ route('equipment.delete') }}">
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