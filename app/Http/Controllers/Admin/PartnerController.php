<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PartnerController as FrontPartnerController;
use App\Http\Controllers\AccountController;
use App\Models\PartnerServiceEquipment;
use App\Models\UserProfileUpdateHistory;
use App\Exports\PartnerServiceExport;
use App\Models\User;
use App\Models\State;
use App\Models\City;
use App\Models\Partner;
use App\Models\Service;
use App\Models\Facility;
use App\Models\PartnerService;
use App\Models\PartnerHome;
use App\Models\Media;
use App\Models\PartnerServiceMedia;
use App\Models\PartnerHomeMedia;
use Carbon\Carbon;
use DataTables;
use Validator;
use Flash;
use Hash;
use DB;
use Excel;

class PartnerController extends Controller
{
    protected $guard = 'admin';

    /**
     * @param Datatables $datatable
     *
     * @return mixed
     */
    public function index(Request $request, Datatables $datatable)
    {
        if ($request->ajax()) {
            $partners = User::with('service')->where('type', User::TYPE_PARTNER)->where('status', User::STATUS_ACTIVE)->get();
            //Partner::with('states', 'user')->get();
            return $this->datatable($partners, $request);
        }

        return view('admin.partners.index');
    }

    protected function datatable($query, $request)
    {
        return Datatables::of($query)
            ->addColumn('id', function ($query) {
                return $query->id;
            })->addColumn('email', function ($query) {
                return $query->email;
            })->addColumn('mobile', function ($query) {
                return $query->mobile_number;
            })->addColumn('company_name', function ($query) {
                return isset($query->service) ? $query->service->name : null;
            })->addColumn('service_type', function ($query) {
                return isset($query->service) ? $query->service->serviceType->name : null ;
            })->addColumn("created_at", function ($query) {
                return formatDateTime($query->created_at);
            })->addColumn('action', function ($query) {
                $view_path = 'services';
                return view('admin.partials.action', [
                    'item' => $query,
                    'source' => 'partners',
                    'disabled' => false,
                    'view_path' => $view_path,
                    'view' => true
                ]);
            })
            ->rawColumns(['action', 'checkbox', 'status', 'name'])
            ->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $govtApproved = PartnerService::govtApproved();
        $facilities = Facility::all();
        $getIdProof = getIdProof();
        $getGender  = getGender();
        $getShift   = getShiftType();
        $states = state::get();
        $cities = City::get();
        $provider_form = '';
        $provider_id = '';
        $getVerifiedStatus = User::getVerifiedStatus();
        if ($request->id) {
            $provider_id = $request->id;
            $form_set = Service::find($provider_id)->form_set;
            $provider_form = $this->providerTemplate($form_set);
        }
        $services = Service::where('status', User::STATUS_ACTIVE)->get();
        return view('admin.partners.create', compact('states', 'cities', 'services' ,'facilities', 'getIdProof', 'getGender',
            'getShift', 'provider_form', 'provider_id', 'getVerifiedStatus', 'govtApproved'));
    }

