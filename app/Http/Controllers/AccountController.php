<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Mail\UpdatedProviderNotificationMail;
use App\Mail\AccountDeleteMail;
use App\Models\PartnerServiceMedia;
use App\Models\PartnerServiceEquipment;
use App\Models\UserProfileUpdateHistory;
use App\Models\PartnerService;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Models\Wishlist;
use App\Models\Facility;
use App\Models\Service;
use App\Models\Partner;
use App\Models\Media;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use App\Models\Sms;
use App\Models\UserDeleteHistory;
use Carbon\Carbon;
use Session;
use Auth;
use DB;

class AccountController extends Controller
{
    //My Profile
    public function profile()
    {
        $facilities = Facility::all();
        $services   = Service::all();
        $getIdProof = getIdProof();
        $getGender = getGender();
        $getShift = getShiftType();
        $rentType = equipmentRentType();
        $states = State::all();
        $cities = City::select('id', 'name', 'state');
        $serviceInfo = array();
        $imagepath = array();
        $medias = array();
        $selectedfecility = array();
        $userInfo = Auth::user();
        $userType = $userInfo->type;
        $wishListData = $this->myWishList();
        $avatar_url = '';
        $idProofDetail = array();
        $govtApproved = PartnerService::govtApproved();
        //$cities->where('state', $userInfo->state);
        $approvalStatus = null;
        if ($userType == User::TYPE_PARTNER) {
            $partnerService = $userInfo->service;
            $approvalStatus = isset($partnerService->status) ? $partnerService->status : null;
            $avatar = isset($partnerService->getProfilePhoto) ? $partnerService->getProfilePhoto : null;
            $idproof = isset($partnerService->getIdProof) ?$partnerService->getIdProof :null;
            if (!empty($avatar)) {
                $file_name  = $avatar->source;
                $file_path  = storage_url(User::AVATAR_MEDIA_PATH_SMALL . $file_name);
                $avatar_url = asset($file_path);
            } else {
                $avatar_url = asset('images/sample-avatar.png');
            }

            if(!empty($partnerService->id_proof_media_id)) {
                $mediaId = isset($partnerService->id_proof_media_id) ? explode(',', $partnerService->id_proof_media_id) : null;
                $idProofMedia = Media::whereIn('id',$mediaId)->get();
                if (count($idProofMedia) > 0) {
                    foreach ($idProofMedia as $key => $value) {
                        $file_name  = $value->source;
                        $original = storage_url(User::ID_PROOF_MEDIA_PATH . $file_name);
                        $id_thump = storage_url(User::MY_ACCOUNT_ID_PROOF_MEDIA_SMALL . $file_name);
                        $idProofDetail[$key]['id_proof_url'] = $original;
                        $idProofDetail[$key]['id_thumb'] = $id_thump;
                        $idProofDetail[$key]['type'] = $value->type;
                    }
                }
            }
            $partnerState = isset($partnerService->state) ? $partnerService->state : null;
            $cities->where('state', $partnerState);
            $serviceInfo = $partnerService;
            $serviceId   = isset($partnerService->service_id) ? $partnerService->service_id : null;
            $service     = Service::find($serviceId);
            $serviceType = isset($service->slug) ? $service->slug : null;
            $serviceName = isset($service->name) ? $service->name : null;
            $form_name   = isset($service->form_set) ? $service->form_set : null;

            $serviceTemplate = null;
            if (isset($service->form_set) && $service->form_set) {
                $partnerController = new PartnerController();
                $serviceTemplate = $partnerController->getProviderForms($service->form_set);
            }

            // Get service related medias
            $serviceMedia = isset($serviceInfo->parnterServiceMedia) ? $serviceInfo->parnterServiceMedia :array();
            
            if (count($serviceMedia) > 0) {
                foreach ($serviceMedia as $key => $value) {
                    $filename = $value->source;
                    $medias[$key]['id'] = $value->id;
                    $medias[$key]['source'] = $filename;
                    $medias[$key]['full_source'] = storage_url(User::SERVICE_MEDIA_PATH. $filename);
                    $medias[$key]['thumb_source'] = storage_url(User::MY_ACCOUNT_SERVICE_MEDIA_SMALL. $filename);
                    $medias[$key]['type'] = $value->type;
                }
            }
            if (isset($partnerService->getServiceFacilities)) {
                $servicefacilities = $partnerService->getServiceFacilities;
                if(count($servicefacilities)) {
                    foreach ($servicefacilities as $key => $value) {
                        $selectedfecility[$value['facility_id']] = $value['facility_id']; 
                    }
                }
            }
            // Get Equipment Details
            $equipmentsDetail = array();
            $equipmentsMedia  = array();
            if (isset($partnerService->equipments)) {
                $equipments =  $partnerService->equipments;
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
                                $file_path = Storage::url(User::SERVICE_MEDIA_PATH.$value->source);
                                $equipmentsDetail[$key]['imageType'][] = $value->type;
                                $equipmentsDetail[$key]['imagePath'][] = asset($file_path);
                            }
                        }
                    }
                }
            }
        }
        if ($userType == User::TYPE_USER) {
            $userState = isset($userInfo->state) ? $userInfo->state : null;  
            $cities->where('state', $userState);
        }
        $cities = $cities->get();
        $updateApproveMessage = UserProfileUpdateHistory::where('user_id', Auth::id())->where('status', User::STATUS_PENDING)->first();
        return view('profile', compact('facilities', 'services', 'getIdProof', 'getGender', 'getShift','states', 'cities', 'userInfo', 'userType', 'avatar_url', 'wishListData', 'serviceId', 'serviceTemplate' ,'serviceInfo' , 'selectedfecility', 'medias', 
            'idProofDetail', 'serviceName', 'equipmentsDetail', 'rentType', 'approvalStatus', 'form_name', 'govtApproved', 'updateApproveMessage'));
    }

    //update profile information
    public function updateProfile(Request $request, User $user)
    {
    	$formDate  = $request->all();
    	$Validator = $this->updateValidation($formDate);
    	if ($Validator->fails()) {
    		return response()->json([
	            'success' => false,
	            'message' => trans('messages.incorrect_form_values'),
	            'errors' => $Validator->getMessageBag()->toArray()
	        ]);
    	}
    	$user = Auth::user();
        /* Old password Check*/
        if ($request->old_password) {
            $errors = ['old_password'=>array(trans('messages.old_password_error_message'))];
            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => trans('messages.incorrect_form_values'),
                    'errors'  => $errors
                ]);
            }
        }
    	//Update the user data
    	try {
            if ($request->new_password != null) {
                $user->password = Hash::make($request->new_password);
            }
    		if ($user->type == User::TYPE_USER) {
    			$user->first_name = $request->first_name;
    			$user->last_name  = $request->last_name;	
	    		$user->email = $request->email;
	    		$user->mobile_number = $request->mobile_number;
                $user->state = $request->state;
                $user->city = $request->city;
                $user->postal_code = $request->postal_code;
	    		$userUpdate = $user->save();
    		}else {
                $avatar = $user->service->getProfilePhoto;
                if ($request->profile_avatar) {
                    $filename    = $request->profile_avatar;
                    $mediaTitle  = pathinfo($filename->getClientOriginalName(),PATHINFO_FILENAME);
                    $mediaType   = getFileType($filename);
                    $image_name  = getRandomFileName($filename);
                    $storageDir  = User::AVATAR_MEDIA_PATH;
                    $compress    = $mediaType == 'image' ? true : false;
                    $imageUpload = User::uploadFile($filename, $image_name, $storageDir, $compress);
                    if(!empty($avatar)) {
                        $oldimageName = $avatar->source;
                        $avatar->title  = $mediaTitle;
                        $avatar->type   = $mediaType;
                        $avatar->source = $image_name;
                        Storage::delete($storageDir.$oldimageName);
                    }else{
                        $media = Media::create([
                            'title' => $mediaTitle, 
                            'type'  => $mediaType, 
                            'source'=> $image_name, 
                        ]);
                        $user->service->profile_photo_id = $media->id;
                    }
                }
    			$user->email = $request->email;
	    		$user->mobile_number = $request->mobile_number;
	    		$userUpdate = $user->push();
    		}
    		if ($userUpdate) {
    			return response()->json([
                    'success' => true,
                    'message' => trans('messages.myaccount_update'),
                    'data'    => $formDate,
                    'redirect_url' => '',
                ]);
    		}else{
    			return response()->json([
	                'success' => false,
	                'message' => trans('messages.create_failed'),
	                'redirect_url' => '',
	            ]);
    		}
    	} catch (\Exception $e){
    		return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
    	}
    }

    // Update All Services
    public function serviceUpdate(Request $request)
    {
        $partnerCtrl = new PartnerController;
        $available_facility = array();
        $data = $request->all();
        $user = Auth::user();
        $service = $user->service;
        $service_type = $service->service;
        if (!$service_type) {
            return response()->json([
                'success' => false,
                'message' => trans('messages.incorrect_form_values'),
                'errors' => []
            ]);
        }
        $form_set = $service_type->form_set;

        $validator = $this->serviceUpdateValidation($data, $form_set);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => trans('messages.incorrect_form_values'),
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }
        if ($form_set == Service::FORM_SET_3) {
            $available_facility = $request->facilities_available ? array_filter($request->facilities_available) : array();
            if(count($available_facility) == 0) {
                $errors = ['facilities_available' => array(trans('auth.facilities_select'))];
                return response()->json([
                    'success' => false,
                    'message' => trans('messages.incorrect_form_values'),
                    'errors' => $errors
                ]);
            }
        }
        if ($service->status == User::STATUS_ACTIVE) {
            $providerUpdatedData = $this->providerUpdateHistory($request, $service);
            if ($providerUpdatedData) {
                $updateHistory = UserProfileUpdateHistory::where('user_id', Auth::id())->where('status', User::STATUS_PENDING)->first();
                if ($updateHistory) {
                    $updateHistory->update_values = $providerUpdatedData;
                    $updateHistory->save();
                    $historyId = $updateHistory->id;
                } else {
                    $saveHistory = UserProfileUpdateHistory::create([
                        'user_id' => Auth::id(),
                        'update_values' => $providerUpdatedData,
                        'status' => User::STATUS_PENDING,
                    ]);
                    $historyId = $saveHistory->id;
                }
                $sendMail = $this->providerUpdatedNotification($service, $request, $historyId);
                $data = json_decode($providerUpdatedData);
                if ($historyId) {
                    Session::flash('profile_updated', trans('messages.provider_updated_approval_message'));
                    return response()->json([
                        'success' => true,
                        'provider_update' => true,
                        'message' => trans('messages.provider_updated_approval_message'),
                        'data'    => $data,
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => trans('messages.create_failed'),
                    ]);
                }
            }
        }
        
        if ($request->all()) {
            //Common fields values
            $service->contact_phone = $request->contact_phone;
            $service->name = $request->name;
            $service->city = $request->city;
            $service->state = $request->state;
            $service->postal_code = $request->pin_code;
            $service->additional_info = $request->add_info;
            try {
                switch ($form_set) {
                    case Service::FORM_SET_1:
                        $service->gender = $request->gender;
                        $service->dob = null;
                        if (isset($request->date_of_birth) && !empty($request->date_of_birth)) {
                            $service->dob = date('Y-m-d',strtotime($request->date_of_birth));
                        }
                        $service->contact_email = $request->email;
                        $service->id_proof = $request->id_proof;
                        $service->qualification = $request->qualification;
                        $service->total_experience = $request->year_of_exp;
                        $service->specialization_area = $request->area_of_specialization;
                        $service->registration_number = $request->reg_no_or_licence_no;
                        $service->working_at = $request->currently_working_at;
                        if ($request->fees_type == User::PER_SHIFT) {
                            $service->fees_per_shift = $request->fees;
                            $service->fees_per_day = null;
                        } elseif($request->fees_type == User::PER_DAY) {
                            $service->fees_per_day  = $request->fees;
                            $service->fees_per_shift = null;
                        }
                        //$idproof = $service->getIdProof;
                        $upload_id_proof = $request->upload_id_proof ? array_filter($request->upload_id_proof) :null;   
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
                            $this->serviceFileUpload($labImages, $service);
                        }
                        break;

                    case Service::FORM_SET_3:
                        $service->govt_approved = $request->govt_approved;
                        $service->registration_number = $request->old_age_home_reg_no;
                        $service->contact_person = $request->contact_person;
                        $service->no_of_rooms = $request->number_of_rooms;
                        $service->room_rent = $request->room_rent;
                        $service->other_facilities = $request->other_facilities_available;
                        $service->landline_number = $request->landline_number;
                        $service->address = $request->old_home_address;
                        $service->website_link = $request->website_link;
                        $facilities  = $available_facility;
                        $homePhoto = $request->home_avatar ? array_filter($request->home_avatar) :null;
                        if ($homePhoto) {
                            $this->serviceFileUpload($homePhoto, $service);
                        }
                        $service->serviceFacilities()->sync($facilities);
                        break;

                    case Service::FORM_SET_4:
                        $no_equipment = $request->equpment_count;
                        $service->registration_number = $request->reg_no_or_licence_no;
                        $service->contact_person = $request->contact_person;
                        $service->address = $request->medical_address;
                        $service->landline_number = $request->landline_number;
                        $service->website_link = $request->website_link;
                        $medical_photos = $request->medical_profile_photo ? array_filter($request->medical_profile_photo) :null;
                        if ($medical_photos) {
                            $this->serviceFileUpload($medical_photos, $service);
                        }
                        break;

                    case Service::FORM_SET_5:
                        $service->registration_number = $request->reg_no_or_licence_no;
                        $service->contact_person = $request->contact_person;
                        $service->contact_email = $request->contact_email;
                        $service->address = $request->address;
                        $service->landline_number = $request->landline_number;
                        $service->website_link = $request->website_link;
                        $service->services_provided = $request->service_provider;
                        $hocareImage = $request->care_home_photo ? array_filter($request->care_home_photo) : null;
                        if ($hocareImage) {
                            $this->serviceFileUpload($hocareImage, $service);
                        }
                        break;

                    case Service::FORM_SET_6:
                        $service->project_name = $request->project_name;
                        $service->contact_person = $request->contact_person;
                        $service->contact_email = $request->contact_email;
                        $service->landline_number = $request->landline_number;
                        $service->website_link = $request->website_link;
                        $retimentHome = $request->retire_home_photo ? array_filter($request->retire_home_photo) : null;
                        if ($retimentHome) {
                            $this->serviceFileUpload($retimentHome, $service);
                        }
                        break;

                    default:                    
                        break;
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => trans('messages.something_wrong'),
                ]);
            }
            // Service update
            if ($service->push()) {
                //Session::flash('profile_updated', trans('messages.service_update'));
                return response()->json([
                    'success' => true,
                    'message' => trans('messages.service_update'),
                    'data'    => $service,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => trans('messages.create_failed'),
                ]);
            }
        }
    }

    //Service porovider update validation
    public function serviceUpdateValidation(array $data, $form_set)
    {
        // Common fields
        $rules = array();
        $messages = array();
        $rules['name']='required|regex:'.config('app.name_validation');
        $rules['contact_phone']='required|numeric|digits:10';
        $rules['state'] = 'required';
        $rules['city'] = 'required';
        $rules['pin_code'] = 'required|numeric|digits:6';

        $age_before = Carbon::now()->subYears(config('app.age_limit'))->format('Y-m-d');
        
        switch ($form_set) {
            case Service::FORM_SET_1:
                $rules['gender']='required';
                $rules['date_of_birth'] ='required|date_format:d-m-Y|before:' . $age_before;
                $rules['id_proof'] ='required';
                $rules['qualification'] ='required';
                $rules['year_of_exp'] ='required';
                $rules['area_of_specialization'] ='required';
                $rules['reg_no_or_licence_no'] ='required';

                $messages = [
                    'date_of_birth.before' => 'You must be at least 13 years old',
                    'date_of_birth.date_format' => 'Date of birth format should be DD-MM-YYYY',
                ];

                break;

            case Service::FORM_SET_2:
                $rules['reg_no_or_licence_no'] ='required';
                $rules['contact_person'] ='required';
                $rules['form_two_landline_number'] = 'nullable|regex:'.config('app.landline_validation');
                $messages = [
                    'form_two_landline_number.numeric' => 'Landline number be a numbers and space',
                ];

                break;

            case Service::FORM_SET_4:
                $rules['reg_no_or_licence_no'] ='required';
                $rules['contact_person'] ='required';
                $rules['landline_number'] ='nullable|regex:'.config('app.landline_validation');
                break;

            case Service::FORM_SET_3:
                $rules['govt_approved'] = 'required';
                $rules['old_age_home_reg_no'] = 'required_if:govt_approved,1';
                $rules['contact_person'] ='required';
                $rules['number_of_rooms'] ='required';
                $rules['landline_number'] ='nullable|regex:'.config('app.landline_validation');
                $rules['facilities_available'] ='required';
                $rules['room_rent'] ='nullable|regex:/^\d+(\.\d{1,2})?$/';
                $messages = [
                    'old_age_home_reg_no.required_if' => 'Registration number is required.',
                ];

                break;

            case Service::FORM_SET_5:
                $rules['reg_no_or_licence_no'] ='required';
                $rules['contact_person'] ='required';
                $rules['landline_number'] ='nullable|regex:'.config('app.landline_validation');
                $rules['address'] = 'required';
                break;

            case Service::FORM_SET_6:
                $rules['project_name'] ='required';
                $rules['contact_person'] ='required';
                $rules['landline_number'] ='nullable|regex:'.config('app.landline_validation');
                break;            

            default:
                break;
        }
        return Validator::make($data, $rules, $messages);
    }

    // Mupltiple file uploade with Existing remove
    public function serviceFileUpload($serviceImages, $updateObj, $update_history = false)
    {
        $storageDir  = User::SERVICE_MEDIA_PATH;
        $mediaId = array();
        if (count($serviceImages) > 0 ) {
            if (count($updateObj->partnerMedia) > 0) {
                foreach ($updateObj->partnerMedia as $key => $value) {
                    $oldimageName = $updateObj->partnerMedia[$key]->serviceMedias->source;
                    $mediaId[]    = $updateObj->partnerMedia[$key]->serviceMedias->id;
                    /*Storage::delete($storageDir.$oldimageName);
                    if($mediaId){
                        Media::find($mediaId)->delete();
                    }*/
                }
                //$updateObj->serviceMedia()->detach();
            }
            
            
            foreach ($serviceImages as $key => $value) {
                $filename    = $value;
                $mediaTitle  = pathinfo($filename->getClientOriginalName(),PATHINFO_FILENAME);
                $mediaType   = getFileType($filename);
                $image_name  = getRandomFileName($filename);
                $compress    = $mediaType == 'image' ? true : false;
                $imageUpload = User::uploadFile($filename, $image_name, $storageDir, $compress);
                $media = Media::create([
                    'title' => $mediaTitle, 
                    'type'  => $mediaType, 
                    'source'=> $image_name, 
                ]);
                $mediaId[]  = $media->id;
            }
            if ($update_history) {
                return $mediaId;
            }
            //Sync to image partnerHomeMediatable
            $updateObj->serviceMedia()->sync($mediaId);
        }
    }

    //user profile form updation
    protected function updateValidation(array $data) 
    {
        if ($data['user_type'] == User::TYPE_USER) {
            $rules = [
                'first_name'=>'required|max:32',
                /*'last_name'=>'required|max:32',*/
                'mobile_number' => 'required|numeric|digits:10|unique:users,mobile_number,'.$data['user_id'],
                'email'=> 'required|email|max:255|unique:users,email,'.$data['user_id'],
                'state'=> 'required',
                'city' => 'required',
                'postal_code'=>'required|numeric|digits:6',
            ];
        } else {
            $rules = [
                'mobile_number' => 'required|numeric|digits:10|unique:users,mobile_number,'.$data['user_id'],
                'email'=> 'required|email|max:255|unique:users,email,'.$data['user_id'],
                'profile_avatar'=> 'nullable|mimes:jpeg,jpg,png|max:500000',
            ];
        }
        if($data['old_password']){
            $rules['old_password'] = 'min:6';
            $rules['new_password'] = 'min:6';
        }
        $messages = [
            'mobile_number.unique' => 'Mobile Number already registered with us.',
            'email.unique' => 'Email already registered with us.',
        ];
        return Validator::make($data, $rules, $messages);
    }

    //My wish list Datas
    public function myWishList()
    {
        $getCity = new SearchController();
        $wish_list = array();
        $currentDate = date('Y-m-d');
        $wishListArray = array();
        $featureList   = $getCity->getFeatureList($currentDate);
        $services = DB::table('partner_services as ps')
                    ->select('ps.*', $featureList, 'wl.id as wish_list_id', 'wl.content_id', 'm.title','m.type as media_type','m.source')
                    ->leftJoin('partner_service_media as psm', 'psm.partner_service_id', '=', 'ps.id')
                    ->leftJoin('media as m', 'm.id', '=', 'ps.profile_photo_id')
                    ->leftJoin('wishlists as wl', 'wl.content_id', '=', 'ps.id')
                    ->where('wl.user_id', Auth::id())
                    ->where('ps.status', User::STATUS_ACTIVE)
                    ->where('wl.content_type', User::TYPE_SERVICE)
                    ->groupBy('wl.content_id')
                    ->get();
        if (count($services) > 0 ) {
            foreach ($services as $key => $value) {
                $wishListArray[$key]['id']= $value->id;
                $wishListArray[$key]['slug']= $value->slug;
                $wishListArray[$key]['name']      = $value->name;
                $wishListArray[$key]['sub_title'] = null;
                $wishListArray[$key]['additional_info'] = $value->additional_info;
                $wishListArray[$key]['content_id']   = $value->content_id;
                $wishListArray[$key]['content_type'] = User::TYPE_SERVICE;
                $wishListArray[$key]['wish_list_id'] = $value->wish_list_id;
                $wishListArray[$key]['city']  = $value->city;
                $wishListArray[$key]['state'] = $getCity->getStateDeatil($value->state);
                $wishListArray[$key]['contact_no'] = $value->contact_phone;
                $wishListArray[$key]['feature_list'] = $value->feature_list;
                $wishListArray[$key]['verified'] = $value->verified;
                if (!empty($value->media_type) && $value->media_type !='file') {
                    $file_path = storage_url(User::AVATAR_MEDIA_PATH_SMALL . $value->source);
                    $wishListArray[$key]['imagePath'] = asset($file_path);
                } else if(empty($value->media_type)) {
                   $wishListArray[$key]['imagePath'] = asset('images/sample-avatar.png'); 
                }
            }
        }
        return $wishListArray;
    }

    //home service Details
    public function getByHomeService(Request $request, $type, $slug)
    {
        $serviceInfo  = '';
        //$partnerSrvice = PartnerService::find($id);
        //$partnerSrvice = PartnerService::where('slug', 'LIKE', "%{$slug}%")->first();
        $partnerSrvice = PartnerService::where('slug', $slug)->first();
        $id = $partnerSrvice->id;
        $serviceInfo  = $partnerSrvice;
        $serviceDetails = $partnerSrvice->service;
        $providerStatus = $serviceDetails ? $serviceDetails->status : null;
        if ($partnerSrvice->status == User::STATUS_PENDING || $providerStatus == Service::STATUS_INACTIVE) {
            return redirect()->route('home');
        }
        $services     = Service::all();
        $mediaInfo    = array();
        $bannerImage  = array();
        $selectedfecility = array();
        
        $facilities_list = Facility::all();
        $availableFacility= array();
        $facilityName     = array();
        $getRatingDetail  = array();
        $states = State::all();
        $cities = City::all();
        $serviceTypeName = $serviceDetails->slug;
        $defaultBanner   = $serviceDetails->banner;
        $form_set = $serviceDetails->form_set;

        $stateName = isset($serviceInfo->states->name) ? $serviceInfo->states->name : null;
        // This Rating  get all indidual user based
        $getAllRating = $serviceInfo->getAllRatings($serviceInfo->id, User::TYPE_SERVICE);
        // This Rating Avarage all user total rating and averaged by provider id
        $getAverage   = $serviceInfo->averageRatingByType($serviceInfo->id, User::TYPE_SERVICE);
        $serviceName  = Service::select('name')->where('id', $serviceInfo->service_id)->first();
        $serviceMedia = isset($serviceInfo->parnterServiceMedia) ? $serviceInfo->parnterServiceMedia : null;
        
        if (count($serviceMedia) > 0) {
            foreach ($serviceMedia as $key => $value) {
                $imagePath = '';
                if (!empty($serviceMedia[$key]->type) && $serviceMedia[$key]->type !='file') {
                    $imagePath = storage_url(User::SERVICE_MEDIA_PATH.$serviceMedia[$key]->source);
                    $thumpPath = storage_url(User::SERVICE_MEDIA_PATH_SMALL.$serviceMedia[$key]->source);
                }
                $mediaInfo[$key]['title']   = $serviceMedia[$key]->title;
                $mediaInfo[$key]['img_url'] = $imagePath;
                $mediaInfo[$key]['image_thump'] = $thumpPath;
                $mediaInfo[$key]['type'] =  null; 
            }
        }

        // Default panner only show
        $bannerImagePath = storage_url(User::BANNER_MEDIA_PATH_LARGE . $defaultBanner);
        $bannerImage[0]['title'] = $serviceTypeName;
        $bannerImage[0]['img_url'] = $bannerImagePath;
        $bannerImage[0]['type'] =  User::BANNER_TYPE;

        $bookmarked = $this->getBywishlist($serviceInfo->id, User::TYPE_SERVICE);
        if (count($getAllRating) > 0){
            foreach ($getAllRating as $key => $value) {
                $user = User::find($value->author_id);
                if ($user) {
                    $userName = $user->first_name ? $user->first_name : $user->service['name'];
                    $getRatingDetail[$key]['title'] = $value->title;
                    $getRatingDetail[$key]['comments'] = $value->body;
                    $getRatingDetail[$key]['rating']  = $value->rating;
                    $getRatingDetail[$key]['user_name'] = $userName;
                    $getRatingDetail[$key]['created_at'] = $value->created_at->diffForHumans();
                }
            }
        }

        if (isset($serviceInfo->getServiceFacilities)) {
            $servicefacilities = $serviceInfo->getServiceFacilities;
            if(count($servicefacilities)) {
                foreach ($servicefacilities as $key => $value) {
                    $selectedfecility[$value['facility_id']] = $value['facility_id'];
                    $availableFacility[] = $value['facility_id']; 
                }
            }
        }
        $idproof = $serviceInfo->getIdProof;
        $idProofPath = '';
        if (!empty($idproof)) {
            $file_name  = $idproof->source;
            $idProofPath = storage_url(User::ID_PROOF_MEDIA_PATH . $file_name);
        }

        $avatar = isset($serviceInfo->getProfilePhoto) ? $serviceInfo->getProfilePhoto : null;
        $avatar_url = null;
        $avatar_thumb = null;
        if (!empty($avatar)) {
            $file_name  = $avatar->source;
            $avatar_thumb = storage_url(User::AVATAR_MEDIA_DETAIL_PAGE . $file_name);
            $avatar_url = storage_url(User::AVATAR_MEDIA_PATH . $file_name);
        }

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
                            $equipmentsDetail[$key]['imagePathThumb'][] = storage_url(User::SERVICE_MEDIA_PATH_SMALL . $value->source);
                            $equipmentsDetail[$key]['imagePath'][] = storage_url(User::SERVICE_MEDIA_PATH . $value->source);
                        }
                    }
                }
            }
        }
        
        $equiptmentImageCount = null;
        if(count($equipmentsDetail) > 0) {
            $imageArray = array();
            foreach ($equipmentsDetail as $key => $value) {
                $totalImage = isset($value['imagePath']) ? $value['imagePath']: array();
                $imageArray[] = count($totalImage);
            }
            $equiptmentImageCount = array_sum($imageArray);
        }

        $facilityName = Facility::select('name')->whereIn('id',$availableFacility)->get();
        return view('home-service', compact('id', 'slug', 'mediaInfo', 'serviceInfo', 'facilities_list', 'selectedfecility', 'services', 'serviceInfo', 'type', 'facilityName', 'serviceName', 'bookmarked', 'states', 'cities', 'getRatingDetail', 'getAverage', 'serviceTypeName', 'stateName', 'idProofPath', 'equipmentsDetail', 'avatar_url', 'form_set', 'bannerImage', 'avatar_thumb', 'equiptmentImageCount'));
    }

    // Get wishlist detail by id
    public function getBywishlist($contet_id,$content_type)
    {
        $getBywishlist = array();
        if (Auth::check()) {
            $getBookmark = Wishlist::where('user_id',Auth::id())
                            ->where('content_id', $contet_id)
                            ->where('content_type', $content_type)->first();
            if ($getBookmark) {
                $getBywishlist = [
                    'content_id'=> $getBookmark->content_id,
                    'content_type'=>$getBookmark->content_type
                ];
            }
        }
        return $getBywishlist;
    }

    //Equipment Store
    public function equipmentStore(Request $request)
    {
        $partnerCtrl = new PartnerController;
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

    // Equipment List
    public function equipmentList()
    {
        $partnerService = Auth::user()->service;
        $equipmentsDetail = array();
        $equipmentsMedia  = array();
        if (isset($partnerService->equipments)) {
            $equipments =  $partnerService->equipments;
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
                            $file_path = Storage::url(User::SERVICE_MEDIA_PATH.$value->source);
                            $equipmentsDetail[$key]['imageType'][] = $value->type;
                            $equipmentsDetail[$key]['imagePath'][] = asset($file_path);
                        }
                    }
                }
            }
        }
        return view('partials.equipment-list', compact('equipmentsDetail'));
    }

    // Get Equipment detail By id
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
                $equipmentsmedias[$key]['imagePath'] = storage_url(User::SERVICE_MEDIA_PATH . $value->source);
                $equipmentsmedias[$key]['imageThumbPath'] = storage_url(User::SERVICE_MEDIA_PATH_THUMB . $value->source);
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
        $partnerCtrl = new PartnerController;
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

    //Equipment photo Delete option
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

    //Mobile Number Change
    public function mobileNoChange(Request $request)
    {
        $formData = $request->all();
        $rules = ['change_mobile_no' => 'required|numeric|digits:10|unique:users,mobile_number',];
        $messages = ['change_mobile_no.unique' => 'Mobile Number already registered with us.',];
        $validator = Validator::make($formData, $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => trans('messages.incorrect_form_values'),
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        } else {
                $providerDetails = [
                    'mobile_number' => $request->change_mobile_no,
                    'tries_limit'=> 1,
                ];
                session::put('provider_details', $providerDetails);
                Session::put('mobile_number', $request->change_mobile_no);
                $messageString   = trans('messages.mobile_verification_otp_msg');
                $sendOtpResponse = User::sendOtp($request->change_mobile_no, $messageString, true);
                return response()->json($sendOtpResponse);
        }
    }

    public function chagePhoneOtpVerify(Request $request)
    {
        $authUserMobile = $request->mobile_number;
        $data   = $request->all();
        $getOtpDetail = Sms::where('mobile_number', $authUserMobile)->where('user_id', Auth::id())
                        ->where(['verify_status' => 0])->first();
        $userData     = User::find(Auth::id());
        $getOtp       = $getOtpDetail->otp_number;
        $providerData = Session::get('provider_details');
        if ($getOtp == $data['otp_number']) {
            $getOtpDetail->verify_status = 1;
            $getOtpDetail->save();
            $providerData = Session::get('provider_details');
            if ($providerData) {
                Session::forget('provider_details');
                $userData->mobile_number = $authUserMobile;
                $userData->save();
                return response()->json([
                    'success' => true,
                    'message' => trans('messages.phone_change_success'),
                    'data'    => $userData,
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => trans('messages.invalid_otp'),
            ]);
        }
    }

    // My Service photos Delete 
    public function providerPhotoDelete(Request $request)
    {
        if (Auth::check()) {
            $userInfo = Auth::user();
            $partnerService = $userInfo->service;
            $mediaInfo = isset($partnerService->parnterServiceMedia) ? $partnerService->parnterServiceMedia : array();
            $mediaCount = count($mediaInfo);
            $mediaId = $request->media_id;
            $media = Media::find($mediaId);
            $storageDir  = User::SERVICE_MEDIA_PATH;
            if ($media) {
                $imageName  = $media->source;
                Storage::delete($storageDir . $imageName);
                if ($media->delete()) {
                    return response()->json([
                        'success' => true,
                        'data' => $media,
                        'media_count' => $mediaCount,
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
                'message' => trans('messages.does_not_match_user'),
            ]);
        }
    }

    // Account Delete Email
    public function accountDeleteEmail(Request $request)
    {
        $data = $request->all();
        $redirectUrl = route('account.delete.otp.verify');
        $rules = ['reason' => 'required'];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => trans('messages.incorrect_form_values'),
                'errors' => $validator->getMessageBag()->toArray()
            ]); 
        }
        $user = User::find(Auth::id());
        if ($user->email) {
            $accountDetail = [
                'user_id' => $user->id,
                'email' => $user->email,
                'mobile_number'=> $user->mobile_number,
                'reason' => $request->reason,
            ];
            try {
                $otp_code = mt_rand(100000,999999);
                $mailData = ['code'=> $otp_code, 'name'=> $user->first_name];
                $mail_class = new AccountDeleteMail($mailData);
                $deleteHistory = UserDeleteHistory::where('user_id', $user->id)->first();
                if ($deleteHistory) {
                    $deleteHistory->email = $user->email;
                    $deleteHistory->mobile_number = $user->mobile_number;
                    $deleteHistory->reason = $request->reason;
                    $accountDelete = $deleteHistory->save();
                } else {
                    $accountDelete = UserDeleteHistory::create($accountDetail);
                }
                $checkOtp = Sms::where('user_id', $user->id)->where('email', $user->email)->where('verify_status', User::STATUS_INACTIVE)->first();
                if ($checkOtp) {
                    $checkOtp->otp_number =  $otp_code;
                    $checkOtp->mobile_number =  $user->mobile_number;
                    $sendOtp = $checkOtp->save();
                } else {
                    $sendOtp = Sms::create([
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'mobile_number' => $user->mobile_number,
                        'otp_number' => $otp_code
                    ]);
                }
                $sendEmail = User::sendEmail($mail_class, $user->email);
                if ($accountDelete && $sendOtp) {
                    return response()->json([
                        'success' => true,
                        'message' => trans('messages.send_otp_email_msg'),
                        'data' => $accountDelete,
                        'redirect_url'=> $redirectUrl,
                        'via_email' => true,
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
                    'message' => trans('messages.something_wrong'),//$e->getMessage(),
                ]);
            }
        } else {
           return response()->json([
                'success' => false,
                'message' => trans('messages.email_empty'),
            ]);  
        }
    }

    // Delete Account OTP Verification
    public function accountDeleteOtpVerify(Request $request)
    {
        $email = Auth::user()->email;
        $user_id = Auth::id();
        $data = $request->all();
        if ($request->all()) {
            $email = $request->email;
            $data   = $request->all();
            $getOtp = Sms::where('user_id', Auth::id())->where(['verify_status' => 0])->where('email', $email)->first();
            $otp = isset($getOtp->otp_number) ? $getOtp->otp_number : null;
            if ($otp == $data['otp_number']) {
                $getOtp->verify_status = User::STATUS_ACTIVE;
                $getOtp->save();
                Session::put('account_delete_verification', $getOtp);
                return response()->json([
                    'success' => true,
                    'message' => trans('messages.valid_otp'),
                    'data'    => $data,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => trans('messages.invalid_otp'),
                ]);
            }
        }
        return view('partials.account-delete-otp', compact('email', 'user_id'));
    }

    public function accountDelete(Request $request)
    {
        $accountDeleteVerication = Session::get("account_delete_verification");
        if ($accountDeleteVerication) {
            $redirectUrl = route('home');
            if ( $accountDeleteVerication['user_id'] == Auth::id()) {
                if ($accountDeleteVerication['verify_status'] == User::VERIFIED) {
                    Session::forget('account_delete_verification');
                    if (Auth::user()->delete()) {
                        return response()->json([
                            'success' => true,
                            'message' => trans('messages.account_delete_success'),
                            'redirect_url'=> $redirectUrl,
                        ]);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => trans('messages.account_deleted_faild'),
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => trans('messages.account_delete_verification'),
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => trans('messages.does_not_match_user'),
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => trans('messages.something_wrong'),
            ]);
        }
    }

    // Profile update history record
    public function providerUpdateHistory($request, $serviceObj)
    {
        $partnerCtrl = new PartnerController;
        $formData = array();
        $formData['user_id'] = Auth::id();
        $formData['contact_phone'] = $request->contact_phone ?? null;
        $formData['name'] = $request->name ?? null;
        $formData['city'] = $request->city ?? null;
        $formData['state'] = $request->state ?? null;
        $formData['postal_code'] = $request->pin_code ?? null;
        $formData['additional_info'] = $request->add_info ?? null;
        $formData['gender'] = $request->gender ?? null;
        $formData['dob'] = null;
        $formData['contact_person'] = $request->contact_person ?? null;
        $formData['website_link'] = $request->website_link ?? null;
        $formData['govt_approved'] = $request->govt_approved ?? null;    
        $formData['no_of_rooms'] = $request->number_of_rooms ?? null;
        $formData['room_rent'] = $request->room_rent ?? null;
        $formData['other_facilities'] = $request->other_facilities_available ?? null;
        $formData['available_facilities'] = $request->facilities_available ? array_filter($request->facilities_available) : array();
        $formData['tests_provided'] = $request->list_of_provided ?? null;
        $formData['services_provided'] = $request->service_provider ?? null;
        $formData['project_name'] = $request->project_name ?? null;
        $formData['id_proof'] = $request->id_proof ?? null;
        $formData['qualification'] = $request->qualification ?? null;
        $formData['total_experience'] = $request->year_of_exp ?? null;
        $formData['specialization_area'] = $request->area_of_specialization ?? null;
        $formData['working_at'] = $request->currently_working_at ?? null;
        $formData['fees_type'] = $request->fees_type ?? null;
        $formData['fees'] = $request->fees ?? null;
        if (isset($request->date_of_birth) && !empty($request->date_of_birth)) {
            $formData['dob'] = date('Y-m-d',strtotime($request->date_of_birth));
        }
        if(isset($request->email) && $request->email) {
            $formData['contact_email'] = $request->email ?? null;
        }else {
            $formData['contact_email'] = $request->contact_email ?? null;
        }
        if(isset($request->form_two_landline_number) && $request->form_two_landline_number) {
            $formData['landline_number'] = $request->form_two_landline_number ?? null;
        } else {
            $formData['landline_number'] = $request->landline_number ?? null ;
        }
        if(isset($request->old_age_home_reg_no) && $request->old_age_home_reg_no) {
            $formData['registration_number'] = $request->old_age_home_reg_no;
        } else {
            $formData['registration_number'] = $request->reg_no_or_licence_no ?? null;
        }
        if(isset($request->lab_address) && $request->lab_address) {
            $formData['address'] = $request->lab_address;
        } else if(isset($request->old_home_address) && $request->old_home_address) {
            $formData['address'] = $request->old_home_address;
        } else if(isset($request->medical_address) && $request->medical_address) {
            $formData['address'] = $request->medical_address;
        } else{
             $formData['address'] = $request->address ?? null;
        }
        $upload_id_proof = $request->upload_id_proof ? array_filter($request->upload_id_proof) :null;   
        if (!empty($upload_id_proof)){
            $id_proofId = $partnerCtrl->multiFileUpload($upload_id_proof, false);
            $formData['id_proof_media_id'] = implode(',', $id_proofId);
        }
        $labImages  = $request->lab_pharmacy_photo ? array_filter($request->lab_pharmacy_photo) : null;
        if (!empty($labImages)) {
            $lapMediaId = $this->serviceFileUpload($labImages, $serviceObj, true);
            $formData['media_id'] = $lapMediaId;   
        }
        $homeImages  = $request->home_avatar ? array_filter($request->home_avatar) : null;
        if (!empty($homeImages)) {
            $homeMediaId = $this->serviceFileUpload($homeImages, $serviceObj, true);
            $formData['media_id'] = $homeMediaId;
        }
        // Service creation and media sync to service media table
        $medicalImages = $request->medical_profile_photo ? array_filter($request->medical_profile_photo) : null;
        if (!empty($medicalImages)) {
            $medicalMediaId = $this->serviceFileUpload($medicalImages, $serviceObj, true);
            $formData['media_id'] = $medicalMediaId;
        } 
        $careHomeImages = $request->care_home_photo ? array_filter($request->care_home_photo) : null;
        if(!empty($careHomeImages)) {
            $careHomeMediaId = $this->serviceFileUpload($careHomeImages, $serviceObj, true);
            $formData['media_id'] = $careHomeMediaId;
        }
        $retireHomeImages = $request->retire_home_photo ? array_filter($request->retire_home_photo) : null;
        if ($retireHomeImages) {
            $retHomeMediaId = $this->serviceFileUpload($retireHomeImages, $serviceObj, true);
            $formData['media_id'] = $retHomeMediaId;
        }
        return json_encode($formData);
    }

    public function providerUpdatedNotification($serviceObj, $request, $updated_history_id)
    {
        $toEmail = env('NEW_PROVIDER_NOTIFICATION_EMAILS');
        $fees_type = null;
        $fees_amount = null;
        if(isset($request->fees_per_shift) && !empty($request->fees_per_shift)) {
            $fees_type = App\Models\PartnerService::FEE_PER_SHIFT;
            $fees_amount = $request->fees_per_shift;
        } else if (isset($request->fees_per_day) && !empty($request->fees_per_day)) {
            $fees_type = App\Models\PartnerService::FEE_PER_DAY;
            $fees_amount = $request->fees_per_day;
        }
        $state_code = $request->state ?? null;
        $state = State::where('code', $state_code)->first();
        $stateName = isset($state->name) ? $state->name : null;
        $token = generateToken($updated_history_id);
        $mailData = [
           'id'=> $serviceObj->id,
           'user_id'=> Auth::id(),
           'name' => $request->name,
           'type' => $serviceObj->serviceType->name,
           'city' => $request->city,
           'state' => $stateName,
           'pin_code' => $request->pin_code,
           'id_proof'=> ucfirst(str_replace('_', ' ', $request->id_proof)),
           'area_of_spl' => $request->area_of_specialization,
           'fees_type' => $fees_type,
           'fees_amount' => $fees_amount,
           'room_rent' => $request->room_rent,
           'token' => $token,
        ];

        $updateProvider = new UpdatedProviderNotificationMail($mailData);
        $sendEmail = User::sendEmail($updateProvider, $toEmail);
        return  $sendEmail;
    }
}
