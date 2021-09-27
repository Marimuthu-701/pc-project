<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\PartnerService;
use App\Models\Partner;
use App\Models\Service;
use App\Models\Facility;
use App\Models\Wishlist;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use Auth;
use DB;

class SearchController extends Controller
{
        
    //search Data
    public function search(Request $request)
    {
        $page = env('SEARCH_PAGENATION', 10);
        $cities     = City::select('id', 'name', 'state');
        if (!empty($request->state)) {
            $cities->where('state',$request->state);
        }
        $service_id = isset($request->service_id) ? $request->service_id : null;
        $serviceList = Service::find($service_id);
        $serviceName = $serviceList ? $serviceList->name : null;
        $cities     = $cities->get();
    	$services   = Service::select('id', 'name',DB::raw('null as category'))
                      ->where('status', User::STATUS_ACTIVE)->orderByRaw('position = 0 , position')->get()->toArray();
        $states     = State::all();
    	$partnerTypes = Partner::getPartnerTypes();
    	$totalService = PartnerService::where('status',User::STATUS_ACTIVE)->count();
        /*$serviceCategoryCount = PartnerService::select('s.id as service_id', DB::raw('COUNT(service_id) as service_count'))
                                ->leftJoin('services as s', 's.id', '=', 'partner_services.service_id')
                                ->groupBy('service_id')->get();*/
    	$searchType   = $request->category ? $request->category : User::TYPE_SERVICE;
    	$featureDataResult = $this->getHomeServiceData($searchType,$request,$page);
        $serviceCategoryCount = $featureDataResult['categoryCount'];
    	$featureData  = $featureDataResult['featureData'];
    	$data = $featureDataResult['data'];
        $title_message = $featureDataResult['message'];
        /* This condition and loop for add category type */
        if (count($services) > 0):
            foreach ($services as $key => $value) {
                $services[$key]['category'] = User::TYPE_SERVICE;
            }
        endif;

        $data->appends(request()->all());
        if($request->ajax()){
            return view('partials.search-right-panel', compact('featureData','data', 'serviceName', 'title_message'))->with($request->all());
        }
    	return view('search', compact('cities', 'services', 'featureData', 'searchType', 'totalService', 'data', 'serviceCategoryCount',  'states', 'serviceName', 'title_message'));
    }

    //Ajax Request function
    public function innerSearch(Request $request)
    {
    	$page       = env('SEARCH_PAGENATION', 10);
    	$searchType = $request->category;
    	$featureDataResult = $this->getHomeServiceData($searchType,$request,$page);
    	$featureData       = $featureDataResult['featureData'];
    	$data = $featureDataResult['data'];
    	return view('partials.search-right-panel', compact('featureData', 'data'));
    }


    public function servicesAndCount(Request $request)
    {
        $page       = env('SEARCH_PAGENATION', 10);
        $searchType = User::TYPE_SERVICE;
        $services   = Service::select('id', 'name',DB::raw('null as category'))
                      ->where('status', User::STATUS_ACTIVE)->orderByRaw('position = 0 , position')->get()->toArray();
        /* This condition and loop for add category type */
        if (count($services) > 0):
            foreach ($services as $key => $value) {
                $services[$key]['category'] = User::TYPE_SERVICE;
            }
        endif;
        $featureDataResult = $this->getHomeServiceData($searchType,$request,$page);
        $serviceCategoryCount = $featureDataResult['categoryCount'];
        return view('partials.search-left-service-category', compact('serviceCategoryCount', 'services'));
    }

