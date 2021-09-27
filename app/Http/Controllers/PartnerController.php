<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Mail\NewProviderNotificationMail;
use App\Mail\EmailVerificationMail;
use App\Models\PartnerServiceEquipment;
use App\Models\PartnerHomeFacility;
use App\Models\PartnerServiceMedia;
use App\Models\PartnerHomeMedia;
use App\Models\PartnerService;
use App\Models\PartnerHome;
use App\Models\Facility;
use App\Models\Partner;
use App\Models\Service;
use App\Models\Media;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use App\Models\Sms;
use Carbon\Carbon;
use Session;
use Mail;

class PartnerController extends Controller
{

    //partner service and home information stored
    public function partnerRegisterType(Request $request, $type) 
    {
        $userType = Auth::user()->type;
        if ($userType == User::TYPE_USER) {
            return redirect()->route('home');
        }
        $year_of_paasing = getYearOfPassing();
        $shifts          = getShiftTimings();
        $form_data       = $request->all();
        $seriveName      = Service::all();
        $facilities_list = Facility::all();
        if ($form_data) {
            $redirectTo  = route('profile.edit');
        	// partner service section
        	if ($type == Partner::TYPE_SERVICE) {
        		$validator = $this->serviceValidation($form_data);
	            if ($validator->fails()) {
	            	return $this->formvaliationErrors($validator);
	            }
	            try {
	                $partner_service_data = $this->partnerServiceCreate($request);
	                if ($partner_service_data) {
	                    return response()->json([
	                        'success' => true,
	                        'message' => trans('messages.partner_service_success'),
	                        'data'    => $partner_service_data,
                            'redirect_url'=>$redirectTo,
	                    ]);
	                } else {
	                    return response()->json([
	                        'success' => false,
	                        'message' => trans('messages.create_failed'),
	                    ]);
	                }
	            } catch (\Exception $e) {
	                return response()->json([
	                    'success' => false,
	                    'message' => $e->getMessage(),
	                ]);
	            }
        	} else {
        		// partner home data save section
        		$validator = $this->homeValidation($form_data);
        		if ($validator->fails()) {
        			return $this->formvaliationErrors($validator);
        		}
        		try {
        			$partner_home_data = $this->partnerHomeCreate($request);
        			if ($partner_home_data) {
        				return response()->json([
	                        'success' => true,
	                        'message' => trans('messages.partner_home_success'),
	                        'data'    => $partner_home_data,
                            'redirect_url'=>$redirectTo,
	                    ]);
        			} else {
        				return response()->json([
	                        'success' => false,
	                        'message' => trans('messages.create_failed'),
	                    ]);
        			}
        		} catch (\Exception $e) {
        			return response()->json([
	                    'success' => false,
	                    'message' => $e->getMessage(),
	                ]);
        		}
        	}            
        }
        return view('partner-type', compact('type', 'year_of_paasing', 'shifts', 'seriveName', 'facilities_list'));
    }