    /**
     * @param StoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $partnerTypes = Partner::getPartnerTypeWithName(); 
        $state = state::get();
        $form_data = $request->all();
        $user_id   = isset($request->user_id) ? $request->user_id : null;
        $form_set  = Service::find($request->service_provider)->form_set;
        if ($form_data) {
            if($user_id) {
                $userValidate = $this->userValidation($form_data);
                $user = User::find($user_id);
                    if ($userValidate->fails()) {
                         return redirect()->back()->withInput($form_data)->withErrors($userValidate->errors());
                    }
                    /* Old password Check*/
                    if ($request->old_password) {
                        $errors = ['old_password'=>array(trans('messages.old_password_error_message'))];
                        if (!Hash::check($request->old_password, $user->password)) {
                           return redirect()->back()->withInput($form_data)->withErrors($errors); 
                        }
                    }
                    $validator = $this->partnerServiceValidation($form_data, $form_set, false);
                    if ($validator->fails()) {
                        return redirect()->back()->withInput($form_data)->withErrors($validator->errors());
                    }
            } else{
                $validator = $this->partnerServiceValidation($form_data, $form_set);
                if ($validator->fails()) {
                    return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
                }
            }

            try {
                $partner_data = $this->partnerCreate($request, $form_set);
                if ($partner_data) {
                    Flash::success(trans('messages.partner_service_success'));
                    return redirect()->route('admin.partners.services');
                } else {
                    return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
                }
            } catch (\Exception $e) {
                return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
            }
        }
        return redirect()->route('admin.partners.services');
    }
    /**
     * @param AdminUser $admin
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $partnersStatus = User::getStatuses(); 
        $state = state::get();
        $partner = partner::with('user')->find($id);
        $cities = City::where('state', $partner->state)->get();
        return view('admin.partners.edit', [
            'partner' => $partner,
            'partnerStatus' => $partnersStatus,
            'state' => $state,
            'cities' => $cities,
        ]);
    }

    /**
     * @param UpdateRequest $request
     * @param AdminUser $admin
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $input  = $request->all();
        $partner = Partner::find($id);
        $validator = $this->validator($input, $partner->user_id);
        if ($validator->fails()) {
            return redirect()->back()
                ->withInput($input)
                ->withErrors($validator->errors());
        }

        $partner = Partner::find($id);
        $partner->name  = $input['name'];
        $partner->about = $input['about'];
        $partner->city  = $input['city'];
        $partner->state = $input['state'];
        $partner->postal_code = $input['postal_code'];
        $partner->save();

        $user = user::find($partner->user_id); 
        $user->email = $input['email']; 
        $user->mobile_number = $input['mobile']; 
        $user->status = $input['status'];
        $user->save();
        if ($partner->type == Partner::TYPE_HOME) {
            $partnerHome = PartnerHome::where('partner_id', $partner->id)->first();
            if($partnerHome != '') {
                return redirect()->route('admin.partners.homes.edit', $partnerHome->id);
            }else {
                return redirect()->route('admin.partners.homes.create', $partner->id);
            }
        } elseif ($partner->type == Partner::TYPE_SERVICE) {
            $partnerServices = PartnerService::where('partner_id', $partner->id)->first();
            if($partnerServices != '') {
                return redirect()->route('admin.partners.services.edit', $partnerHome->id);
            }else {
                return redirect()->route('admin.partners.services.create', $partner->id);
            }
        }

        Flash::success(trans('messages.partner_update'));

        return redirect()->route('admin.partners.index');
    }

    /**
     * @param Request $request
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $partner = partner::find($id)->first();
        $user_id = $partner->user_id;
        User::where('id', $user_id)
            ->delete();

        Flash::success(trans('messages.partner_delete'));

        return back();
    }

    protected function validator(array $data, $id="")
    {
        $rules = [
            'email'=>'required|unique:users,email,'.$id,
            'partnertype'=>'required',
            'status'=> 'required',
        ];
        return Validator::make($data, $rules);
    }

    //partner services 
    public function partnerServicesList(Request $request)
    {
        $userStatus = User::getStatuses();
        $states = State::all();
        $cities = City::all();
        $services = Service::whereStatus(true)->get();
        $getVerifiedStatus = User::getVerifiedStatus();
        $created_form = isset($request->created_from) ? mysqlDateFormat($request->created_from) : null;
        $created_to   = isset($request->created_to) ? mysqlDateFormat($request->created_to) : null;
        $featured_from = isset($request->featured_from) ? mysqlDateFormat($request->featured_from) : null;
        $featured_to   = isset($request->featured_to) ? mysqlDateFormat($request->featured_to) : null;
        $partnersService = PartnerService::select('partner_services.*')->with('parnterServiceMedia')
                             ->leftJoin('users as u', 'u.id', '=', 'partner_services.user_id');
        if ($request->ajax()) {
            $whereDate = null;
            
            if($created_form && $created_to) {
                $from = $created_form;
                $to   = $created_to;
            } else if ($created_form) {
                $from = $created_form;
                $to   = $created_form;
            } else if ($created_to) {
                $from = $created_to;
                $to   = $created_to;
            }

            if(isset($from) && isset($to)) {
                $whereDate ='DATE(partner_services.created_at) BETWEEN  "'.$from.'"  AND  "'.$to.'"';
                $partnersService = $partnersService->whereRaw($whereDate);
            }
            if($featured_from && $featured_to) {
                $partnersService = $partnersService->where('featured_from', '>=', $featured_from)->where('featured_to', '<=', $featured_to);
            }
            if($featured_from) {
                $partnersService = $partnersService->where('featured_from', '>=', $featured_from);
            }

            if($featured_to) {
                $partnersService = $partnersService->where('featured_to', '<=', $featured_to);
            }

            if($request->name) {
                $partnersService = $partnersService->where('name', 'Like', '%'.$request->name.'%');
            }

            if($request->email) {
                $partnersService = $partnersService->where('u.email', $request->email);   
            }

            if($request->mobile_number) {
                $partnersService = $partnersService->where('u.mobile_number', $request->mobile_number);   
            }

            if($request->service_type) {
                $partnersService = $partnersService->where('service_id', $request->service_type);
            }

            if($request->verified) {
                $partnersService = $partnersService->where('verified', $request->verified);
            }
            if ($request->approval) {
                $partnersService = $partnersService->where('partner_services.status', $request->approval);
            }
            $partnersService = $partnersService->get();
            return $this->partnerServicesDatatable($partnersService, $request);
        }
        return view('admin.partners.services', compact('userStatus', 'states', 'cities', 'services', 'getVerifiedStatus'));
    }

    protected function partnerServicesDatatable($query, $request)
    {
        return Datatables::of($query)
            ->addColumn('id', function ($query) {
                return $query->id;
            })->addColumn('email', function($query){
                return isset($query->user) ? $query->user->email :  null;
            })->addColumn('mobile_number', function($query){
                return isset($query->user) ? $query->user->mobile_number :  null;
            })->addColumn('name', function ($query) {
                return $query->name;
            })->addColumn('service_type', function($query){
                return isset($query->serviceType) ? $query->serviceType->name :  null;
            })->addColumn('registration_number', function ($query) {
                return $query->registration_number;
            })->addColumn('state', function ($query) {
                return isset($query->states) ? $query->states->name : null;
            })->addColumn('city', function ($query) {
                return isset($query->city) ? $query->city : null;
            })->addColumn('postal_code', function ($query) {
                return $query->postal_code;
            })->addColumn('status', function ($query) {
                return ($query->status == PartnerService::STATUS_ACTIVE) ? trans('common.active') : trans('common.inactive');
            })->addColumn('featured_from', function ($query) {
                $featureFromDate = null;
                if (isset($query->featured_from ) && !empty($query->featured_from)){
                    $featureFromDate = date('d-m-Y', strtotime($query->featured_from));
                }
                return $featureFromDate;
            })->addColumn('featured_to', function ($query) {
                $featureToDate   = null;
                if (isset($query->featured_to ) && !empty($query->featured_to)){
                    $featureToDate = date('d-m-Y', strtotime($query->featured_to));
                }
                return $featureToDate;
            })->addColumn('featured', function ($query) {
                $featured = '';
                if (isset($query->featured_from) && !empty($query->featured_from)) {
                    $featured = date('d-m-Y', strtotime($query->featured_from));
                }
                if (isset($query->featured_to) && !empty($query->featured_to)) {
                    $featureToDate = date('d-m-Y', strtotime($query->featured_to));
                    $featured = $featured ? $featured . ' to <br> ' . $featureToDate : $featureToDate;
                }
                return $featured;
            })->addColumn('verified', function ($query) {
                return ($query->verified == Partner::VERIFIED) ? trans('common.verified') : trans('common.not_verified');
            })->addColumn("created_at", function ($query) {
                return $query->created_at;
            })->addColumn("status", function ($query) {
                $approval_status = $query->status;
                 $view_path = 'approve';
                if ($approval_status == User::STATUS_PENDING) {
                        return view('admin.partials.action', [
                        'item' => $query,
                        'source' => 'partners.services',
                        'approval' => true,
                        'approval_path'=> $view_path,
                    ]);
                }elseif ($approval_status == User::STATUS_ACTIVE) {
                    return 'Approved';
                }else {
                    return '-';
                }
            })->addColumn('action', function ($query) {
                $view_path = 'view';
                return view('admin.partials.action', [
                    'item' => $query,
                    'source' => 'partners.services',
                    'disabled' => false,
                    'view_path' => $view_path,
                    'view' => true,

                ]);
            })->rawColumns(['action', 'checkbox', 'status', 'name', 'featured'])->make(true);
    }

    // Get serive detail Get by id
    public function viewService(Request $request, $id)
    {
        
        $serviceInfo = PartnerService::with('parnterServiceMedia')->find($id);
        $updateHistory = UserProfileUpdateHistory::where('user_id', $serviceInfo->user_id)
                        ->where('status', User::STATUS_PENDING)->first();
        $updateHistoryUser = isset($updateHistory->user_id) ? $updateHistory->user_id : null;
        $form_set = $serviceInfo->service->form_set;
        $getVerifiedStatus = User::getVerifiedStatus();
        $provider_id = $serviceInfo->service_id;
        $serviceMedia = array();
        if (count($serviceInfo->parnterServiceMedia) > 0) {
            foreach ($serviceInfo->parnterServiceMedia as $key => $value) {
                $serviceMedia[$key]['type'] = $value->type;
                $serviceMedia[$key]['file'] = $value->source;
                $serviceMedia[$key]['thump_url'] = storage_url(User::SERVICE_MEDIA_PATH_THUMB . $value->source);
                $serviceMedia[$key]['image_url'] = storage_url(User::SERVICE_MEDIA_PATH . $value->source);
            }
        }

        if ($serviceInfo->status == User::STATUS_ACTIVE) {
            $status = trans('common.active');   
        } elseif ($serviceInfo->status == User::STATUS_PENDING) {
            $status = trans('common.pending');   
        } else {
            $status = trans('common.inactive');   
        }

        $idProofimage = array();
        if(!empty($serviceInfo->id_proof_media_id)) {
            $mediaId = isset($serviceInfo->id_proof_media_id) ? explode(',', $serviceInfo->id_proof_media_id) : null;
            $idProofMedia = Media::whereIn('id',$mediaId)->get();
            if (count($idProofMedia) > 0) {
                foreach ($idProofMedia as $key => $value) {
                    $file_name  = $value->source;
                    $idProofimage[$key]['id_proof_thump_url'] = storage_url(User::ID_PROOF_IMAGE_SMALL . $file_name);
                    $idProofimage[$key]['id_proof_url'] = storage_url(User::ID_PROOF_MEDIA_PATH . $file_name);
                    $idProofimage[$key]['type'] = $value->type;
                }
            }
        }

        $avatarUrl = '';
        $avatar_thumb = '';
        if ($serviceInfo->getProfilePhoto) {
            $file_name  = $serviceInfo->getProfilePhoto->source;
            $avatar_thumb  = storage_url(User::AVATAR_MEDIA_PATH_THUMB . $file_name);
            $avatarUrl   = storage_url(User::AVATAR_MEDIA_PATH . $file_name);
        }

        $facilities = '';
        if(!empty($serviceInfo->partnerServiceFacilities)) {
            foreach ($serviceInfo->partnerServiceFacilities as $facility) {
                $facilities .= $facility['name'].', ';
            }
        }
        $facilities = trim($facilities,', ');

        // Get Equipment Details
        $equipmentsDetail = array();
        $equipmentsMedia  = array();
        if (isset($serviceInfo->equipments)) {
            $equipments =  $serviceInfo->equipments;
            if (count($equipments) > 0) {
                foreach ($equipments as $key => $value) {
                    $equipmentsDetail[$key]['id'] = $value->id;
                    $equipmentsDetail[$key]['name'] = $value->name;
                    $equipmentsDetail[$key]['description'] = $value->description;
                    $equipmentsDetail[$key]['rent_type'] = $value->rent_type;
                    $equipmentsDetail[$key]['rent'] = $value->rent;
                    $mediaId = isset($value->photo_ids) ? explode(',', $value->photo_ids) : null;
                    $equipmentMedia = Media::whereIn('id',$mediaId)->get();
                    if (count($equipmentMedia) > 0) {
                        foreach ($equipmentMedia as $mkey => $value) {
                            $equipmentsDetail[$key]['imageType'][] = $value->type;
                            $equipmentsDetail[$key]['thump_image'][] = storage_url(User::SERVICE_MEDIA_PATH_THUMB . $value->source);
                            $equipmentsDetail[$key]['imagePath'][] = storage_url(User::SERVICE_MEDIA_PATH . $value->source);
                        }
                    }
                }
            }
        }

        return view('admin.services.service-provider-view', compact('serviceInfo','getVerifiedStatus', 'serviceMedia', 'idProofimage','avatarUrl', 'facilities', 'equipmentsDetail', 'form_set', 'status', 'avatar_thumb', 'updateHistoryUser'));
    }

    public function viewNewChanges($user_id)
    {
        $updateHistory = UserProfileUpdateHistory::where('user_id', $user_id)->where('status', User::STATUS_PENDING)->first();
        $form_set = null;
        $serviceInfo = null;
        $getVerifiedStatus = array();
        if ($updateHistory) {
            $serviceInfo = isset($updateHistory->update_values) ? json_decode($updateHistory->update_values) : null;
            $state_code = $serviceInfo->state ?? null;
            $state = State::where('code', $state_code)->first();
            $providerDetail = PartnerService::where('user_id', $user_id)->where('status', User::STATUS_ACTIVE)->first();
            $serviceInfo->serviceType = $providerDetail->serviceType;
            $serviceInfo->states = $state;
            $form_set = $providerDetail->service->form_set;
            $getVerifiedStatus = User::getVerifiedStatus();
            $facilities = null;
            if(isset($serviceInfo->available_facilities) && !empty($serviceInfo->available_facilities)) {
                $getFacilities = Facility::whereIn('id', $serviceInfo->available_facilities)->pluck('name')->toArray();
                $facilities = implode(', ', $getFacilities);
            }
        } else {
            return redirect()->route('admin.partners.services');
        }
        return view('admin.services.view-changes', compact('form_set', 'getVerifiedStatus', 'updateHistory', 'serviceInfo', 'facilities'));
    }

    // Give to Approval Service
    public function serviceApproval($id)
    {
        $partnerServie = PartnerService::find($id);
        $partnerServie->status = User::STATUS_ACTIVE;
        $user_email = $partnerServie->user ? $partnerServie->user->email : null;
        //Send Comfirmation mail to user
        $mailData = [
            'slug'=> $partnerServie->slug,
            'name' => $partnerServie->name
        ];
        $mailProvider = new \App\Mail\ProviderApprovedNotificationMail($mailData);
        try {
            User::sendEmail($mailProvider, $user_email);
        } catch(\Exception $e) {
            Flash::error(trans('messages.something_wrong'));
            return redirect()->back();
        }
        if ($partnerServie->save()) {
            Flash::success(trans('messages.approvel_success'));
            return redirect()->route('admin.partners.services');
        }
        return redirect()->back()->withInput($input);
    }

    public function partnerServicesEdit($id)
    {
        $serviceInfo = PartnerService::with('parnterServiceMedia')->find($id);
        $facilities = Facility::all();
        $getIdProof = getIdProof();
        $getGender  = getGender();
        $getShift   = getShiftType();
        $states = state::get();
        $govtApproved = PartnerService::govtApproved();
        $cities = City::whereState($serviceInfo->state)->get();
        $services = Service::where('status', Service::STATUS_ACTIVE)->get();
        $getVerifiedStatus = User::getVerifiedStatus();
        $rentType = equipmentRentType();
        $provider_id = $serviceInfo->service_id;
        $form_set = Service::find($provider_id)->form_set;
        $provider_form = $this->providerTemplate($form_set);
        $serviceMedia = array();
        if (count($serviceInfo->parnterServiceMedia) > 0) {
            foreach ($serviceInfo->parnterServiceMedia as $key => $value) {
                $serviceMedia[$key]['id'] = $value->id;
                $serviceMedia[$key]['type'] = $value->type;
                $serviceMedia[$key]['file'] = $value->source;
                $serviceMedia[$key]['thumb_url'] = storage_url(User::SERVICE_MEDIA_PATH_THUMB . $value->source);
                $serviceMedia[$key]['url'] = storage_url(User::SERVICE_MEDIA_PATH . $value->source);
            }
        }
        $idProofUrlType = array();
        if(!empty($serviceInfo->id_proof_media_id)) {
            $mediaId = isset($serviceInfo->id_proof_media_id) ? explode(',', $serviceInfo->id_proof_media_id) : null;
            $idProofMedia = Media::whereIn('id',$mediaId)->get();
            if (count($idProofMedia) > 0) {
                foreach ($idProofMedia as $key => $value) {
                    $file_name  = $value->source;
                    $idProofUrlType[$key]['id_proof_thump_url'] = storage_url(User::ID_PROOF_IMAGE_SMALL . $file_name);
                    $idProofUrlType[$key]['id_proof_url'] = storage_url(User::ID_PROOF_MEDIA_PATH . $file_name);
                    $idProofUrlType[$key]['type'] = $value->type;
                    $idProofUrlType[$key]['name'] = $file_name;
                }
            }
        }
        $avatar_url = '';
        $avatar_thumb = '';
        if ($serviceInfo->getProfilePhoto) {
            $file_name  = $serviceInfo->getProfilePhoto->source;
            $avatar_thumb  = storage_url(User::AVATAR_MEDIA_PATH_THUMB . $file_name);
            $avatar_url = storage_url(User::AVATAR_MEDIA_PATH . $file_name);;
        }

        $selectedfecility = array();
        if (isset($serviceInfo->getServiceFacilities)) {
            $servicefacilities = $serviceInfo->getServiceFacilities;
            if(count($servicefacilities)) {
                foreach ($servicefacilities as $key => $value) {
                    $selectedfecility[$value['facility_id']] = $value['facility_id']; 
                }
            }
        }
        // Get Equipment Details
        /*$equipmentDetail = '';
        $equipmentMedia = array();
        if(isset($serviceInfo->equipment)){
            $equipmentDetail = $serviceInfo->equipment;
            $equipmentImageId = isset($equipmentDetail->photo_ids) ? explode(',', $equipmentDetail->photo_ids) : null;
            $equipmentMedia = Media::whereIn('id',$equipmentImageId)->get();
        }
        $equipmentImg = array();
        if (count($equipmentMedia) > 0) {
            foreach ($equipmentMedia as $key => $value) {
                $equipmentImg[$key]['type'] = $value->type;
                $equipmentImg[$key]['file'] = $value->source;
                $equipmentImg[$key]['url'] = asset(Storage::url(User::SERVICE_MEDIA_PATH.$value->source));
            }
        }*/
        $equipmentsDetail = array();
        if (isset($serviceInfo->equipments)) {
            $equipments =  $serviceInfo->equipments;
            if (count($equipments) > 0) {
                foreach ($equipments as $key => $value) {
                    $equipmentsDetail[$key]['id'] = $value->id;
                    $equipmentsDetail[$key]['name'] = $value->name;
                    $equipmentsDetail[$key]['description'] = $value->description;
                    $equipmentsDetail[$key]['rent_type'] = $value->rent_type;
                    $equipmentsDetail[$key]['rent'] = $value->rent;
                    $mediaId = isset($value->photo_ids) ? explode(',', $value->photo_ids) : null;
                    $equipmentMedia = Media::whereIn('id',$mediaId)->get();
                    if (count($equipmentMedia) > 0) {
                        foreach ($equipmentMedia as $mkey => $value) {
                            $equipmentsDetail[$key]['imageType'][] = $value->type;
                            $equipmentsDetail[$key]['imageThumb'][] = Storage::url(User::SERVICE_MEDIA_PATH_THUMB . $value->source);
                            $equipmentsDetail[$key]['imagePath'][] = Storage::url(User::SERVICE_MEDIA_PATH . $value->source);
                        }
                    }
                }
            }
        }

        return view('admin.partners.service-provider-edit', compact('serviceInfo', 'services', 'getVerifiedStatus', 'facilities', 'getIdProof', 'getGender', 'getShift', 'states', 'cities', 'provider_id', 'provider_form' ,'serviceMedia', 'idProofURL', 'idProofUrlType', 'avatar_url', 'selectedfecility', 'equipmentsDetail', 'equipmentImg', 'avatar_thumb', 'rentType', 'govtApproved'));
    }

    // User Validation
    protected function userValidation(array $data) 
    {
        $rules = [
            'mobile' => 'required|numeric|digits:10|unique:users,mobile_number,'.$data['user_id'],
            'email'=> 'required|email|max:255|unique:users,email,'.$data['user_id'],
        ];
        if($data['old_password']){
            $rules['old_password'] = 'min:6';
            $rules['new_password'] = 'min:6';
        }
        return Validator::make($data, $rules);
    }

    public function partnerServicesUpdate(Request $request, $id)
    {
        $input  = $request->all();
        $partnerCtrl = new FrontPartnerController;
        $accountCtrl = new AccountController;
        $userValidate = $this->userValidation($input);
        $available_facility = array();
        if ($request->user_id) {
            $user = User::find($request->user_id);
            if ($userValidate->fails()) {
                 return redirect()->back()->withInput($input)->withErrors($userValidate->errors());
            }
            /* Old password Check*/
            if ($request->old_password) {
                $errors = ['old_password'=>array(trans('messages.old_password_error_message'))];
                if (!Hash::check($request->old_password, $user->password)) {
                   return redirect()->back()->withInput($input)->withErrors($errors); 
                }
            }
            // Password update
            if ($request->new_password != null) {
                $user->password = Hash::make($request->new_password);
            }
            $user->email = $request->email;
            $user->mobile_number = $request->mobile;
            $user->save();
        }
        $service = PartnerService::find($id);
        $form_set =  $service->serviceType ? $service->serviceType->form_set : null;
        $validator = $this->partnerServiceValidation($input, $form_set, false);
        if ($validator->fails()) {
            return redirect()->back()->withInput($input)->withErrors($validator->errors());
        }
        //upload image
        $featureFromDate = null;
        $featureToDate   = null;
        if (isset($request->featured_from_date) && !empty($request->featured_from_date)) {
            $featureFromDate = date('Y-m-d',strtotime($request->featured_from_date));
        }
        if (isset($request->featured_to_date) && !empty($request->featured_to_date)) {
            $featureToDate = date('Y-m-d',strtotime($request->featured_to_date));
        }

        if($form_set == Service::FORM_SET_3) {
            $available_facility = $request->facilities_available ? array_filter($request->facilities_available) : array();
            if(count($available_facility) == 0) {
                $errors = ['facilities_available' => array(trans('auth.facilities_select'))];
                return redirect()->back()->withInput($input)->withErrors($errors); 
            }
        }
        //Comman field values
        $service->contact_phone = $request->contact_phone;
        $service->name = $request->name;
        $service->city = $request->city;
        $service->state = $request->state;
        $service->postal_code = $request->pin_code;
        $service->additional_info = $request->add_info;
        $service->featured_from = $featureFromDate;
        $service->featured_to = $featureToDate;
        $service->show_at_home  = $request->show_home;
        $service->position  = $request->position;
        $service->verified  = $request->verified;
        $mediaObject = $service->getProfilePhoto ? $service->getProfilePhoto : null;
        switch ($form_set) {
            case Service::FORM_SET_1:
                $service->gender = $request->gender;
                $service->dob = null;
                if (isset($request->date_of_birth) && !empty($request->date_of_birth)) {
                    $service->dob = date('Y-m-d',strtotime($request->date_of_birth));
                }
                $service->contact_email = $request->contact_email;
                $service->id_proof = $request->id_proof;
                $service->qualification = $request->qualification;
                $service->total_experience = $request->year_of_exp;
                $service->specialization_area = $request->area_of_specialization;
                $service->registration_number = $request->reg_no_or_licence_no;
                $service->working_at = $request->currently_working_at;
                if ($request->fees_type == User::PER_SHIFT) {
                    $service->fees_per_shift = $request->fees;
                    $service->fees_per_day = null;
                } else {
                    $service->fees_per_day  = $request->fees;
                    $service->fees_per_shift = null;
                }
                $idproof = $service->getIdProof;
                $upload_id_proof = $request->upload_id_proof ? array_filter($request->upload_id_proof) :null;
                if($request->profile_photo) {
                    $profile_photo_id = $this->profilePhotoUpdate($request->profile_photo, $mediaObject);
                    $service->profile_photo_id = $profile_photo_id;
                }
                if ($upload_id_proof) {
                    $mediaId = isset($service->id_proof_media_id) ? explode(',', $service->id_proof_media_id) : null;
                    if ($mediaId){
                        $idProofMedia = Media::whereIn('id',$mediaId)->get();
                        $storageDir = User::ID_PROOF_MEDIA_PATH;
                        if (count($idProofMedia) > 0) {
                            foreach ($idProofMedia as $key => $value) {
                                $file_name = $value->source;
                                Storage::delete($storageDir.$file_name);
                                Media::where('id', $value->id)->delete();
                            }
                        }
                    }
                    $id_proofId = $partnerCtrl->multiFileUpload($upload_id_proof, false);
                    $service->id_proof_media_id = $id_proofId ? implode(',', $id_proofId) : null;
                }
                break;

            case Service::FORM_SET_2:
                $service->registration_number = $request->reg_no_or_licence_no;
                $service->contact_person = $request->contact_person;
                $service->tests_provided = $request->list_of_provided;
                $service->address = $request->lab_address;
                $service->landline_number = $request->form_two_landline_number;
                $service->website_link = $request->website_link;
                $labImages = $request->lab_pharmacy_photo ? array_filter($request->lab_pharmacy_photo) :null;   
                if ($labImages) {
                    $accountCtrl->serviceFileUpload($labImages, $service);
                }
                if($request->profile_photo) {
                    $profile_photo_id = $this->profilePhotoUpdate($request->profile_photo, $mediaObject);
                    $service->profile_photo_id = $profile_photo_id;
                }
                break;

            case Service::FORM_SET_4:
                $service->registration_number = $request->reg_no_or_licence_no;
                $service->contact_person = $request->contact_person;
                $service->address = $request->medical_address;
                $service->landline_number = $request->landline_number;
                $service->website_link = $request->website_link;
                $medical_photos = $request->medical_profile_photo ? array_filter($request->medical_profile_photo) :null;
                if ($medical_photos) {
                    $accountCtrl->serviceFileUpload($medical_photos, $service);
                }
                if($request->profile_photo) {
                    $profile_photo_id = $this->profilePhotoUpdate($request->profile_photo, $mediaObject);
                    $service->profile_photo_id = $profile_photo_id;
                }
                break;

            case Service::FORM_SET_5:
                $service->registration_number = $request->reg_no_or_licence_no;
                $service->contact_person = $request->contact_person;
                $service->contact_email = $request->contact_email;
                $service->address = $request->address;
                $service->landline_number = $request->landline_number;
                $service->website_link = $request->website_link;
                $service->services_provided = $request->home_service_provider;
                $hocareImage = $request->care_home_photo ? array_filter($request->care_home_photo) : null;
                if ($hocareImage) {
                    $accountCtrl->serviceFileUpload($hocareImage, $service);
                }
                if($request->profile_photo) {
                    $profile_photo_id = $this->profilePhotoUpdate($request->profile_photo, $mediaObject);
                    $service->profile_photo_id = $profile_photo_id;
                }
                break;

            case Service::FORM_SET_6:
                $service->project_name = $request->project_name;
                $service->contact_person = $request->contact_person;
                $service->contact_email = $request->contact_email;
                $service->website_link = $request->website_link;
                $service->landline_number = $request->landline_number;
                $retimentHome = $request->retire_home_photo ? array_filter($request->retire_home_photo) : null;
                if ($retimentHome) {
                    $accountCtrl->serviceFileUpload($retimentHome, $service);
                }
                if($request->profile_photo) {
                    $profile_photo_id = $this->profilePhotoUpdate($request->profile_photo, $mediaObject);
                    $service->profile_photo_id = $profile_photo_id;
                }
                break;

            case Service::FORM_SET_3:
                $service->govt_approved = $request->govt_approved;
                $service->registration_number = $request->old_age_home_reg_no;
                $service->contact_person = $request->contact_person;
                $service->no_of_rooms = $request->number_of_rooms;
                $service->room_rent = $request->room_rent;
                $service->other_facilities = $request->other_facilities_available;
                $service->address = $request->old_home_address;
                $service->landline_number = $request->landline_number;
                $service->website_link = $request->website_link;
                $facilities  = $available_facility;
                $homePhoto = $request->home_avatar ? array_filter($request->home_avatar) :null;
                if ($homePhoto) {
                    $accountCtrl->serviceFileUpload($homePhoto, $service);
                }
                if($request->profile_photo) {
                    $profile_photo_id = $this->profilePhotoUpdate($request->profile_photo, $mediaObject);
                    $service->profile_photo_id = $profile_photo_id;
                }
                $service->serviceFacilities()->sync($facilities);
                break;

            default:
                
                break;
        }
        if ($service->push()) {
            Flash::success(trans('messages.partner_service_update'));
            return redirect()->route('admin.partners.services');
        } else {
            return redirect()->back()->withInput($input);
        }
    }

    public function partnerServicesDestory($id)
    {
        //PartnerService::where('id', $id)->delete();
        $service = PartnerService::find($id);
        $service->user ? $service->user->delete(): null;
        Flash::success(trans('messages.partner_service_delete'));
        return redirect()->route('admin.partners.services');
    }

    protected function serviceValidator(array $data)
    {
        $rules = [
            'services' => 'required',
            'name' => 'required',
            'father_name' => 'required',
            /*'dob' => 'required',*/
            'qualification' => 'required',
            'year_of_passing' => 'required',
            'college_name' => 'required',
            'working_at' => 'required',
            'specialization_area' => 'required',
            'total_experience' => 'required',
            'shift_timings' => 'required',
            'charges' => 'required',
            'current_address' => 'required',
        ];
        return Validator::make($data, $rules);
    }

    //partner homes 
    public function partnerHomesList(Request $request)
    {
            
            //$partnersHome = PartnerHome::with('partner', 'partnerHomeFacilities', 'parnterHomeMedia')->get();
        if ($request->ajax()) {
            $partnersHome = PartnerHome::with('partner', 'partnerHomeFacilities', 'parnterHomeMedias')->get();
            if(!empty($request->id)) {
                $partnersHome = $partnersHome->where('partner_id', $request->id); 
            }
            return $this->partnerHomesDatatable($partnersHome, $request);
        }

        return view('admin.partners.homes');
    }

    protected function partnerHomesDatatable($query, $request)
    {
        return Datatables::of($query)
            ->addColumn('name', function ($query) {
                return $query->partner->name;
            })->addColumn('id', function ($query) {
                return $query->id;
            })->addColumn('home_name', function ($query) {
                return $query->name;
            })->addColumn('address', function ($query) {
                return $query->address;
            })->addColumn('no_of_rooms', function ($query) {
                return $query->no_of_rooms;
            })->addColumn('facilities', function ($query) {
                if(!empty($query->partnerHomeFacilities)) {
                    $facilities = '';
                    foreach ($query->partnerHomeFacilities as $facility) {
                        $facilities .= $facility['name'].', ';
                    }
                }
                return trim($facilities,', ');
            })->addColumn('other_facilities', function ($query) {
                return $query->other_facilities;
            })->addColumn('upload_image', function ($query) {
                return '<a href="'.asset('storage/'.Partner::HOME_MEDIA_PATH.$query->parnterHomeMedias[0]->source).'" target="_blank"><img src="'.asset("images/pdf-image.jpg").'" alt="Upload Images" class="img-square pdf-icons"></a>';
            })->addColumn('status', function ($query) {
                return ($query->status == PartnerHome::STATUS_ACTIVE) ? trans('common.active') : trans('common.inactive');
            })->addColumn('featured_from', function ($query) {
                $featureFromDate = null;
                if (isset($query->featured_from ) && !empty($query->featured_from)){
                    $featureFromDate = date('d-m-Y',strtotime($query->featured_from));
                }
                return $featureFromDate;
            })->addColumn('featured_to', function ($query) {
                $featureToDate   = null;
                if (isset($query->featured_to ) && !empty($query->featured_to)){
                    $featureToDate = date('d-m-Y',strtotime($query->featured_to));
                }
                return $featureToDate;
            })->addColumn('verified', function ($query) {
                return ($query->verified == Partner::VERIFIED) ? trans('common.verified') : trans('common.not_verified');
            })->addColumn("created_at", function ($query) {
                return formatDateTime($query->created_at);
            })->addColumn('action', function ($query) {
                return view('admin.partials.action', [
                    'item' => $query,
                    'source' => 'partners.homes',
                    'disabled' => true,
                ]);
            })
            ->rawColumns(['action', 'checkbox', 'status', 'name','facilities','upload_image'])
            ->make(true);
    }

    public function partnerHomesEdit($id)
    {
        $partnerHome = PartnerHome::with('homeFacilities',  'parnterHomeMedias')->find($id);
        $selectedFacilities = $partnerHome->homeFacilities->pluck('facility_id')->toArray();
        $facilities = Facility::where('status', Facility::STATUS_ACTIVE)->get();
        $getVerifiedStatus = Partner::getVerifiedStatus();
        return view('admin.partners.homes-edit', [
            'partnerHome' => $partnerHome,
            'facilities' => $facilities,
            'selectedFacilities' => $selectedFacilities,
            'getVerifiedStatus' => $getVerifiedStatus,
        ]);
    }

    public function partnerHomesUpdate(Request $request, $id)
    {
        $input  = $request->all();
        $validator = $this->homeValidator($input, $id);
        if ($validator->fails()) {
            return redirect()->back()
                ->withInput($input)
                ->withErrors($validator->errors());
        }
        
        try {
            // file upload 
            $filename    = $request->upload_photo;
            $featureFromDate = null;
            $featureToDate   = null;
            if (isset($request->featured_from_date) && !empty($request->featured_from_date)) {
                $featureFromDate = date('Y-m-d',strtotime($request->featured_from_date));
            }
            if (isset($request->featured_to_date) && !empty($request->featured_to_date)) {
                $featureToDate = date('Y-m-d',strtotime($request->featured_to_date));
            }
            if(!empty($request->upload_photo)) {
                $mediaTitle  = pathinfo($filename->getClientOriginalName(),PATHINFO_FILENAME);
                $mediaType   = Partner::getFileType($filename);
                $image_name  = getRandomFileName($filename);
                $storageDir  = Partner::HOME_MEDIA_PATH;
                $imageUpload = Partner::uploadFile($filename,$image_name,$storageDir);
            }
            $partnerHomes = PartnerHome::with('parnterHomeMedias')->find($id);
            $partnerHomes->name         = $request->name;
            $partnerHomes->address      = $request->address;
            $partnerHomes->no_of_rooms  = $request->no_of_rooms;
            $partnerHomes->other_facilities  = $request->other_facilities;
            $partnerHomes->featured_from  = $featureFromDate;
            $partnerHomes->featured_to    = $featureToDate;
            $partnerHomes->verified = $request->verified;
            $partnerHomes->save();

            //image save to media
            if(!empty($request->upload_photo)) {
                $media = Media::find($partnerHomes->parnterHomeMedias[0]->id);
                $media->title = $mediaTitle;
                $media->type = $mediaType;
                $media->source = $image_name;
                $media->save();
            }
            
            //Sync to home facilities
            $partnerHomes->facilities()->sync($request->facility);
            
            Flash::success(trans('messages.partner_home_update'));

            return redirect()->route('admin.partners.homes');

        } catch (\Exception $e) {
            Flash::error(trans('messages.partner_home_update_error'));

            return redirect()->route('admin.partners.homes');
        }
    }

    public function partnerHomesDestory($id)
    {
        PartnerHome::where('id', $id)->delete();
        Flash::success(trans('messages.partner_home_delete'));
        return back();
    }

    protected function homeValidator(array $data)
    {
        $rules = [
            'name' => 'required',
            'facility' => 'required',
            'address' => 'required',
            'no_of_rooms' => 'required',
        ];
        return Validator::make($data, $rules);
    }

    // validation for partner account validation
    protected function partnerRegisterValidation(array $data) 
    {
        $rules = [
            'service_provider' =>'required',
            'mobile' => 'required|numeric|digits:10|unique:users,mobile_number',
            'email'=> 'required|email|max:255|unique:users',
            'password'=> 'required|min:6',
            'confirm_password' => 'required_with:password|same:password',
        ];
        $messages = [
            'mobile.unique' => 'Mobile Number already registered with us.',
            'email.unique' => 'Email already registered with us.',
        ];
        return Validator::make($data, $rules, $messages);
    }
    //create partner account creation
    protected function partnerCreate($request, $form_set)
    {
        $partnerCtrl = new FrontPartnerController;
        $available_facility = array();
        if(isset($request->user_id) && $request->user_id) {
            $user = User::find($request->user_id);
            if ($request->new_password != null) {
                $user->password = Hash::make($request->new_password);
            }
            $user->email = $request->email;
            $user->mobile_number = $request->mobile;
            $user->save();
            $user_id = $user->id;
        } else {
            $user = User::create([
                'email' => $request->email,
                'mobile_number' => $request->mobile,
                'type'   => 'partner',
                'status' => 1,
                'password' => Hash::make($request->password),
            ]);
            $user_id = $user->id;
        }
        if($form_set == Service::FORM_SET_3) {
            $available_facility = $request->facilities_available ? array_filter($request->facilities_available) : array();
            if(count($available_facility) == 0) {
                $errors = ['facilities_available' => array(trans('auth.facilities_select'))];
                return redirect()->back()->withInput($request)->withErrors($errors); 
            }
        }

        if ($user_id) {
            $createService = '';
            $formData = array();
            $formData['user_id'] = $user_id;
            $formData['service_id'] = $request->service_provider;
            $formData['status'] = 1 ;
            $formData['contact_phone'] = $request->contact_phone;
            $formData['name'] = $request->name;
            $formData['city'] = $request->city;
            $formData['state'] = $request->state;
            $formData['postal_code'] = $request->pin_code;
            $formData['additional_info'] = $request->add_info;
            $formData['featured_from'] = null;
            $formData['featured_to'] = null;
            $formData['show_at_home']  = $request->show_home;
            $formData['position']  = $request->position;
            $formData['verified']  = $request->verified;
            if (isset($request->featured_from_date) && !empty($request->featured_from_date)) {
                $formData['featured_from'] = date('Y-m-d',strtotime($request->featured_from_date));
            }
            if (isset($request->featured_to_date) && !empty($request->featured_to_date)) {
                $formData['featured_to'] = date('Y-m-d',strtotime($request->featured_to_date));
            }
            switch ($form_set) {
                case Service::FORM_SET_1:
                    $formData['gender'] = $request->gender;
                    $formData['dob'] = null;
                    if (isset($request->date_of_birth) && !empty($request->date_of_birth)) {
                        $formData['dob'] = date('Y-m-d',strtotime($request->date_of_birth));
                    }
                    $formData['contact_email'] = $request->contact_email;
                    $formData['id_proof'] = $request->id_proof;
                    $formData['qualification'] = $request->qualification;
                    $formData['total_experience'] = $request->year_of_exp;
                    $formData['specialization_area'] = $request->area_of_specialization;
                    $formData['registration_number'] = $request->reg_no_or_licence_no;
                    $formData['working_at'] = $request->currently_working_at;
                    if ($request->fees_type == User::PER_SHIFT) {
                        $formData['fees_per_shift'] = $request->fees;
                    } else {
                        $formData['fees_per_day'] = $request->fees;
                    }
                    try {
                        $id_prof_id = $partnerCtrl->multiFileUpload($request->upload_id_proof, false);
                        $formData['id_proof_media_id'] = $id_prof_id ? implode(',', $id_prof_id) : null;
                        if ($request->profile_photo) {
                            $avatar_id = $partnerCtrl->avatarAndDocUpload($request->profile_photo, User::AVATAR_IMAGE);
                            $formData['profile_photo_id'] = $avatar_id;
                        }
                        $createService = PartnerService::create($formData);
                    } catch (\Exception $e) {
                        return response()->json([
                            'success' => false,
                            'message' => $e->getMessage(),
                        ]);
                    }
                    break;

                case Service::FORM_SET_2:
                    $formData['registration_number'] = $request->reg_no_or_licence_no;
                    $formData['contact_person'] = $request->contact_person;
                    $formData['tests_provided'] = $request->list_of_provided;
                    $formData['address'] = $request->lab_address;
                    $formData['landline_number'] = $request->form_two_landline_number;
                    $formData['website_link'] = $request->website_link;
                    try {
                        if ($request->profile_photo) {
                            $avatar_id = $partnerCtrl->avatarAndDocUpload($request->profile_photo, User::AVATAR_IMAGE);
                            $formData['profile_photo_id'] = $avatar_id;
                        }
                        $labImages  = $request->lab_pharmacy_photo ? array_filter($request->lab_pharmacy_photo) : null;
                        if (!empty($labImages)) {
                            $lapMediaId = $partnerCtrl->multiFileUpload($labImages);
                        }
                        // Service creation and media sync to service media table
                        $createService = PartnerService::create($formData);
                        if (isset($lapMediaId) && !empty($lapMediaId)) {
                            $createService->serviceMedia()->sync($lapMediaId);
                        }
                    } catch (\Exception $e) {
                        return response()->json([
                            'success' => false,
                            'message' => $e->getMessage(),
                        ]);
                    }
                    break;

                case Service::FORM_SET_4:
                    $no_equipment = $request->equpment_count;
                    $formData['registration_number'] = $request->reg_no_or_licence_no;
                    $formData['contact_person'] = $request->contact_person;
                    $formData['address'] = $request->medical_address;
                    $formData['landline_number'] = $request->landline_number;
                    $formData['website_link'] = $request->website_link;
                    try {
                        if ($request->profile_photo) {
                            $avatar_id = $partnerCtrl->avatarAndDocUpload($request->profile_photo, User::AVATAR_IMAGE);
                            $formData['profile_photo_id'] = $avatar_id;
                        }
                        
                        $medicalImages = $request->medical_profile_photo ? array_filter($request->medical_profile_photo) : null;
                        if (!empty($medicalImages)) {
                            $medicalMediaId = $partnerCtrl->multiFileUpload($medicalImages);
                        }
                        $createService = PartnerService::create($formData);
                        if (isset($medicalMediaId) && !empty($medicalMediaId)) {
                            $createService->serviceMedia()->sync($medicalMediaId);
                        }
                        
                    } catch (\Exception $e) {
                        return response()->json([
                            'success' => false,
                            'message' => $e->getMessage(),
                        ]);
                    }
                    break;

                case Service::FORM_SET_5:
                    $formData['registration_number'] = $request->reg_no_or_licence_no;
                    $formData['contact_person'] = $request->contact_person;
                    $formData['contact_email'] = $request->contact_email;
                    $formData['address'] = $request->address;
                    $formData['landline_number'] = $request->landline_number;
                    $formData['website_link'] = $request->website_link;
                    $formData['services_provided'] = $request->home_service_provider;
                    try {
                        if ($request->profile_photo) {
                            $avatar_id = $partnerCtrl->avatarAndDocUpload($request->profile_photo, User::AVATAR_IMAGE);
                            $formData['profile_photo_id'] = $avatar_id;
                        }
                        $careHomeImages = $request->care_home_photo ? array_filter($request->care_home_photo) : null;
                        if (!empty($careHomeImages)) {
                            $careHomeMediaId = $partnerCtrl->multiFileUpload($careHomeImages);
                        }
                        $createService = PartnerService::create($formData);
                        if (isset($careHomeMediaId) && !empty($careHomeMediaId)) {
                            $createService->serviceMedia()->sync($careHomeMediaId);
                        }
                    } catch (\Exception $e) {
                        return response()->json([
                            'success' => false,
                            'message' => $e->getMessage(),
                        ]);
                    }
                    break;

                case Service::FORM_SET_6:
                    $formData['landline_number'] = $request->landline_number;
                    $formData['project_name'] = $request->project_name;
                    $formData['contact_person'] = $request->contact_person;
                    $formData['contact_email'] = $request->contact_email;
                    $formData['website_link'] = $request->website_link;
                    try {
                        if ($request->profile_photo) {
                            $avatar_id = $partnerCtrl->avatarAndDocUpload($request->profile_photo, User::AVATAR_IMAGE);
                            $formData['profile_photo_id'] = $avatar_id;
                        }
                        $retireHomeImages = $request->retire_home_photo ?  array_filter($request->retire_home_photo) : null;
                        if (!empty($retireHomeImages)) {
                            $retHomeMediaId = $partnerCtrl->multiFileUpload($retireHomeImages);
                        }
                        $createService = PartnerService::create($formData);
                        if (isset($retHomeMediaId) && !empty($retHomeMediaId)){
                            $createService->serviceMedia()->sync($retHomeMediaId);
                        }
                    } catch (\Exception $e) {
                        return response()->json([
                            'success' => false,
                            'message' => $e->getMessage(),
                        ]);
                    }
                    break;

                case Service::FORM_SET_3:
                    $formData['govt_approved'] = $request->govt_approved;
                    $formData['registration_number'] = $request->old_age_home_reg_no;
                    $formData['contact_person'] = $request->contact_person;
                    $formData['no_of_rooms'] = $request->number_of_rooms;
                    $formData['room_rent'] = $request->room_rent;
                    $formData['other_facilities'] = $request->other_facilities_available;
                    $formData['address'] = $request->old_home_address;
                    $formData['landline_number'] = $request->landline_number;
                    $formData['website_link'] = $request->website_link;
                    $facilities  = $available_facility;
                    try {
                        if ($request->profile_photo) {
                            $avatar_id = $partnerCtrl->avatarAndDocUpload($request->profile_photo, User::AVATAR_IMAGE);
                            $formData['profile_photo_id'] = $avatar_id;
                        }
                        $homeImages = $request->home_avatar ? array_filter($request->home_avatar) : null ;
                        if (!empty($homeImages)) {
                            $homeMediaId = $partnerCtrl->multiFileUpload($homeImages);
                        }
                        $createService = PartnerService::create($formData);
                        $createService->serviceFacilities()->sync($facilities);
                        if (isset($homeMediaId) && !empty($homeMediaId)) {
                            $createService->serviceMedia()->sync($homeMediaId);
                        }
                    } catch (\Exception $e) {
                        return response()->json([
                            'success' => false,
                            'message' => $e->getMessage(),
                        ]);
                    }
                    break;

                default:

                    break;
            }
            return $createService;
        }
    }

    public function partnerHomesCreate($partner_id)
    {
        $facilities = Facility::where('status', Facility::STATUS_ACTIVE)
            ->get();
        $getVerifiedStatus = Partner::getVerifiedStatus();
        return view('admin.partners.homes-create', [
            'facilities' => $facilities,
            'partner_id' => $partner_id,
            'getVerifiedStatus' => $getVerifiedStatus,
        ]);
    }

    public function partnerHomesStore(Request $data)
    {
        $partner_id = $data->partner_id;
        // file upload 
        $filename    = $data->upload_photo;
        $mediaTitle  = pathinfo($filename->getClientOriginalName(),PATHINFO_FILENAME);
        $mediaType   = Partner::getFileType($filename);
        $image_name  = getRandomFileName($filename);
        $storageDir  = Partner::HOME_MEDIA_PATH;
        $imageUpload = Partner::uploadFile($filename,$image_name,$storageDir);
        $featureFromDate = null;
        $featureToDate   = null;
        if (isset($data->featured_from_date) && !empty($data->featured_from_date)) {
            $featureFromDate = date('Y-m-d',strtotime($data->featured_from_date));
        }
        if (isset($data->featured_to_date) && !empty($data->featured_to_date)) {
            $featureToDate = date('Y-m-d',strtotime($data->featured_to_date));
        }

        if ($imageUpload) {
            $partnerHomeData = PartnerHome::create([
                'partner_id' => $data->partner_id,
                'name'       => $data->name, 
                'address'    => $data->address, 
                'no_of_rooms'=> $data->no_of_rooms, 
                'other_facilities'=> $data->other_facilities,
                'featured_from'=> $featureFromDate,
                'featured_to'=> $featureToDate,
                'verified'=> $data->verified,
                'status' => PartnerHome::STATUS_ACTIVE,
            ]);
            $partnerHomeId = $partnerHomeData->id;

            //image save to media
            $media = Media::create([
                'title' => $mediaTitle, 
                'type'  => $mediaType, 
                'source'=> $image_name, 
            ]);
            $mediaId = $media->id;

            //media id map to partner home media table
            $partnerHomeMedia = PartnerHomeMedia::create([
                'partner_home_id' => $partnerHomeId, 
                'media_id' => $mediaId, 
            ]);

            //Sync to home facilities
            $partnerHomeData->facilities()->sync($data->facility);

            Flash::success(trans('messages.partner_home_success'));
        }
        return redirect()->route('admin.partners.index');
        
    }
    public function partnerServicesCreate($partner_id)
    {
        $services = Service::where('status', Service::STATUS_ACTIVE)
            ->get();
        $getVerifiedStatus = Partner::getVerifiedStatus();
        return view('admin.partners.services-create', [
            'yearofpassing' => getYearOfPassing(),
            'preferredShiftTime' => getShiftTimings(),
            'partner_id' => $partner_id,
            'services' => $services,
            'getVerifiedStatus' => $getVerifiedStatus,
        ]);
    }

    public function partnerServicesStore(Request $data)
    {

        $partner_id = $data->partner_id;
        //upload image
        $filename  = $data->qualification_certificate;
        $dob = null;
        if (isset($data->dob) && !empty($data->dob)) {
            $dob = date('Y-m-d',strtotime($data->dob));
        }
        $featureFromDate = null;
        $featureToDate   = null;
        if (isset($data->featured_from_date) && !empty($data->featured_from_date)) {
            $featureFromDate = date('Y-m-d',strtotime($data->featured_from_date));
        }
        if (isset($data->featured_to_date) && !empty($data->featured_to_date)) {
            $featureToDate = date('Y-m-d',strtotime($data->featured_to_date));
        }
        $partnerServiceData = PartnerService::create([
            'partner_id' => $data->partner_id,
            'service_id' => $data->services,
            'name'       => $data->name,
            'father_name'=> $data->father_name, 
            'dob'        => $dob, 
            'qualification'=> $data->qualification, 
            'year_of_passing'=> $data->year_of_passing, 
            'college_name'=> $data->college_name, 
            'working_at' => $data->working_at, 
            'specialization_area' => $data->specialization_area, 
            'total_experience' => $data->total_experience, 
            'shift_timings' => $data->shift_timings, 
            'charges' => $data->charges, 
            'address' => $data->current_address, 
            'additional_info' => $data->additional_info,
            'status' => PartnerService::STATUS_ACTIVE,
            'featured_from'=> $featureFromDate,
            'featured_to'=> $featureToDate,
            'verified'=> $data->verified,
        ]);
        $partnerServiceid = $partnerServiceData->id;
        if (!empty($filename)) {
            //create service information
            $mediaTitle  = pathinfo($filename->getClientOriginalName(),PATHINFO_FILENAME);
            $mediaType   = Partner::getFileType($filename);
            $image_name  = getRandomFileName($filename);
            $storageDir  = Partner::SERVICE_MEDIA_PATH;
            $imageUpload = Partner::uploadFile($filename,$image_name,$storageDir);

            //image save to media
            $media = Media::create([
                'title' => $mediaTitle, 
                'type'  => $mediaType, 
                'source'=> $image_name, 
            ]);
            $mediaId = $media->id;

            //media id map to partner service media table
            $partnerServiceMedia = PartnerServiceMedia::create([
                'partner_service_id' => $partnerServiceid, 
                'media_id' => $mediaId, 
            ]);
            Flash::success(trans('messages.service_success'));
        }
        return redirect()->route('admin.partners.index');
    }
    //Service porovider Register validation
    public function partnerServiceValidation(array $data, $form_set, $type = true)
    {
        $rules = array();
        // This field for user field
        if ($type) {
            $rules['mobile'] = 'required|numeric|digits:10|unique:users,mobile_number';
            $rules['email'] = 'required|email|max:255|unique:users';
            $rules['password'] = 'required|min:6';
            $rules['confirm_password'] = 'required_with:password|same:password';
        }

        $age_before = Carbon::now()->subYears(config('app.age_limit'))->format('Y-m-d');
        // This filed for services
        $rules['service_provider']='required';
        $rules['name']='required|regex:'.config('app.name_validation');
        $rules['contact_phone']='required|numeric|digits:10';
        $rules['state'] = 'required';
        $rules['city'] = 'required';
        $rules['pin_code'] = 'required|numeric|digits:6';
        if ($form_set == Service::FORM_SET_1) {
            $rules['gender']='required';
            $rules['date_of_birth'] ='required|date_format:d-m-Y|before:' . $age_before;
            $rules['id_proof'] ='required';
            $rules['qualification'] ='required';
            $rules['year_of_exp'] ='required';
            $rules['area_of_specialization'] ='required';
            $rules['reg_no_or_licence_no'] ='required';
        } else if ($form_set == Service::FORM_SET_2) {
            $rules['reg_no_or_licence_no'] ='required';
            $rules['contact_person'] ='required';
            $rules['form_two_landline_number'] = 'nullable|regex:'.config('app.landline_validation');
        }else if ($form_set == Service::FORM_SET_3) {
            $rules['govt_approved'] = 'required';
            $rules['old_age_home_reg_no'] = 'required_if:govt_approved,1';
            $rules['contact_person'] ='required';
            $rules['number_of_rooms'] ='required';
            $rules['facilities_available'] ='required';
            $rules['landline_number'] ='nullable|regex:'.config('app.landline_validation');
            $rules['room_rent'] ='nullable|regex:/^\d+(\.\d{1,2})?$/';
        }else if($form_set  == Service::FORM_SET_4) {
            $rules['reg_no_or_licence_no'] ='required';
            $rules['contact_person'] ='required';
            $rules['landline_number'] ='nullable|regex:'.config('app.landline_validation');
        }else if ($form_set == Service::FORM_SET_5) {
            $rules['reg_no_or_licence_no'] ='required';
            $rules['contact_person'] ='required';
            $rules['address'] = 'required';
            $rules['landline_number'] ='nullable|regex:'.config('app.landline_validation');
        }else if ($form_set == Service::FORM_SET_6) {
            $rules['project_name'] ='required';
            $rules['contact_person'] ='required';
            $rules['landline_number'] ='nullable|regex:'.config('app.landline_validation');
        }

        $messages['mobile.unique'] = 'Mobile Number already registered with us.';
        $messages['email.unique'] =  'Email already registered with us.';
        $messages['date_of_birth.before'] = 'You must be at least 13 years old';
        $messages['date_of_birth.date_format'] = 'Date of birth format should be DD-MM-YYYY';
        $messages['form_two_landline_number.numeric'] = 'Landline number be a numbers and space & -';
        $messages['old_age_home_reg_no.required_if'] = 'Registration number is required.';

        return Validator::make($data, $rules, $messages);
    }
    
    //Get service provider forms
    public function seviceTemplateByType(Request $request)
    {
        $govtApproved = PartnerService::govtApproved();
        $facilities = Facility::all();
        $services   = Service::all();
        $getIdProof = getIdProof();
        $getGender  = getGender();
        $getShift   = getShiftType();
        $states = State::all();
        $cities = City::all();
        $form_set = $request->provider_type;
        $providerForm = $this->providerTemplate($form_set);
        if ($providerForm) {
            return view('admin.partners.'.$providerForm, compact('facilities', 'services', 'getIdProof', 'getGender', 'getShift',
             'states', 'cities', 'govtApproved'));
        }
    }

    //Get Provider Templated
    public function  providerTemplate($form_set)
    {
        $template = '';
        switch ($form_set) {
            case Service::FORM_SET_1:
                $template = "nurse-physiotherapist";
                break;
            
            case Service::FORM_SET_2:
                $template = "lab-pharmacy-ambulance";
                break;

            case Service::FORM_SET_3:
                $template = "olg-age-home";
                break;

            case Service::FORM_SET_4:
                $template = "medical-equipment-rental";
                break;

            case Service::FORM_SET_5:
                $template = "home-care";
                break;

            case Service::FORM_SET_6:
                $template = "retirment-home";
                break;

            default:
                # code...
                break;
        }
        return $template;
    }

    public function profilePhotoUpdate($file_name, $avatarObj)
    {
        if ($file_name) {
            $filename    = $file_name;
            $mediaTitle  = pathinfo($filename->getClientOriginalName(),PATHINFO_FILENAME);
            $mediaType   = getFileType($filename);
            $image_name  = getRandomFileName($filename);
            $storageDir  = User::AVATAR_MEDIA_PATH;
            $compress    = $mediaType == 'image' ? true : false;
            $imageUpload = User::uploadFile($filename, $image_name, $storageDir, $compress);
            $mediaId = null;
            if(!empty($avatarObj)) {
                $oldimageName = $avatarObj->source;
                $avatarObj->title  = $mediaTitle;
                $avatarObj->type   = $mediaType;
                $avatarObj->source = $image_name;
                $avatarObj->save();
                Storage::delete($storageDir.$oldimageName);
                $mediaId = $avatarObj->id;
            }else{
                $media = Media::create([
                    'title' => $mediaTitle, 
                    'type'  => $mediaType, 
                    'source'=> $image_name, 
                ]);
                $mediaId = $media->id;
            }
            return $mediaId;
        }
    }

    public function incompleteProvider(Datatables $datatable, Request $request)
    {
        if ($request->ajax()) {
            $incompleteProvider = User::whereType(User::TYPE_PARTNER)->whereStatus(true)->whereNotIn('id', function($query){
                    $query->select('user_id')->from('partner_services');
            })->get();
            return $this->incompleteProviderDatatable($incompleteProvider, $request);
        }
        return view('admin.partners.incomplete-provider-list');
    }

    protected function incompleteProviderDatatable($query, $request)
    {
        return Datatables::of($query)
            ->addColumn('id', function ($query) {
                return $query->id;
            })->addColumn('email', function($query){
                return $query->email;
            })->addColumn('mobile_number', function($query){
                return $query->mobile_number;
            })->addColumn("status", function ($query) {
                if ($query->status == User::STATUS_ACTIVE) {
                    return $query->status = trans('common.active');   
                } elseif ($query->status == User::STATUS_PENDING) {
                    return $query->status = trans('common.pending');   
                } else {
                    return $query->status = trans('common.inactive');   
                }
            })->addColumn('created_at', function ($query) {
                return $query->created_at;
            })->addColumn('updated_at', function ($query) {
                return $query->updated_at;
            })->addColumn('action', function ($query) {
                return view('admin.partials.action', [
                    'item' => $query,
                    'source' => 'partners.incomplete',
                    'disabled' => false,
                ]);
            })->rawColumns(['action', 'status', 'name'])->make(true);
    }

    public function incompleteProviderEdit(Request $request, $user_id)
    {
        $govtApproved = PartnerService::govtApproved();
        $userDetail = User::find($user_id);
        $facilities = Facility::all();
        $getIdProof = getIdProof();
        $getGender  = getGender();
        $getShift   = getShiftType();
        $states = state::get();
        $cities = City::get();
        $provider_form = '';
        $provider_id = '';
        $getVerifiedStatus = User::getVerifiedStatus();
        if ($request->id) {
            $provider_id = $request->id;
            $form_set = Service::find($provider_id)->form_set;
            $provider_form = $this->providerTemplate($form_set);
        }
        $services = Service::where('status', User::STATUS_ACTIVE)->get();
        return view('admin.partners.create', compact('states', 'cities', 'services' ,'facilities', 'getIdProof', 'getGender',
            'getShift', 'provider_form', 'provider_id', 'getVerifiedStatus', 'userDetail', 'govtApproved'));
    }

    public function incompleteProviderDestroy($id)
    {
        $service = User::find($id)->delete();
        Flash::success(trans('messages.partner_delete'));
        return redirect()->route('admin.partners.incomplete');
    }

    //Equipment Store
    public function equipmentStore(Request $request)
    {
        $partnerCtrl = new FrontPartnerController;
        $input_data = $request->all();
        $validator = Validator::make($input_data, [
            'partner_service_id' => 'required',
            'equipment_name' => 'required',
            //'rent_type' => 'required',
            //'rent' => 'required',
            'equipment_photo.*' => 'required|mimes:jpeg,jpg,png,bmp,pdf,doc,docx|max:500000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => trans('messages.incorrect_form_values'),
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }
        $equipmentData['partner_service_id'] = $request->partner_service_id;
        $equipmentData['name'] = $request->equipment_name;
        $equipmentData['description'] = $request->description;
        $equipmentData['rent_type'] = $request->rent_type;
        $equipmentData['rent'] = $request->rent;
        $equipmentPhoto = $request->equipment_photo;
        try {
            $equipmentImageId = $partnerCtrl->multiFileUpload($equipmentPhoto);
            $equipmentData['photo_ids'] = implode(',', $equipmentImageId);
            $equipmentCreate  = PartnerServiceEquipment::create($equipmentData);
            if ($equipmentCreate) {
                return response()->json([
                    'success' => true,
                    'message' => trans('messages.equipment_success'),
                    'data'    => $equipmentCreate,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => trans('messages.equipment_errror'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }


    public function getByEquipment(Request $request)
    {
        $equipment_id = $request->id;
        $getByEquipment = PartnerServiceEquipment::find($equipment_id);
        $mediaId = isset($getByEquipment->photo_ids) ? explode(',', $getByEquipment->photo_ids) : null;
        $equipmentMedia = Media::whereIn('id',$mediaId)->get();
        $equipmentsmedias = array();
        if (count($equipmentMedia) > 0) {
            foreach ($equipmentMedia as $key => $value) {
                $equipmentsmedias[$key]['equipment_id'] = $getByEquipment->id;
                $equipmentsmedias[$key]['image_id'] = $value->id;
                $equipmentsmedias[$key]['imageName'] = $value->source;
                $equipmentsmedias[$key]['imageType'] = $value->type;
                $equipmentsmedias[$key]['imagePath'] = storage_url(User::SERVICE_MEDIA_PATH.$value->source);
                $equipmentsmedias[$key]['imageThumbPath'] = storage_url(User::SERVICE_MEDIA_PATH_THUMB.$value->source);;
            }
        }

        $data = array('equpment_info'=>$getByEquipment, 'media'=> $equipmentsmedias);
        if ($getByEquipment) {
            return response()->json([
                'success' => true,
                'data'    => $data,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => trans('messages.something_wrong'),
            ]);
        }
    }

    public function equipmentUpdate(Request $request)
    {
        $partnerCtrl = new FrontPartnerController;
        $equipment_id = $request->equipment_id;
        $input_data = $request->all();
        $validator = Validator::make($input_data, [
            'equipment_name' => 'required',
            //'rent_type' => 'required',
            //'rent' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => trans('messages.incorrect_form_values'),
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }
        $serviceEquipment = PartnerServiceEquipment::find($equipment_id);
        $mediaId = isset($serviceEquipment->photo_ids) ? explode(',', $serviceEquipment->photo_ids) : null;
        $equipmentMedia = Media::whereIn('id',$mediaId)->get();
        // Update Equipment Details
        $serviceEquipment->name = $request->equipment_name;
        $serviceEquipment->description = $request->description;
        $serviceEquipment->rent_type = $request->rent_type;
        $serviceEquipment->rent = $request->rent;
        $equipment_image  = $request->update_equipment_photo ? array_filter($request->update_equipment_photo) :null;
        try {
            if ($equipment_image) {
                /*$storageDir = User::SERVICE_MEDIA_PATH;
                if (count($equipmentMedia) > 0) {
                    foreach ($equipmentMedia as $key => $value) {
                        $file_name = $value->source;
                        Storage::delete($storageDir.$file_name);
                        Media::where('id', $value->id)->delete();
                    }
                }*/
                $equipmentImageId = $partnerCtrl->multiFileUpload($equipment_image);
                $eqpMediaId = array_merge($mediaId, $equipmentImageId);
                $serviceEquipment->photo_ids = ltrim(implode(',', $eqpMediaId), ',');
            }
            if ($serviceEquipment->save()) {
                return response()->json([
                    'success' => true,
                    'message' => trans('messages.equipment_update_success'),
                    'data'    => $serviceEquipment,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => trans('messages.something_wrong'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }        
    }

    //Remove Equipment
    public function equipmentDelete(Request $request)
    {
        $equipment_id = $request->equipment_id;
        if ($equipment_id) {
            $getByEquipment = PartnerServiceEquipment::find($equipment_id);
            $mediaId = isset($getByEquipment->photo_ids) ? explode(',', $getByEquipment->photo_ids) : null;
            $equipmentMedia = Media::whereIn('id',$mediaId)->get();
            $storageDir = User::SERVICE_MEDIA_PATH;
            if (count($equipmentMedia) > 0) {
                foreach ($equipmentMedia as $key => $value) {
                    $file_name = $value->source;
                    Storage::delete($storageDir.$file_name);
                    Media::where('id', $value->id)->delete();
                }
            }
            $deleteEquipment = $getByEquipment->delete();
            if ($deleteEquipment) {
                return response()->json([
                    'success' => true,
                    'message' => trans('messages.equipment_delete'),
                    'data'    => $deleteEquipment,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => trans('messages.create_failed'),
                ]);
            }
        }
    }

    public function providersExport()
    {
        return Excel::download(new PartnerServiceExport, trans('common.partner_services').'.xlsx');
    }

    //Service provider photo delete
    public function providerPhotoDelete(Request $request, $id)
    {
        $mediaId = $id;
        $media = Media::find($mediaId);
        $storageDir  = User::SERVICE_MEDIA_PATH;
        if ($media) {
            $imageName  = $media->source;
            Storage::delete($storageDir . $imageName);
            if ($media->delete()) {
                Flash::success(trans('messages.photo_delete_success'));
                return redirect()->back();
            } else {
                Flash::error(trans('messages.photo_delete_error'));
                return redirect()->back()->withInput($request->all());
            }
        } else{
            Flash::error(trans('messages.something_wrong'));
            return redirect()->back();
        }
    }

    public function equipmentPhotoDelete(Request $request)
    {
        $id = $request->id;
        $media_id = $request->media_id;
        $medias  = array();
        $equipmentDetail = PartnerServiceEquipment::find($id);
        if ($equipmentDetail) {
            $equipmentMedia = $equipmentDetail->photo_ids;
            if ($equipmentMedia) {
                $medias = explode(',', $equipmentMedia);
                if (($key = array_search($media_id, $medias)) !== false) {
                    unset($medias[$key]);
                }
            }
            $media = Media::find($media_id);
            $storageDir  = User::SERVICE_MEDIA_PATH;
            if ($media) {
                $imageName  = $media->source;
                Storage::delete($storageDir . $imageName);
                if ($media->delete()) {
                    $equipmentDetail->photo_ids = implode(',', $medias);
                    $equipmentDetail->save();
                    return response()->json([
                        'success' => true,
                        'data' => $media,
                        'media_count'=> count($medias),
                        'message' => trans('messages.photo_delete_success'),
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => trans('messages.photo_delete_error'),
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => trans('messages.not_found'),
            ]);
        }
    }

    //provider updated record approve
    public function profileUpdatedApprove($id)
    {
        $updateProfile = UserProfileUpdateHistory::find($id);
        if ($updateProfile) {
            $updatedData = isset($updateProfile->update_values) ? json_decode($updateProfile->update_values) : null;
            if ($updateProfile->status == User::STATUS_PENDING) {
                $updateProfile->status = User::STATUS_ACTIVE;
                if ($updatedData) {
                    $updatedProvider = PartnerService::where('user_id', $updateProfile->user_id)->first();
                    if ($updatedProvider) {
                        $updatedProvider->name = $updatedData->name;
                        $updatedProvider->govt_approved = $updatedData->govt_approved;
                        $updatedProvider->registration_number = $updatedData->registration_number;
                        $updatedProvider->contact_person = $updatedData->contact_person;
                        $updatedProvider->contact_phone = $updatedData->contact_phone;
                        $updatedProvider->contact_email = $updatedData->contact_email;
                        $updatedProvider->landline_number = $updatedData->landline_number;
                        $updatedProvider->dob = $updatedData->dob;
                        $updatedProvider->gender = $updatedData->gender;
                        $updatedProvider->id_proof = $updatedData->id_proof;
                        $updatedProvider->qualification = $updatedData->qualification;
                        $updatedProvider->working_at = $updatedData->working_at;
                        $updatedProvider->specialization_area = $updatedData->specialization_area;
                        $updatedProvider->total_experience = $updatedData->total_experience;
                        $updatedProvider->no_of_rooms = $updatedData->no_of_rooms;
                        $updatedProvider->room_rent = $updatedData->room_rent;
                        $updatedProvider->other_facilities = $updatedData->other_facilities;
                        $updatedProvider->address = $updatedData->address;
                        $updatedProvider->city = $updatedData->city;
                        $updatedProvider->state = $updatedData->state;
                        $updatedProvider->postal_code = $updatedData->postal_code;
                        $updatedProvider->additional_info = $updatedData->additional_info;
                        $updatedProvider->website_link = $updatedData->website_link;
                        $updatedProvider->services_provided = $updatedData->services_provided;
                        $updatedProvider->tests_provided = $updatedData->tests_provided;
                        $updatedProvider->project_name = $updatedData->project_name;
                        if (isset($updatedData->id_proof_media_id) && $updatedData->id_proof_media_id) {
                            $mediaId = isset($updatedProvider->id_proof_media_id) ? explode(',', $updatedProvider->id_proof_media_id) : null;
                            if ($mediaId){
                                $idProofMedia = Media::whereIn('id',$mediaId)->get();
                                $storageDir = User::ID_PROOF_MEDIA_PATH;
                                if (count($idProofMedia) > 0) {
                                    foreach ($idProofMedia as $key => $value) {
                                        $file_name = $value->source;
                                        Storage::delete($storageDir.$file_name);
                                        Media::where('id', $value->id)->delete();
                                    }
                                }
                            }
                            $updatedProvider->id_proof_media_id = $updatedData->id_proof_media_id;
                        }

                        if ($updatedData->fees_type == User::PER_SHIFT) {
                            $updatedProvider->fees_per_shift = $updatedData->fees;
                            $updatedProvider->fees_per_day = null;
                        } elseif($updatedData->fees_type == User::PER_DAY) {
                            $updatedProvider->fees_per_day  = $updatedData->fees;
                            $updatedProvider->fees_per_shift = null;
                        }

                        if (isset($updatedData->media_id) && !empty($updatedData->media_id)) {
                            $updatedProvider->serviceMedia()->sync($updatedData->media_id);
                        }
                        if (isset($updatedData->available_facilities) && !empty($updatedData->available_facilities)) {
                            $updatedProvider->serviceFacilities()->sync($updatedData->available_facilities);
                        }
                        try {
                            if($updatedProvider->push()) {
                                $user_email = $updatedProvider->user ? $updatedProvider->user->email : null;
                                $mailData = ['slug'=> $updatedProvider->slug, 'name' => $updatedProvider->name];
                                $mailProvider = new \App\Mail\ApprovedUpdatedProviderNotificationMail($mailData);
                                User::sendEmail($mailProvider, $user_email);
                            }
                        } catch(\Exception $e) {
                            Flash::error(trans('messages.something_wrong'));
                            return redirect()->back();
                        }
                    }
                    if($updateProfile->save()) {
                        Flash::success(trans('messages.profile_approved_msg'));
                        return redirect()->route('admin.partners.services');
                    }else {
                        return redirect()->back();
                    }
                }
            }
        }
        /*$mailData = [
            'slug'=> $partnerServie->slug,
            'name' => $partnerServie->name
        ];
        $mailProvider = new \App\Mail\ProviderApprovedNotificationMail($mailData);
        try {
            User::sendEmail($mailProvider, $user_email);
        } catch(\Exception $e) {
            Flash::error(trans('messages.something_wrong'));
            return redirect()->back();
        }
        if ($partnerServie->save()) {
            Flash::success(trans('messages.approvel_success'));
            return redirect()->route('admin.partners.services');
        }
        return redirect()->back()->withInput($input);*/
    }
}