    //Get services and home datas
    public function getHomeServiceData($partnerType ,$keyword, $page)
    {
    	$featureData = array();
        $wishList    = array();
        $currentDate = date('Y-m-d');
    	$data = '';
        $message = null;
        //$homes = [Service::FORM_SET_3, Service::FORM_SET_6, Service::FORM_SET_5];
        $homes = [Service::FORM_SET_3];
        $homesIds = Service::whereIn('form_set',$homes)->pluck('id')->toArray();
        //printArray($keyword->all());exit;
        $featureList = $this->getFeatureList($currentDate);
        $listOrde    = DB::raw('IF(ps.position IS NOT NULL, ps.position, 1000000) as list_position');
        $categoryCount = PartnerService::select('s.id as service_id', DB::raw('COUNT(service_id) as service_count'))
                        ->leftJoin('services as s', 's.id', '=', 'partner_services.service_id')
                        ->where('s.status', User::STATUS_ACTIVE)
                        ->where('partner_services.status', User::STATUS_ACTIVE)
                        ->where('partner_services.status', '!=', User::STATUS_PENDING);
    	if ($partnerType == User::TYPE_SERVICE) {
	    	$data = DB::table('partner_services as ps')
	    				->select('ps.*', $featureList, $listOrde,'m.title','m.type as media_type','m.source', 's.name as service_name', 's.form_set')
						->leftJoin('partner_service_media as psm', 'psm.partner_service_id', '=', 'ps.id')
                        ->leftJoin('services as s', 'ps.service_id', '=', 's.id')
						->leftJoin('media as m', 'm.id', '=', 'ps.profile_photo_id')
                        ->where('s.status', User::STATUS_ACTIVE)
						->where('ps.status', User::STATUS_ACTIVE)
                        ->groupBy('ps.id');

            $postal_code_record = DB::table('partner_services as ps')
                        ->leftJoin('services as s', 'ps.service_id', '=', 's.id')
                        ->where('s.status', User::STATUS_ACTIVE)
                        ->where('ps.status', User::STATUS_ACTIVE)
                        ->groupBy('ps.id');

            if ($keyword->type) {
                $result = array();
                if($keyword->type == 'service') {
                    $data = $data->whereNotIn('ps.service_id', $homesIds);
                    if ($keyword->postal_code) {
                        $result = $postal_code_record->whereNotIn('ps.service_id', $homesIds)
                                 ->where('ps.postal_code', 'LIKE', $keyword->postal_code. '%')->get();
                    }
                } else if($keyword->type == 'home') {
                    $data = $data->whereIn('ps.service_id', $homesIds);
                    if ($keyword->postal_code){
                        $result = $postal_code_record->whereIn('ps.service_id', $homesIds)
                                  ->where('ps.postal_code', 'LIKE', $keyword->postal_code. '%')->get(); 
                    }
                }
                if(count($result) > 0) {
                    $data = $data->where('ps.postal_code', 'LIKE', $keyword->postal_code.'%');
                    if (($keyword->provider_name) && strlen($keyword->provider_name) >= 3) {
                        $data = $data->where('ps.name', 'LIKE', '%'.$keyword->provider_name.'%');
                    }
                    $message = trans('messages.postal_code_search', ['pin_code'=>$keyword->postal_code, 'city'=>$keyword->location, 'state'=>$this->getStateDeatil($keyword->state)]);
                } else{
                    if ($keyword->state) {
                        $data = $data->where('ps.state','LIKE', "%{$keyword->state}%");
                        $categoryCount = $categoryCount->where('partner_services.state','LIKE', "%{$keyword->state}%");
                    }
                    if ($keyword->location) {
                        $data = $data->where('ps.city', 'LIKE', "%{$keyword->location}%");
                        $categoryCount = $categoryCount->where('partner_services.city', 'LIKE', "%{$keyword->location}%");
                    }
                    if (($keyword->provider_name) && strlen($keyword->provider_name) >= 3) {
                        $data = $data->where('ps.name', 'LIKE', '%'.$keyword->provider_name.'%');
                        $categoryCount = $categoryCount->where('partner_services.name', 'LIKE', '%'.$keyword->provider_name.'%');
                    }
                    if($keyword->state && $keyword->location) {
                        $message = trans('messages.city_state_search', ['city'=>$keyword->location, 'state'=>$this->getStateDeatil($keyword->state)]);
                    }
                }
            } else {
                if ($keyword->featured) {
                    $data = $data->whereRaw('("'.$currentDate.'" BETWEEN ps.featured_from AND ps.featured_to)');
                    $categoryCount = $categoryCount->whereRaw('("'.$currentDate.'" BETWEEN partner_services.featured_from AND partner_services.featured_to)');
                }
                if ($keyword->state) {
                    $data = $data->where('ps.state','LIKE', "%{$keyword->state}%");
                    $categoryCount = $categoryCount->where('partner_services.state','LIKE', "%{$keyword->state}%");
                }
                if ($keyword->location) {
                    $data = $data->where('ps.city', 'LIKE', "%{$keyword->location}%");
                    $categoryCount = $categoryCount->where('partner_services.city', 'LIKE', "%{$keyword->location}%");
                }
                if (($keyword->postal_code) && strlen($keyword->postal_code) >= 3) {
                    $data = $data->where('ps.postal_code', 'LIKE', $keyword->postal_code.'%');
                    $categoryCount = $categoryCount->where('partner_services.postal_code', 'LIKE', $keyword->postal_code.'%');
                }

                if (($keyword->provider_name) && strlen($keyword->provider_name) >= 3) {
                    $data = $data->where('ps.name', 'LIKE', '%'.$keyword->provider_name.'%');
                    $categoryCount = $categoryCount->where('partner_services.name', 'LIKE', '%'.$keyword->provider_name.'%');
                }

                if ($keyword->service_id) {
                    $data = $data->where('ps.service_id', $keyword->service_id);
                }

                // Search By Message
                if(!$keyword->service_id && $keyword->state && $keyword->location && (strlen($keyword->postal_code) >= 3)) {
                    $message = trans('messages.postal_code_search', ['pin_code'=>$keyword->postal_code, 'city'=>$keyword->location, 'state'=>$this->getStateDeatil($keyword->state)]);
                } else if(!$keyword->service_id && $keyword->state && $keyword->location) {
                     $message = trans('messages.city_state_search', ['city'=>$keyword->location, 'state'=>$this->getStateDeatil($keyword->state)]);
                } else if(!$keyword->service_id && $keyword->state && (strlen($keyword->postal_code) >= 3)) {
                    $message = trans('messages.search_by_state_pin', ['pin_code'=>$keyword->postal_code, 'state'=>$this->getStateDeatil($keyword->state)]);
                } else if(!$keyword->service_id && $keyword->state) {
                    $message = trans('messages.search_by_state', ['state'=>$this->getStateDeatil($keyword->state)]);
                }
            }

			$data = $data->orderBy('feature_list', 'desc')->orderBy('list_position', 'asc')->orderBy('ps.created_at', 'desc')->paginate($page);
            $categoryCount = $categoryCount->groupBy('service_id')->get();
            if (Auth::check()) {
                $wishList = Wishlist::where('content_type',User::TYPE_SERVICE)->where('user_id', Auth::id())
                            ->pluck('content_id')->toArray();
            }

            //printArray($data);exit;
	    	if( count($data)) {
	    		foreach ($data as $key => $value) {
                    $partneSerive = PartnerService::find($value->id);
                    $getAllRating = $partneSerive->getAllRatings($value->id, User::TYPE_SERVICE);
                    $rating = $partneSerive->averageRatingByType($value->id, User::TYPE_SERVICE);
                    $fees_type = null;
                    if($value->fees_per_shift) {
                        $fees_type = "shift";
                    } else if ($value->fees_per_day) {
                        $fees_type = "day";
                    }

                    // Check review User detail
                    $reviewCount = null;
                    $totalReview = array();
                    if (count($getAllRating)) {
                        foreach ($getAllRating as $comment) {
                            $user = User::find($comment->author_id);
                            if($user) {
                                $totalReview[] = $comment;
                            }
                        }
                    }

                    // Total Review Count
                    if (count($totalReview) > 1) {
                        $reviewCount = "(".count($totalReview)." reviews)";
                    } else {
                        $reviewCount = "(".count($totalReview)." review)";
                    }

                    $featureData[$key]['id'] = $value->id;
                    $featureData[$key]['slug'] = $value->slug;
                    $featureData[$key]['service_name'] = $value->service_name;
	    			$featureData[$key]['name'] = $value->name;
	    			$featureData[$key]['sub_title'] = null;
	    			$featureData[$key]['additional_info'] = $value->additional_info;
                    $featureData[$key]['content_id'] = $value->id;
                    $featureData[$key]['content_type'] = Partner::TYPE_SERVICE;
                    $featureData[$key]['wish_list'] = $wishList;
                    $featureData[$key]['city']  = $value->city;
                    $featureData[$key]['state'] = $this->getStateDeatil($value->state);
                    $featureData[$key]['contact_no'] = $value->contact_phone;
                    $featureData[$key]['contact_email'] = $value->contact_email;
                    $featureData[$key]['room_rent'] = $value->room_rent;
                    $featureData[$key]['service_slug'] = $value->form_set;
                    $featureData[$key]['rating'] = isset($rating[0]['avarage']) ? $rating[0]['avarage'] : null;
                    $featureData[$key]['feature_list'] = $value->feature_list;
                    $featureData[$key]['verified'] = $value->verified;
                    $featureData[$key]['qualification'] = $value->qualification;
                    $featureData[$key]['specialization_area'] = $value->specialization_area;
                    $featureData[$key]['total_experience'] = $value->total_experience;
                    $featureData[$key]['project_name'] = $value->project_name;
                    $featureData[$key]['fees'] = !$value->fees_per_shift ? $value->fees_per_day : $value->fees_per_shift;
                    $featureData[$key]['fees_type'] = $fees_type;
                    $featureData[$key]['reviews'] = $reviewCount;
                    //$featureData[$key]['postal_code'] = $value->postal_code;
                    if (!empty($value->media_type) && $value->media_type !='file') {
                        $file_path = storage_url(User::AVATAR_MEDIA_PATH_SMALL .$value->source);
                        $featureData[$key]['imagePath'] = asset($file_path);
                    } else if(empty($value->media_type)) {
                        $featureData[$key]['imagePath'] = asset('images/sample-avatar.png');
                    }
	    		}
	    	}
    	}
    	return array('featureData'=>$featureData,'data'=>$data, 'categoryCount'=>$categoryCount, 'message'=>$message);
    }
    //Get locations by state
    public function getLocationsByState(Request $request)
    {
    	$state_code = $request->state_code;
        $cities     = City::select('id', 'name', 'state');
        if (!empty($state_code)) {
            $cities->where('state',$state_code);
        }
    	$cities     = $cities->get()->toArray();
    	$output = '<option value="">Select City</option>';
    	if (count($cities) > 0) {
    		foreach ($cities as $key => $value) {
    			$output .='<option value="'.$value['name'].'">'.$value['name'].'</option>';
    		}
    	}
    	return $output;
    	//return response()->json(['success' => true, 'data'=> $output]);
    }

    // Get state Deatil
    public function getStateDeatil($state_code)
    {
        $state = State::where('code', $state_code)->first();
        $stateName = isset($state->name) ? $state->name : null;
        return $stateName;
    }

    //Get feature list Batch
    public function getFeatureList($currentDate)
    {
        $featureList = DB::raw('(case   WHEN featured_from >= "'.$currentDate.'" AND featured_to IS NULL THEN 1
                    WHEN featured_to <= "'.$currentDate.'" AND featured_from IS NULL THEN 1
                    WHEN "'.$currentDate.'" BETWEEN featured_from AND featured_to  THEN 1
                    ELSE 0 END) as feature_list');
        return $featureList;
    }
}
