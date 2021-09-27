<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\PartnerService;
use App\Models\Service;
use App\Models\AdminUser;
use App\Models\User;
use App\Models\Rating;
use DataTables;
use Validator;
use Flash;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Datatables $datatable)
    {
        if ($request->ajax()) {
            $reviews = Rating::get();
            return $this->datatable($reviews, $request);
        }
        return view('admin.reviews.index');

    }

    protected function datatable($query, $request)
    {
        return Datatables::of($query)
            ->addColumn('id', function ($query) {
                return $query->id;
            })->addColumn('body', function ($query) {
                return Str::limit($query->body, 100, '...');
            })->addColumn('rating', function ($query) {
                return $query->rating;   
            })->addColumn('average_rating', function ($query) {
                $service = PartnerService::find($query->reviewrateable_id);
                $average_rating = $service ? $service->averageRatingByType($service->id, User::TYPE_SERVICE) : null;
                $averge = isset($average_rating[0]['avarage']) ? number_format($average_rating[0]['avarage'], 2) : null;
                return $averge;   
            })->addColumn('reviewrateable_id', function ($query) {
                $service = PartnerService::find($query->reviewrateable_id);
                $serviceName = null;
                if($service) {
                    $serviceName = $service->name;
                }
                return $serviceName;
            })->addColumn('author_id', function ($query) {
                $customer = User::find($query->author_id);
                $customerName = null;
                if ($customer) {
                    if($customer->type == User::TYPE_USER) {
                        $customerName = $customer->first_name;
                    } elseif ($customer->type == User::TYPE_PARTNER) {
                        $customerName = isset($customer->service) ? $customer->service->name : null;
                    }
                }
                return $customerName;
            })->addColumn('recommend', function ($query) {
                return ($query->recommend == Service::IS_FEATURED) ? trans('common.verified') : trans('common.not_verified');
            })->addColumn('approved', function ($query) {
                $view_path = 'approve';
                $approval_status = $query->approved;
                if ($approval_status == User::STATUS_PENDING) {
                        return view('admin.partials.action', [
                        'item' => $query,
                        'source' => 'reviews',
                        'approval' => true,
                        'approval_path'=> $view_path,
                    ]);
                }else if ($approval_status == User::STATUS_ACTIVE) {
                        return 'Approved';
                }else {
                    return '-';
                }
            })->addColumn('created_at', function ($query) {
                return $query->created_at;
            })->addColumn('updated_at', function ($query) {
                return $query->updated_at;
            })->addColumn('action', function ($query) {
                return view('admin.partials.action', [
                    'item' => $query,
                    'source' => 'reviews',
                    'disabled' => false,
                    'show'=> true,
                ]);
            })
            ->rawColumns(['action', 'status', 'name'])
            ->make(true);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $review = Rating::find($id);
        $provider_name = null;
        if(isset($review->reviewrateable_id) && $review->reviewrateable_id) {
            $service = PartnerService::find($review->reviewrateable_id);
            if ($service) {
                $provider_name = $service->name;
            }
        }
        return view('admin.reviews.view', compact('review', 'provider_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $review = Rating::find($id);
        $service_id = $review->reviewrateable_id;
        $service = PartnerService::find($service_id);
        $provider_name = null;
        if ($service) {
            $provider_name = $service->name;
        }
        $featureList = Service::setFeatureList();
        return view('admin.reviews.edit', compact('review', 'provider_name', 'featureList'));
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
        $review = Rating::find($id);
        try {
            $review->rating = $request->rating;
            $review->body = $request->description;
            $review->recommend = $request->recommend;
            $review->save();
            Flash::success(trans('messages.reviews_update'));
            return redirect()->route('admin.reviews.index');

        } catch (\Exception $e) {
            Flash::error(trans('messages.something_wrong'));
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = Rating::where('id',$id)->delete();
        Flash::success(trans('messages.reviews_delete'));
        return redirect()->route('admin.reviews.index');
    }

    public function reviewApproval($id)
    {
        $review = Rating::find($id);
        $review->approved = User::STATUS_ACTIVE;
        if ($review->save()) {
            Flash::success(trans('messages.review_approvel_msg'));
            return redirect()->route('admin.reviews.index');
        }
        return redirect()->back()->withInput($input);
    }
}