    //partner service profession information
    public function partnerServiceCreate($data)
    {

    	$partner_id = Auth::user()->partner->id;
    	//upload image
    	$filename  = $data->qualification_certificate;
        $dob = null;
        if (isset($data->dob) && !empty($data->dob)) {
            $dob = date('Y-m-d',strtotime($data->dob));
        }
    	$partnerServiceData = PartnerService::create([
    		'partner_id' => $partner_id,
    		'service_id' => $data->service_name,
    		'name'		 => $data->name,
    		'father_name'=> $data->father_name, 
	    	'dob'		 => $dob, 
	    	'qualification'=> $data->qualification, 
	    	'year_of_passing'=> $data->year_of_passing, 
	    	'college_name'=> $data->name_of_college, 
	    	'working_at' => $data->currently_working_at, 
	    	'specialization_area' => $data->area_of_specialization, 
	    	'total_experience' => $data->total_year_of_experience, 
	    	'shift_timings' => $data->preferred_shift_time, 
	    	'charges' => $data->charges, 
	    	'address' => $data->current_address, 
	    	'additional_info' => $data->any_additional_info,
	    	'status' => 1,
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
    	}
    	return $partnerServiceData;
    	//return false;
    }

    //partner service profession information validation
    public function serviceValidation(array $data)
    {
    	$rules = [
    		'service_name'=>'required',
            'name'=>'required|max:32',
            'father_name' =>'required',
            'qualification'=>'required',
            //'qualification_certificate' =>'required|mimes:jpeg,jpg,png,bmp,pdf,doc,docx',
            //'dob' => 'required|date_format:d-m-Y|before:today',
            'year_of_passing'=> 'required|digits:4',
            'name_of_college'=> 'required',
            'currently_working_at' => 'required',
            'area_of_specialization'=>'required',
            'total_year_of_experience'=>'required',
            'preferred_shift_time'=>'required',
            'charges'=> 'required|regex:/^\d+(\.\d{1,2})?$/',
            'current_address'=> 'required',
        ];
        return Validator::make($data, $rules);
    }

    //partner home form validation
    public function homeValidation(array $data)
    {
    	$rules = [
    		'home_name'=>'required',
            'number_of_rooms'=>'required',
            'contact_person' =>'required',
            'contact_phone' =>'required',
            'room_rent' =>'required',
            'facilities_available' =>'required',
            'upload_photo.*' =>'required|mimes:jpeg,jpg,png,bmp,pdf,doc,docx|max:500000',
            'address'=> 'required',
        ];
        return Validator::make($data, $rules);
    }

    // form validation error response
    public function formvaliationErrors($validator)
    {
    	return response()->json([
            'success' => false,
            'message' => trans('messages.incorrect_form_values'),
            'errors' => $validator->getMessageBag()->toArray()
        ]);
    }

    // partner home details save
    public function partnerHomeCreate($data)
    {
    	$partner_id = Auth::user()->partner->id;
    	// file upload 
    	$filename 	 = $data->upload_photo ? array_filter($data->upload_photo) :null;
        $mediaId     = array();
        if (count($filename) > 0) {
            foreach ($filename as $key => $value) {
            	$mediaTitle  = pathinfo($value->getClientOriginalName(),PATHINFO_FILENAME);
            	$mediaType   = Partner::getFileType($value);
            	$image_name  = getRandomFileName($value);
            	$storageDir  = Partner::HOME_MEDIA_PATH;
            	$imageUpload = Partner::uploadFile($value,$image_name,$storageDir);
                //image save to media
                $media = Media::create([
                    'title' => $mediaTitle, 
                    'type'  => $mediaType, 
                    'source'=> $image_name, 
                ]);
                $mediaId[]  = $media->id;
            }
        }
    	if (count($mediaId) > 0) {
	    	$partnerHomeData = PartnerHome::create([
	    		'partner_id' => $partner_id, 
		    	'name'		 => $data->home_name, 
		    	'address'    => $data->address, 
		    	'no_of_rooms'=> $data->number_of_rooms,
                'contact_person' => $data->contact_person,
                'contact_phone' => $data->contact_phone,
                'room_rent'=> $data->room_rent,
		    	'other_facilities' => $data->other_facilities_available, 
		    	'status' => 1,
	    	]);
	    	$partnerHomeId = $partnerHomeData->id;
	    	//Sync to image partnerHomeMediatable
            $partnerHomeData->partnerMedias()->sync($mediaId);
            //Sync to home facilities
            $partnerHomeData->facilities()->sync($data->facilities_available);
    		/*$media = Media::create([
    			'title' => $mediaTitle, 
		    	'type'  => $mediaType, 
		    	'source'=> $image_name, 
    		]);
    		$mediaId = $media->id;
    		//media id map to partner home media table
    		$partnerHomeMedia = PartnerHomeMedia::create([
    			'partner_home_id' => $partnerHomeId, 
    			'media_id' => $mediaId, 
    		]);*/
    		return $partnerHomeData;
    	}
    	return false;
    }

    //service provider register
    public function serviceRegister(Request $request)
    {
        $data = $request->all();
        $available_facility = array();
        $service_type = Service::find($request->serive_provider_name);
        $form_set = $service_type->form_set;
        $validator = $this->serviceRegisterValidation($data, $form_set);
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

        if ($request->all()) {
            //Comman field values
            $createService = '';
            $formData = array();
            $formData['user_id'] = Auth::id();
            $formData['service_id'] = $request->serive_provider_name;
            $formData['status'] = 2;
            $formData['contact_phone'] = $request->contact_phone;
            $formData['name'] = $request->name;
            $formData['city'] = $request->city;
            $formData['state'] = $request->state;
            $formData['postal_code'] = $request->pin_code;
            $formData['additional_info'] = $request->add_info;

            switch ($form_set) {
                case Service::FORM_SET_1:
                    $formData['gender'] = $request->gender;
                    $formData['dob'] = null;
                    if (isset($request->date_of_birth) && !empty($request->date_of_birth)) {
                        $formData['dob'] = date('Y-m-d',strtotime($request->date_of_birth));
                    }
                    $formData['contact_email'] = $request->email;
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
                        $id_prof_id = $this->multiFileUpload($request->upload_id_proof, false);
                        $formData['id_proof_media_id'] = $id_prof_id ? implode(',', $id_prof_id) : null;
                        if ($request->profile_photo) {
                            $avatar_id = $this->avatarAndDocUpload($request->profile_photo, User::AVATAR_IMAGE);
                            $formData['profile_photo_id'] = $avatar_id;
                        }
                        $createService = PartnerService::create($formData);
                        $this->providerEmailNotification($createService);
                    } catch (\Exception $e) {
                        return response()->json([
                            'success' => false,
                            'message' => trans('messages.something_wrong'),
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
                            $avatar_id = $this->avatarAndDocUpload($request->profile_photo, User::AVATAR_IMAGE);
                            $formData['profile_photo_id'] = $avatar_id;
                        }
                        $labImages  = $request->lab_pharmacy_photo ? array_filter($request->lab_pharmacy_photo) : null;
                        if (!empty($labImages)) {
                            $lapMediaId = $this->multiFileUpload($labImages);
                        }
                        $createService = PartnerService::create($formData);
                        if(isset($lapMediaId) && !empty($lapMediaId)) {
                            $createService->serviceMedia()->sync($lapMediaId);
                        }
                        $this->providerEmailNotification($createService);
                    } catch (\Exception $e) {
                        return response()->json([
                            'success' => false,
                            'message' => trans('messages.something_wrong'),
                        ]);
                    }
                    break;

                case Service::FORM_SET_3:
                    $formData['govt_approved'] = $request->govt_approved;
                    $formData['registration_number'] = $request->old_age_home_reg_no;
                    $formData['contact_person'] = $request->contact_person;
                    $formData['no_of_rooms'] = $request->number_of_rooms;
                    $formData['room_rent'] = $request->room_rent;
                    $formData['landline_number'] = $request->landline_number;
                    $formData['other_facilities'] = $request->other_facilities_available;
                    $formData['address'] = $request->old_home_address;
                    $formData['website_link'] = $request->website_link;
                    $facilities  = $available_facility;
                    try {
                        if ($request->profile_photo) {
                            $avatar_id = $this->avatarAndDocUpload($request->profile_photo, User::AVATAR_IMAGE);
                            $formData['profile_photo_id'] = $avatar_id;
                        }
                        $homeImages  = $request->home_avatar ? array_filter($request->home_avatar) : null;
                        if (!empty($homeImages)) {
                            $homeMediaId = $this->multiFileUpload($homeImages);
                        }
                        $createService = PartnerService::create($formData);
                        $createService->serviceFacilities()->sync($facilities);
                        if(isset($homeMediaId) && !empty($homeMediaId)) {
                            $createService->serviceMedia()->sync($homeMediaId);
                        }
                        $this->providerEmailNotification($createService);
                    } catch (\Exception $e) {
                        return response()->json([
                            'success' => false,
                            'message' => trans('messages.something_wrong'),
                        ]);
                    }
                    break;

                case Service::FORM_SET_4:
                    $formData['registration_number'] = $request->reg_no_or_licence_no;
                    $formData['contact_person'] = $request->contact_person;
                    $formData['address'] = $request->medical_address;
                    $formData['landline_number'] = $request->landline_number;
                    $formData['website_link'] = $request->website_link;
                    try {
                        if ($request->profile_photo) {
                            $avatar_id = $this->avatarAndDocUpload($request->profile_photo, User::AVATAR_IMAGE);
                            $formData['profile_photo_id'] = $avatar_id;
                        }
                        // Service creation and media sync to service media table
                        $medicalImages = $request->medical_profile_photo ? array_filter($request->medical_profile_photo) : null;
                        if (!empty($medicalImages)) {
                            $medicalMediaId = $this->multiFileUpload($medicalImages);
                        }
                        $createService = PartnerService::create($formData);
                        $partnerService_id = $createService->id;
                        if (isset($medicalMediaId) && !empty($medicalMediaId)) {
                            $createService->serviceMedia()->sync($medicalMediaId);
                        }
                        $this->providerEmailNotification($createService);
                    } catch (\Exception $e) {
                        return response()->json([
                            'success' => false,
                            'message' => trans('messages.something_wrong'),
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
                    $formData['services_provided'] = $request->service_provider;
                    try {
                        if ($request->profile_photo) {
                            $avatar_id = $this->avatarAndDocUpload($request->profile_photo, User::AVATAR_IMAGE);
                            $formData['profile_photo_id'] = $avatar_id;
                        }
                        $careHomeImages = $request->care_home_photo ? array_filter($request->care_home_photo) : null;
                        if(!empty($careHomeImages)) {
                            $careHomeMediaId = $this->multiFileUpload($careHomeImages);
                        }
                        $createService = PartnerService::create($formData);
                        if (isset($careHomeMediaId) && !empty($careHomeMediaId)) {
                            $createService->serviceMedia()->sync($careHomeMediaId);
                        }
                        $this->providerEmailNotification($createService);
                    } catch (\Exception $e) {
                        return response()->json([
                            'success' => false,
                            'message' => trans('messages.something_wrong'),
                        ]);
                    }
                    break;

                case Service::FORM_SET_6:
                    $formData['project_name'] = $request->project_name;
                    $formData['contact_person'] = $request->contact_person;
                    $formData['contact_email'] = $request->contact_email;
                    $formData['landline_number'] = $request->landline_number;
                    $formData['website_link'] = $request->website_link;
                    try {
                        if ($request->profile_photo) {
                            $avatar_id = $this->avatarAndDocUpload($request->profile_photo, User::AVATAR_IMAGE);
                            $formData['profile_photo_id'] = $avatar_id;
                        }
                        $retireHomeImages = $request->retire_home_photo ? array_filter($request->retire_home_photo) : null;
                        if ($retireHomeImages) {
                            $retHomeMediaId = $this->multiFileUpload($retireHomeImages);
                        }
                        $createService = PartnerService::create($formData);
                        if (isset($retHomeMediaId) && !empty($retHomeMediaId)) {
                            $createService->serviceMedia()->sync($retHomeMediaId);
                        }
                        $this->providerEmailNotification($createService);
                    } catch (\Exception $e) {
                        return response()->json([
                            'success' => false,
                            'message' => trans('messages.something_wrong'),
                        ]);
                    }
                    break;

                default:
                    break;
            }
            // Service Create
            if ($createService) {
                return response()->json([
                    'success' => true,
                    'message' => trans('messages.partner_service_success'),
                    'data'    => $createService,
                    'redirect_url'=> route('home'),
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => trans('messages.create_failed'),
                ]);
            }
        }
    }

    // Mulple file uploade 
    public function multiFileUpload($file_name, $default_storage_path = true)
    {
        
        $storageDir  = $default_storage_path ? User::SERVICE_MEDIA_PATH : User::ID_PROOF_MEDIA_PATH;
        $filename    = $file_name ? array_filter($file_name) :null;
        $mediaId     = array();
        if (count($filename) > 0) {
            foreach ($filename as $key => $value) {
                $mediaTitle  = pathinfo($value->getClientOriginalName(),PATHINFO_FILENAME);
                $mediaType   = getFileType($value);
                $image_name  = getRandomFileName($value);
                $compress    = $mediaType == 'image' ? true : false;
                $imageUpload = User::uploadFile($value, $image_name, $storageDir, $compress);
                //image save to media
                $media = Media::create(['title' => $mediaTitle, 'type'  => $mediaType, 'source'=> $image_name]);
                $mediaId[]  = $media->id;
            }
        }        
        return $mediaId;
    }

    //Avatar photo upload
    public function avatarAndDocUpload($filename, $type)
    {
        $media_id = null;
        if (!empty($filename)) {
            $mediaTitle  = pathinfo($filename->getClientOriginalName(),PATHINFO_FILENAME);
            $mediaType   = getFileType($filename);
            $image_name  = getRandomFileName($filename);
            $compress    = $mediaType == 'image' ? true : false;
            if (User::AVATAR_IMAGE == $type ) {
                $storageDir  = User::AVATAR_MEDIA_PATH;
            } else {
                $storageDir  = User::ID_PROOF_MEDIA_PATH;
            }
            $imageUpload = User::uploadFile($filename, $image_name, $storageDir, $compress);
            //image save to media
            $media = Media::create(['title' => $mediaTitle, 'type'  => $mediaType, 'source'=> $image_name]);
            $media_id = $media->id;
        }
        return $media_id;
    }

    //Service porovider Register validation
    public function serviceRegisterValidation(array $data, $form_set)
    {
        // Common fields
        $rules = array();
        $messages = array();
        $rules['serive_provider_name']='required';
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
                $rules['upload_id_proof.*'] ='required|mimes:jpeg,jpg,png,pdf,doc,docx|max:500000';

                $messages = [
                    'date_of_birth.before' => 'You must be at least 13 years old',
                    'date_of_birth.date_format' => 'Date of birth format should be DD-MM-YYYY',
                ];

                break;

            case Service::FORM_SET_2:
                $rules['reg_no_or_licence_no'] ='required';
                $rules['contact_person'] ='required';
                $rules['form_two_landline_number'] = 'nullable|regex:'.config('app.landline_validation');
                //$rules['lab_pharmacy_photo.*'] ='required|mimes:jpeg,jpg,png,gif|max:500000';

                $messages = [
                    'form_two_landline_number.numeric' => 'Landline number be a numbers and space & -',
                ];

                break;

            case Service::FORM_SET_3:
                $rules['govt_approved'] = 'required';
                $rules['old_age_home_reg_no'] = 'required_if:govt_approved,1';
                $rules['contact_person'] ='required';
                $rules['number_of_rooms'] ='required';
                $rules['landline_number'] ='nullable|regex:'.config('app.landline_validation');
                $rules['facilities_available'] ='required';
                $rules['room_rent'] ='nullable|regex:/^\d+(\.\d{1,2})?$/';
                //$rules['home_avatar.*'] ='required|mimes:jpeg,jpg,png,gif|max:500000';

                $messages = [
                    'old_age_home_reg_no.required_if' => 'Registration number is required.',
                ];

                break;

            case Service::FORM_SET_4:
                $rules['reg_no_or_licence_no'] ='required';
                $rules['contact_person'] ='required';
                $rules['landline_number'] ='nullable|regex:'.config('app.landline_validation');
                //$rules['medical_profile_photo.*'] = 'required|mimes:jpeg,jpg,png,gif|max:500000';
                break;

            case Service::FORM_SET_5:
                $rules['reg_no_or_licence_no'] ='required';
                $rules['contact_person'] ='required';
                $rules['landline_number'] ='nullable|regex:'.config('app.landline_validation');
                $rules['address'] = 'required';
                //$rules['care_home_photo.*'] ='required|mimes:jpeg,jpg,png,bmp|max:500000';
                break;

            case Service::FORM_SET_6:
                $rules['project_name'] ='required';
                $rules['contact_person'] ='required';
                $rules['landline_number'] ='nullable|regex:'.config('app.landline_validation');
                //$rules['retire_home_photo.*'] ='required|mimes:jpeg,jpg,png,gif|max:500000';
                break;            

            default:
                break;
        }
        return Validator::make($data, $rules, $messages);
    }

    //Mobile number verification
    public function mobileNumberVerification(Request $request)
    {   
        if ($request->type) {
            $resent_limit = Session::get('provider_details') ? Session::get('provider_details.tries_limit') : null;
            $resentCount  = $resent_limit + 1;
            Session::put("provider_details.tries_limit",$resentCount);
        }
        $alreadyVerified = Auth::user()->mobile_number_verified ?? null;
        if ($alreadyVerified && !$request->type) {
            return redirect()->route('home');
        }
        $authUserMobile = Auth::user()->mobile_number ?? null;
        if ($request->all()) {
            $input_data = $request->all();
            $messages = ['mobile_number.unique' => trans('messages.mobilie_no_common_error')];
            if(Auth::check()){
                $validator  = Validator::make($input_data, [
                    'mobile_number' => 'required|numeric|digits:10|unique:users,mobile_number,'.Auth::id(),
                ], $messages);
            }else{
                $validator  = Validator::make($input_data, [
                    'mobile_number' => 'required|numeric|digits:10'
                ]);
            }
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => trans('auth.mobile_number_formate'),
                    'errors' => $validator->getMessageBag()->toArray()
                ]);
            }
            $mobile_number   = $request->mobile_number;
            if (Auth::user() && !$request->type) {
                $user = Auth::user();
                $user_mobile = $user->mobile_number;
                $google_id   = $user->google_id;
                $facebook_id = $user->facebook_id;
                if(empty($user_mobile) && ($google_id || $facebook_id)){

                }
                else if ($user_mobile != $mobile_number) {
                    return response()->json([
                        'success' => false,
                        'message' => trans('messages.other_user_mobile'),
                    ]);
                }
            }
            $phone_verify    = route('phone.verify');
            $messageString   = trans('messages.mobile_verification_otp_msg');
            Session::put('mobile_number', $mobile_number);
            $sendOtpResponse = User::sendOtp($mobile_number, $messageString, User::REGISTER_OTP);
            $sendOtpResponse['redirect_url'] = $phone_verify;
            $sendOtpResponse['resendCount']  = Session::get('provider_details.tries_limit') ? Session::get('provider_details.tries_limit') : null;
            return response()->json($sendOtpResponse);
        }
        return view('partials.mobile-number-verification', compact('authUserMobile'));
    }

