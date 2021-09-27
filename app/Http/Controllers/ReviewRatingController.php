<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PartnerService;
use App\Mail\NewReviewNotificationMail;
use App\Models\Partner;
use App\Models\Rating;
use App\Models\User;
use Auth;
use DB;

class ReviewRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type, $id)
    {
        $partnerSevice = PartnerService::find($id);
        $slug = $partnerSevice->slug;
        $providerName    = $partnerSevice->name;
        return view('review-rating', compact('type', 'id', 'providerName', 'slug'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
           return response()->json([
                'success' => false,
                'message' => trans('messages.login_failed'),
            ]); 
        }
        $toEmail = env('NEW_REVIEW_AND_TESTIMONIAL_NOTIFICATION_EMAILS');
        $id   = $request->partner_id;
        $type = $request->partner_type;
        $partnerService = PartnerService::find($id);
        $provider_name  =  $partnerService->name;
        $slug = $partnerService->slug;
        $existRating = '';
        // Customer Name
        $customer = User::find(Auth::id());
        $customerName = null;
        if ($customer) {
            if($customer->type == User::TYPE_USER) {
                $customerName = $customer->first_name;
            } elseif ($customer->type == User::TYPE_PARTNER) {
                $customerName = isset($customer->service) ? $customer->service->name : null;
            }
        }

        $ratingData = [
            /*'title' => $request->title,*/
            'body' => $request->comments,
            'rating' => $request->rating,
            'recommend' => 0,
            'approved' => 2,
        ];
        try {
            $existRating  = $this->existingRating($partnerService->id);
            if ($existRating) {
                return response()->json($existRating);
            }
            $addRating = $partnerService->rating($ratingData, Auth::user());
            $token = generateToken($addRating->id);
            $mailData = [
                'id' => $addRating->id,
                'provider_name' => $provider_name,
                'customer_name' => $customerName,
                'rating' => $request->rating,
                'description' => $request->comments,
                'token'=>$token,
            ];
            $newReviewMail = new NewReviewNotificationMail($mailData);
            $sendEmail = User::sendEmail($newReviewMail, $toEmail);
            if ($addRating) {
                return response()->json([
                    'success' => true,
                    'message' => trans('messages.rating_success_msg'),
                    'data'    => $ratingData,
                    'redirect_url'=> route('type.slug', ['type'=>$type, 'slug'=>$slug]),
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => trans('messages.added_failed'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors'  => 1,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // Existing Rating Check
    public function existingRating($provider_id)
    {
        $type = 'App\Models\PartnerService';   
        $existRating = Rating::where('author_id', Auth::id())
                     ->where('reviewrateable_type', $type)
                     ->where('reviewrateable_id', $provider_id)->count();
        if ($existRating) {
            $responseArray = [
                'success' => false,
                'message' => trans('messages.exit_error_rating'),
                'data'    => $existRating,
            ];
            return $responseArray;
        }
    }
}
