<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Partner;
use App\Models\City;
use App\Models\State;
use App\Models\Testimonial;
use App\Models\PartnerService;
use App\Mail\NewTestimonialNotificationMail;
use App\Models\User;
use Session;
use Auth;
use Image;

class PageController extends Controller
{
    /**
     * Global function to return image from storage folder
     *
     * @param  object $request
     * @return image object
     */
    public function viewImage(Request $request, $arg1, $arg2 = '', $arg3 = '')
    {
        $action = $request->route()->getAction();
        if (isset($action['image_folder_path']) && $action['image_folder_path'] != '') {
            $image_path = $action['image_folder_path'];

            $filename = $width = $height = '';
            if (!empty($arg2)) {
                $filename = $arg2;
                $size = str_replace(array('x', 'X'), 'x', $arg1);
                list($width, $height) = explode('x', $size . 'x');
            } else {
                $filename = $arg1;
            }

            $prefix_path = storage_path('app/public/' . $image_path) . '/';

            $path = $prefix_path . $filename;
            if (file_exists($path) && is_file($path)) {
                // this condition can be removed if you face any slow in image appear.
                if ($width && $height) {
                    $width = $width ? $width : null;
                    $height = $height ? $height : null;
                    return Image::make($path)
                            ->fit($width, $height, function ($constraint) {
                                $constraint->upsize();
                            }, 'top')->response();
                } elseif ($width || $height) {
                    $width = $width ? $width : null;
                    $height = $height ? $height : null;
                    return Image::make($path)
                            ->resize($width, $height, function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            })->response();
                } else {
                    return Image::make($path)->response();
                }
            }
        }
    }

    //About us pages
    public function aboutUs()
    {
        $states = State::all();
        $cities = City::all();
        return view('pages.about-us', compact('cities', 'states'));
    }

    //Services pages
    public function services()
    {
        $services = Service::where('status', Partner::ACTIVE_STATUS)->orderByRaw('position = 0 , position')->get();
        $states = State::all();
        $cities = City::all();
        $postal_code = '';
        $city = '';
        $state= '';
        if (Auth::check()) {
            if(Auth::user()->type == User::TYPE_USER) {
                $postal_code = isset(Auth::user()->postal_code) ?Auth::user()->postal_code : null;
                $city = isset(Auth::user()->city) ?Auth::user()->city : null;
                $state = isset(Auth::user()->state) ? Auth::user()->state :null;
            }else {
                $serviceDetail = PartnerService::whereUserId(Auth::id())->first();
                $city = isset($serviceDetail->city) ? $serviceDetail->city : null;
                $state = isset($serviceDetail->state) ? $serviceDetail->state :null;
                $postal_code = isset($serviceDetail->postal_code) ? $serviceDetail->postal_code : null;
            }
        }
        return view('pages.services', compact('services', 'cities', 'states', 'city', 'state', 'postal_code'));
    }

    //Blog page
    public function blog()
    {
        $states = State::all();
        $cities = City::all();
        return view('pages.blog', compact('cities', 'states'));
    }

    //Faq pag
    public function faq()
    {
        $states = State::all();
        $cities = City::all();
        return view('pages.faq-page', compact('cities', 'states'));
    }

    //Testimonials page
    public function testimonial()
    {
        $pageCount = env('TESTIMONIALS_PAGENATION', 10);
        $states = State::all();
        $cities = City::all();
        $getTestimonials = Testimonial::whereStatus(User::STATUS_ACTIVE)->paginate($pageCount);
        return view('pages.testimonial', compact('cities', 'states' ,'getTestimonials'));
    }

    // Create Testmonial for customer
    public function testimonialCreate(Request $request)
    {
        $toEmail = env('NEW_REVIEW_AND_TESTIMONIAL_NOTIFICATION_EMAILS');
        if ($request->all()) {
            $user_id = !Auth::guest() ? Auth::id() : null;
            $testimonialData = [
                'user_id' => $user_id,
                'name'  => $request->name,
                'email' => $request->email,
                'description' => $request->comments,
                'rating'=> $request->rating,
                'address'=>$request->address,
                'status'=> User::STATUS_PENDING,
            ];
            try {
                $redirect_url = route('testimonial');
                $addTestimonial = Testimonial::create($testimonialData);
                $token = generateToken($addTestimonial->id);
                $mailData = [
                    'id' => $addTestimonial->id,
                    'name'  => $request->name,
                    'email' => $request->email,
                    'description' => $request->comments,
                    'rating'=> $request->rating,
                    'address'=> $request->address,
                    'token'=> $token,
                ];
                $newTestimonialMail = new NewTestimonialNotificationMail($mailData);
                $sendEmail = User::sendEmail($newTestimonialMail, $toEmail);
                if ($addTestimonial) {
                    Session::flash('message', trans('messages.testimonials_msg'));
                    return response()->json([
                        'success' => true,
                        'message' => trans('messages.created_testimonial_msg'),
                        'data'    => $testimonialData,
                        'redirect_url' => $redirect_url,
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
                    'message' => $e->getMessage(),
                ]);
            }
        }
        return view('pages.testimonial-create');
    }

    //Contacting page
    public function contact()
    {
        $states = State::all();
        $cities = City::all();
        return view('pages.contact', compact('cities', 'states'));
    }

    // Terms and condtions page
    public function termAndCondition()
    {
        $states = State::all();
        $cities = City::all();
        return view('pages.term-and-condition', compact('cities', 'states'));
    }

    // Privacy and policy page
    public function privacyAndPolicy()
    {
        return view('pages.privacy-policy');
    }

    //below function to individual service details
    public function ambulanceService()
    {
        return view('pages.services.ambulance');
    }

    public function doctorConsultantService()
    {
        return view('pages.services.doctor-consultant');
    }

    public function nursingService()
    {
        return view('pages.services.nurse');
    }

    public function physiotherapyService()
    {
        return view('pages.services.physiotherapy');
    }

    public function trainedAttendantService()
    {
        return view('pages.services.trained-attendant');
    }

    public function labTestService()
    {
        return view('pages.services.lab');
    }

    public function medicalService()
    {
        return view('pages.services.medical');
    }

    public function pharmacyService()
    {
        return view('pages.services.pharmacy');
    }

    public function criticalCareService()
    {
        return view('pages.services.critical-care');
    }
}