    //Mobile verify
    public function phoneVerify()
    {
        $enable_otp_verification = env('ENABLE_SIGNUP_OTP_VERIFICATION');
        $resendDisable = Session::get("provider_details.tries_limit");
        $resendLimit   = config('textlocal.resend_limit');
        $btnEnable = false;
        if ($resendDisable < $resendLimit) {
            $btnEnable = true;
        }
        $authUserMobile = Session::get('mobile_number');
        $via_email = false;
        if (!$enable_otp_verification) {
            $authUserMobile = Session::get('provider_details.email');
            if(Auth::check()) {
                $authUserMobile = Session::get('verify_email'); //Auth::user()->email;
            }
            $via_email = true;
            $btnEnable = false;
        }
        return view('partials.phone-verify', compact('authUserMobile', 'btnEnable', 'via_email'));
    }

    // Service provider
    public function serviceProvider(Request $request)
    {
        $provider_form = '';
        $provider_id = $request->id ? $request->id : null;
        $facilities = Facility::all();
        $services = Service::where('status', User::STATUS_ACTIVE)->get();
        $getIdProof = getIdProof();
        $getGender = getGender();
        $getShift = getShiftType();
        $states = State::all();
        $cities = City::all();
        $govtApproved = PartnerService::govtApproved();
        // User Email and mobile number auto fill
        $contactDetail = User::find(Auth::id());
        $mobile_number = isset($contactDetail->mobile_number) ? $contactDetail->mobile_number : null;
        $email = isset($contactDetail->email) ? $contactDetail->email : null;

        if ($provider_id) {
            $service_type = Service::find($provider_id);
            if ($service_type) {
                $provider_form = $this->getProviderForms($service_type->form_set);
                return view('service-provider', compact('facilities', 'services', 'getIdProof', 'getGender', 'getShift','states', 'cities', 'provider_form', 'provider_id', 'mobile_number', 'email', 'govtApproved'));
            }
        }
        
        return view('service-provider', compact('facilities', 'services', 'getIdProof', 'getGender', 'getShift','states', 'cities', 'provider_form', 'provider_id', 'mobile_number', 'email', 'govtApproved'));
    }

