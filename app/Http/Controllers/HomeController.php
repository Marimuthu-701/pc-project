<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Mail\ApprovedUpdatedProviderNotificationMail;
use App\Mail\ProviderApprovedNotificationMail;
use App\Models\UserProfileUpdateHistory;
use Illuminate\Http\Request;
use App\Models\Partner;
use App\Models\Media;
use App\Models\Service;
use App\Models\State;
use App\Models\City;
use App\Models\PartnerHome;
use App\Models\PartnerService;
use App\Models\User;
use App\Models\Testimonial;
use App\Models\Rating;
use Session;
use Auth;
use DB;
use URL;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $token = null)
    {

        if ($partnerRedirect = Partner::partnerLoginRedirection()) {
            return redirect($partnerRedirect);
        }
        $approvalStatus = null;
        if (Auth::check()) {
            $auth = Auth::user();
            if (!$auth->mobile_number_verified && $auth->type!=User::TYPE_PARTNER && env('ENABLE_SIGNUP_OTP_VERIFICATION')) {
                return redirect()->route('mobile.number.verification');
            }
        }
        if (Auth::check()) {
            $auth = Auth::user();
            $approvalStatus = isset($auth->service) ? $auth->service->status : null;;
        }
        $states = State::all();
        $cities = City::all();
        $featureServices = Service::where('status', Partner::ACTIVE_STATUS)
                           ->where('is_featured', Service::IS_FEATURED)->orderByRaw('position = 0 , position')->get();
        
        $featureHomeList = [Service::FORM_SET_3, Service::FORM_SET_6, Service::FORM_SET_5];
        $homeCategory = Service::whereIn('form_set',$featureHomeList)->pluck('id')->toArray();
        $category = Service::where('status', Partner::ACTIVE_STATUS)->get()->toArray(); //Partner::getPartnerTypes();
        // Get Feature home in dynamically
        $currentDate = date('Y-m-d');
        $homeinfo = PartnerService::select('partner_services.*', DB::raw('IF(partner_services.position IS NOT NULL, partner_services.position, 1000000) as list_position'))->with('parnterServiceMedia')->whereRaw('("'.$currentDate.'" BETWEEN featured_from AND featured_to)')->where('status', Service::STATUS_ACTIVE)->where('show_at_home', 1)->whereIn('service_id', $homeCategory)->orderBy('list_position', 'asc')->get();
        $featureHomes = array();
        $ratingArray  = array();
        $recentReviewRating = array();
        $recentReviewArray = array();
        foreach ($homeinfo as $key => $value) {
            $ratingArray[$key] = $value->averageRatingByType($value->id, User::TYPE_SERVICE);
            $partnerMedia = $value->parnterServiceMedia;
            $featureHomes[$key]['id'] = $value->id;
            $featureHomes[$key]['slug'] = $value->slug;
            $featureHomes[$key]['room_rent'] = $value->room_rent;
            $featureHomes[$key]['type'] = User::TYPE_SERVICE;
            $featureHomes[$key]['homeName'] = $value->name;
            $featureHomes[$key]['homeAddress'] = $value->address ? $value->address : $value->city;
            $featureHomes[$key]['averageRating'] = isset($ratingArray[$key][0]['avarage']) ? $ratingArray[$key][0]['avarage'] : null; 
            $avatar = isset($value->getProfilePhoto) ? $value->getProfilePhoto : null;
            if (!empty($avatar)) {
                $file_name  = $avatar->source;
                $file_path  = storage_url(User::AVATAR_MEDIA_PATH_SMALL . $file_name);
                $featureHomes[$key]['imagePath'] = $file_path;
            } else {
                $featureHomes[$key]['imagePath'] = asset('images/no-image.png');
            }
        }

        // Feature Service list 
        $featureServiceList = array();
        if ( count($featureServices) > 0) {
            foreach ($featureServices as $key => $value) {
                $featureServiceList[$key]['service_name'] = $value->name;
                $featureServiceList[$key]['service_id']   = $value->id;
                $featureServiceList[$key]['service_type'] = User::TYPE_SERVICE;
                if ($value->icon) {
                    $featureServiceList[$key]['service_icon']= storage_url(User::ICON_MEDIA_PATH . $value->icon);
                } else {
                    $featureServiceList[$key]['service_icon']= asset(User::SERVICE_FEATUE_MEDIA_PATH.'others.png');
                }
            }
        }
        
        $recentReviewProvider = PartnerService::where('status', Service::STATUS_ACTIVE)->whereIn('service_id', $homeCategory)->get();
        if(count($recentReviewProvider) > 0) {
            foreach ($recentReviewProvider as $rkey => $rvalue) {
                $reviews = $rvalue->getRecentRatings($rvalue->id, User::TYPE_SERVICE)->toArray();
                if ($reviews) {
                    $recentReviewRating[] =  $reviews;
                }
            }
        }

        // Get Recent Review For Home List
        if (count($recentReviewRating) > 0) {
            foreach ($recentReviewRating as $key => $value) {
                $user = User::find($value[0]['author_id']);
                if($user) {
                    $partnerHomeDetail = PartnerService::find($value[0]['reviewrateable_id']);
                    $recentReviewArray[$key]['id'] = isset($partnerHomeDetail->id) ? $partnerHomeDetail->id : 0;
                    $recentReviewArray[$key]['slug'] = isset($partnerHomeDetail->slug) ? $partnerHomeDetail->slug : null;
                    $state = isset($partnerHomeDetail->states->name) ? $partnerHomeDetail->states->name : null;
                    $name  = isset($partnerHomeDetail->name) ? $partnerHomeDetail->name : null;
                    $city  = isset($partnerHomeDetail->city) ? $partnerHomeDetail->city : null;
                    $recentReviewArray[$key]['home_name_city_state'] = $name.', '.$city.', '.$state;
                    $recentReviewArray[$key]['rating'] = $value[0]['avarage'];
                    $recentReviewArray[$key]['type'] = User::TYPE_SERVICE;
                    $recentReviewArray[$key]['review_content'] = $value[0]['body'];
                    $recentReviewArray[$key]['post_date'] = date('j F Y', strtotime($value[0]['created_at']));
                }
            }
        }
        $getTestimonials = Testimonial::whereStatus(User::STATUS_ACTIVE)->get();
        $featureServiceName = null;
        if (count($category) > 0) {
            foreach ($category as $key => $value) {
                $featureServiceName .= $value['name'].', ';
            }
        }
        $featureServicesList = trim($featureServiceName, ', ');
        $previousUrl = isset($request->redirect_url) ? $request->redirect_url : null;
        return view('home', compact('states', 'cities', 'category', 'featureHomes', 'featureServiceList', 'recentReviewArray', 'getTestimonials', 'approvalStatus', 'previousUrl', 'featureServicesList'))->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function providerApproval($token)
    {   
        if ($token) {
            $tokenDecrypt = decrypt($token);
            $tokenValue = explode(',', $tokenDecrypt);
            $id  = isset($tokenValue[0]) ? $tokenValue[0] : null;
            $key = isset($tokenValue[1]) ? $tokenValue[1] : null;
            if ($id && $key == PartnerService::ENCRYPT_KEY) {
                $seriveDetail = PartnerService::find($id);
                if($seriveDetail) {
                    if($seriveDetail->status == User::STATUS_PENDING) {
                        $seriveDetail->status = User::STATUS_ACTIVE;
                        $user_email = $seriveDetail->user ? $seriveDetail->user->email : null;
                        //Send Comfirmation mail to user
                        $mailData = [
                            'slug'=> $seriveDetail->slug,
                            'name' => $seriveDetail->name
                        ];
                        $mailProvider = new ProviderApprovedNotificationMail($mailData);
                        $message = trans('messages.profile_approved_msg');
                        try {
                            User::sendEmail($mailProvider, $user_email);
                        } catch(\Exception $e) {
                            $message = trans('messages.something_wrong');
                            $status = false;
                        }
                        $status  = true;
                    } else if($seriveDetail->status == User::STATUS_ACTIVE ){
                        $message = trans('messages.profile_already_approvde_msg');
                        $status = false;
                    }
                    if ($seriveDetail->save()) {
                        return view('approval', compact('message', 'status'));
                    }
                }
            }
        }
    }

    // Approve new review
    public function approveReview($token)
    {
        $message = trans('messages.not_found');
        $status  = false;
        if ($token) {
            $tokenDecrypt = decrypt($token);
            $tokenValue = explode(',', $tokenDecrypt);
            $id  = isset($tokenValue[0]) ? $tokenValue[0] : null;
            $key = isset($tokenValue[1]) ? $tokenValue[1] : null;
            if ($id && $key == PartnerService::ENCRYPT_KEY) {
                $review = Rating::find($id);
                if ($review) {
                    if($review->approved == User::STATUS_PENDING) {
                        $review->approved = User::STATUS_ACTIVE;
                        $message = trans('messages.review_approvel_msg');
                        $status  = true;
                    } else if($review->approved == User::STATUS_ACTIVE ) {
                        $message = trans('messages.review_already_approved');
                        $status = false;
                    }
                    if ($review->save()) {
                        return view('approval', compact('message', 'status'));
                    }
                }
                return view('approval', compact('message', 'status'));
            }
        }
    }

    public function testimonialApprove($token)
    {
        $message = trans('messages.not_found');
        $status  = false;
        if ($token) {
            $tokenDecrypt = decrypt($token);
            $tokenValue = explode(',', $tokenDecrypt);
            $id  = isset($tokenValue[0]) ? $tokenValue[0] : null;
            $key = isset($tokenValue[1]) ? $tokenValue[1] : null;
            if ($id && $key == PartnerService::ENCRYPT_KEY) {
                $testimonial = Testimonial::find($id);
                if ($testimonial) {
                    if($testimonial->status == User::STATUS_PENDING) {
                        $testimonial->status = User::STATUS_ACTIVE;
                        $message = trans('messages.testimonial_approvel_msg');
                        $status  = true;
                    } else if($testimonial->status == User::STATUS_ACTIVE ) {
                        $message = trans('messages.testimonial_already_approved');
                        $status = false;
                    }
                    if ($testimonial->save()) {
                        return view('approval', compact('message', 'status'));
                    }
                }
                return view('approval', compact('message', 'status'));
            }
        }
    }


    public function profileUpdatedApprove($token)
    {
        $message = trans('messages.not_found');
        $status  = false;
        if ($token) {
            $tokenDecrypt = decrypt($token);
            $tokenValue = explode(',', $tokenDecrypt);
            $id  = isset($tokenValue[0]) ? $tokenValue[0] : null;
            $key = isset($tokenValue[1]) ? $tokenValue[1] : null;
            if ($id && $key == PartnerService::ENCRYPT_KEY) {
                $updateHistory = UserProfileUpdateHistory::find($id);
                if ($updateHistory) {
                    if ($updateHistory->status == User::STATUS_PENDING) {
                        $updateHistory->status = User::STATUS_ACTIVE;
                        $updatedData = $updateHistory->update_values ? json_decode($updateHistory->update_values) : null;
                        if ($updatedData) {
                            $updatedProvider = PartnerService::where('user_id', $updateHistory->user_id)->first();
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
                                        $mailProvider = new ApprovedUpdatedProviderNotificationMail($mailData);
                                        User::sendEmail($mailProvider, $user_email);
                                        $message = trans('messages.profile_approved_msg');
                                        $status  = true;
                                    }
                                } catch(\Exception $e) {
                                    $message = trans('messages.something_wrong');
                                    $status = false;
                                }
                            }
                        }
                    } else if($updateHistory->status == User::STATUS_ACTIVE) {
                        $message = trans('messages.profile_already_approvde_msg');
                        $status = false;
                    }

                    if ($updateHistory->save()) {
                        return view('approval', compact('message', 'status'));
                    }
                }
                return view('approval', compact('message', 'status'));
            }
        }
    }

    // public function importIndianCities(Request $request)
    // {
    //     // $indian_cities = file_get_contents(__DIR__ . '/../../../' . 'indian-cities.json');
    //     // $cities = json_decode($indian_cities, true);

    //     $cities = DB::table('indian_cities')->get();
    //     foreach ($cities as $city) {
    //         $state_info = State::where('name', trim($city->state))->first();
    //         if ($state_info) {
    //             $state_code = $state_info->code;
    //             $is_exist = City::where('name', $city->name)->where('state', $state_code)->first();
    //             if (!$is_exist) {
    //                 City::create([
    //                     'name' => $city->name,
    //                     'state' => $state_code,
    //                 ]);
    //             }
    //         } else {
    //             echo "<br>Not: " . $city->state;
    //         }

    //         // DB::table('indian_cities')->insert($city);
    //     }

    //     echo 'Imported Successfully!';
    // }
}