    //Get service provider forms
    public function seviceProviderForm(Request $request)
    {
        $facilities = Facility::all();
        $services   = Service::all();
        $getIdProof = getIdProof();
        $getGender  = getGender();
        $getShift   = getShiftType();
        $states = State::all();
        $cities = City::all();
        $govtApproved = PartnerService::govtApproved();
        // User Email and mobile number auto fill
        $contactDetail = User::find(Auth::id());
        $mobile_number = isset($contactDetail->mobile_number) ? $contactDetail->mobile_number : null;
        $email = isset($contactDetail->email) ? $contactDetail->email : null;

        $service_id = $request->id;
        $service_type = Service::find($request->id);
        if ($service_type) {
            $providerForm = $this->getProviderForms($service_type->form_set);
            if ($providerForm) {
                return view('partials.'.$providerForm, compact('facilities', 'services', 'getIdProof', 'getGender', 'getShift',
                 'states', 'cities', 'mobile_number', 'email', 'govtApproved'));
            }
        }
    }

    /**
    *@var provider_type is below form name
    *1.Individual Nurse Trained Attendant Physiotherapist Occupational Therapist - service provider form
    *2.Lab/Pharmacy Surgical Pharmacy Ambulance Service - service provider
    *3.Old Age Home - service provider form
    *4.Medical Equipment Rental  service provider form
    *5.Home Care service provider form
    *6.Retirment Homes service provider form
    */
    public function getProviderForms($form_set)
    {
        $template = '';
        switch ($form_set) {
            case Service::FORM_SET_1:
                $template = "nurse-physiotherapist-attendant";
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
                break;
        }
        return $template;
    }

    // Service provider Type
    public function providerType()
    {
        $nursePhysiotherapist = ['home-nurses', 'trained-attendants', 'physiotherapists', 'occupational-therapists'];
        $labPharmacyAmbulance = ['lab', 'pharmacy', 'surgical-pharmacy', 'ambulance-services'];
        $oldAgeHome = ['old-age-paid-homes'];
        $medicalEquipmentRental = ['medical-equipments-rental'];
        $homeCareService = ['home-care-service-providers'];
        $retirmentHomes  = ['retirement-homes'];

        $slugArray = [
            'nursePhysio' => $nursePhysiotherapist, 
            'labPharmacy' => $labPharmacyAmbulance, 
            'olgAgeHome'=> $oldAgeHome, 
            'medicalEquipment' => $medicalEquipmentRental, 
            'homeCare' => $homeCareService,
            'retirmentHome' => $retirmentHomes,
        ];

        return $slugArray;
    }

    // User Otp Verification
    public function userOtpVerification(Request $request)
    {
        $redirectURL = route('profile.edit'); //route('home');
        $enable_otp_verification = env('ENABLE_SIGNUP_OTP_VERIFICATION');
        $mobile_number = $request->mobile_number;
        $data   = $request->all();
        $getOtpDetail = Sms::where('user_id', Auth::id())->where(['verify_status' => 0]);
        if ($enable_otp_verification) {
            $getOtpDetail->where('mobile_number', $mobile_number);
        } else {
            $getOtpDetail->where('email', $mobile_number);
        }
        $getOtpDetail = $getOtpDetail->first();
        $userData     = User::find(Auth::id());
        $getOtp       = $getOtpDetail->otp_number;
        if ($getOtp == $data['otp_number']) {
            Session::forget('verify_email');
            $getOtpDetail->verify_status = User::STATUS_ACTIVE;
            $getOtpDetail->mobile_number = $userData->mobile_number;
            $getOtpDetail->email = $userData->email;
            $getOtpDetail->save();
            if ($enable_otp_verification) {
                if(!$userData->mobile_number){
                    $userData->mobile_number = $mobile_number;
                }
                $userData->mobile_number_verified = User::STATUS_ACTIVE;
            } else {
                $userData->email = $mobile_number;
                $userData->email_verified = User::STATUS_ACTIVE;
            }
            $userData->status = User::STATUS_ACTIVE;
            $userData->save();
            Session::flash('message', trans('messages.user_register_success'));
            return response()->json([
                'success' => true,
                'message' => trans('messages.valid_otp'),
                'data'    => $userData,
                'redirect_url' => $redirectURL,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => trans('messages.invalid_otp'),
            ]);
        }
    }

    public function emailVerification(Request $request)
    {
        $authEmail = Auth::user()->email ? Auth::user()->email : null;
        if ($request->all()) {
            $input_data = $request->all();
            $messages = ['email.unique' => 'Email already registered with us.'];
            $validator  = Validator::make($input_data, [
                'email' => 'required|email|unique:users,email,'.Auth::id(),
            ], $messages);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => trans('auth.user_email_msg'),
                    'errors' => $validator->getMessageBag()->toArray()
                ]);
            }
            $email = $request->email;
            /*if ($authEmail != $email) {
                return response()->json([
                    'success' => false,
                    'message' => trans('messages.other_user_email'),
                ]);
            }*/
            $phone_verify    = route('phone.verify');
            Session::put('verify_email', $email);
            $sendOtpResponse = $this->userEmailVerification($email, Auth::user());
            $sendOtpResponse['redirect_url'] = $phone_verify;
            return response()->json($sendOtpResponse);
        }
        return view('partials.email-verification', compact('authEmail'));
    }

    // User Email Verification
    public function userEmailVerification($email, $userObject)
    {
        $returnResponse = array();
        $otp_code = mt_rand(100000,999999);
        try {
            $mailData = [
                'code'=> $otp_code,
                'name'=> $userObject->first_name
            ];
            $mail_class = new EmailVerificationMail($mailData);
            $checkOtp = Sms::where('user_id', $userObject->id)->where('email', $email)
                        ->where('verify_status', User::STATUS_INACTIVE)->first();
            if ($checkOtp) {
                $checkOtp->otp_number =  $otp_code;
                $sendOtp = $checkOtp->save();
            } else {
                $sendOtp = Sms::create([
                    'user_id' => $userObject->id,
                    'email'  => $email, 
                    'otp_number' => $otp_code
                ]);
            }
            $sendEmail = User::sendEmail($mail_class, $email);
            if($sendOtp) {
               return $returnResponse = [
                    'success' => true,
                    'message' => trans('messages.send_otp_email_msg'),
                    'data' => $email,
                    'via_email' => true,
                ];
            } else {
                return $returnResponse = [
                    'success' => false,
                    'message' => trans('messages.something_wrong'),
                ];
            }
        } catch (\Exception $e) {
            return $returnResponse = [
                'success' => false,
                'message' => trans('messages.something_wrong'),
            ];
        }
    }

    // Provider Register Notification
    public function providerEmailNotification($serviceObject)
    {
        //Get profile Photo and Id Proof Photos
        $profilePhotoUrl = null;
        if(isset($serviceObject->getProfilePhoto) && $serviceObject->getProfilePhoto) {
            $filename = $serviceObject->getProfilePhoto->source;
            $profilePhotoUrl = storage_url(User::AVATAR_MEDIA_PATH_THUMB. $filename);
        }
        $idProofDetail = array();
        if(!empty($serviceObject->id_proof_media_id)) {
            $mediaId = isset($serviceObject->id_proof_media_id) ? explode(',', $serviceObject->id_proof_media_id) : null;
            $idProofMedia = Media::whereIn('id',$mediaId)->get();
            if (count($idProofMedia) > 0) {
                foreach ($idProofMedia as $key => $value) {
                    $file_path = storage_url(User::ID_PROOF_IMAGE_SMALL . $value->source);
                    $idProofDetail[$key]['id_proof_url'] = asset($file_path);
                }
            }
        }
        
        if(!empty($serviceObject)) {
            $toEmail = env('NEW_PROVIDER_NOTIFICATION_EMAILS');
            $salt =  PartnerService::ENCRYPT_KEY;
            $planString = $serviceObject->id.','.$salt;
            $token = encrypt($planString);
            $fees_type = null;
            $fees_amount = null;
            if(isset($serviceObject->fees_per_shift) && !empty($serviceObject->fees_per_shift)) {
                $fees_type = "Per Shift";
                $fees_amount = $serviceObject->fees_per_shift;
            } else if (isset($serviceObject->fees_per_day) && !empty($serviceObject->fees_per_day)) {
                $fees_type = "Per Day";
                $fees_amount = $serviceObject->fees_per_day;
            }
            $mailData = [
               'id'=> $serviceObject->id,
               'name' => $serviceObject->name,
               'type' => $serviceObject->serviceType->name,
               'city' => $serviceObject->city,
               'state' => $serviceObject->states->name,
               'pin_code' => $serviceObject->postal_code,
               'id_proof'=> ucfirst(str_replace('_', ' ', $serviceObject->id_proof)),
               'area_of_spl' => $serviceObject->specialization_area,
               'fees_type' => $fees_type,
               'fees_amount' => $fees_amount,
               'room_rent' => $serviceObject->room_rent,
               'profile_url'=> $profilePhotoUrl,
               'id_proof_photo_url' => $idProofDetail,
               'token' => $token,
            ];
            
            $newProviderMail = new NewProviderNotificationMail($mailData);
            $sendEmail = User::sendEmail($newProviderMail, $toEmail);
            return $sendEmail;
           /* $sendEmail = '';
            if (count($toEmails) > 0) {
                foreach ($toEmails as $key => $email ) {
                    $sendEmail = Mail::to($email)->send(new NewProviderNotificationMail($mailData));
                }
            }*/
        }
    }
}
