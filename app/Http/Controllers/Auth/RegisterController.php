<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\ValidationException;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\PartnerController;
use App\Mail\EmailVerificationMail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\State;
use App\Models\City;
use App\Models\Media;
use App\Models\Partner;
use App\Models\Facility;
use App\Models\Service;
use App\Models\Sms;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'email'     => 'required|email|max:255|unique:users',
            'first_name' => 'required|max:32',
            //'last_name'  => 'required|max:32',
            'password'  => 'required|min:6',
            'mobile_number' => 'required|numeric|digits:10|unique:users',
            'password_confirmation' => 'required_with:password|same:password',
            'user_state' => 'required',
            'user_city' => 'required',
            'postal_code'=>'required|numeric|digits:6',

        ];
        $messages = [
            'mobile_number.unique' => 'Mobile Number already registered with us.',
            'email.unique' => 'Email already registered with us.',
            'user_state.required' => 'The state field is required.',
            'user_city.required' => 'The city field is required.'
        ];
        return Validator::make($data, $rules, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if (!isset($data['name'])) {
            $data['name'] = trim($data['first_name'] . ' ' . $data['last_name']);
        }
        $enable_otp_verification = env('ENABLE_SIGNUP_OTP_VERIFICATION');
        $status = User::STATUS_PENDING;
        if (!$enable_otp_verification) {
            $status = User::STATUS_ACTIVE;
        }
        return User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'name'       => $data['name'],
            'email'      => $data['email'],
            'mobile_number' => $data['mobile_number'],
            'type'   => 'user',
            'status' => $status,
            'password' => Hash::make($data['password']),
            'state'    => $data['user_state'],
            'city'     => $data['user_city'],
            'postal_code' => $data['postal_code'],
        ]);
    }

    /************ Custom Function ************/

    public function register(Request $request)
    {
        $input_data = $request->all();
        $validator = $this->validator($input_data);
        
        $redirect_url = route('home');
        if(env('ENABLE_SIGNUP_OTP_VERIFICATION')) {
            $redirect_url = route('mobile.number.verification');
        } else {
            $redirect_url = route('email.verify');
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => trans('messages.incorrect_form_values'),
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        $user_data = $this->create($input_data);
        
        $credentials = $request->only('mobile_number', 'password');

        if ($user_data) {
            if(Auth::attempt($credentials)) {                
                return response()->json([
                    'success' => true,
                    'message' => trans('messages.user_register_success'),
                    'data'    => $user_data,
                    'redirect_url' => $redirect_url, //url($this->redirectTo),
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => trans('messages.login_failed'),
                'redirect_url' => url($this->redirectTo),
            ]);
        }

    }
    
    /* Service Provider Registration section*/
    //create partner account creation
    protected function providerStore(array $data)
    {
        $enable_otp_verification = env('ENABLE_SIGNUP_OTP_VERIFICATION');
        $status = User::STATUS_ACTIVE;
        if ($enable_otp_verification) {
            $mobile_verified = User::STATUS_ACTIVE;
            $email_verified  = User::STATUS_INACTIVE;
        } else {
            $email_verified  = User::STATUS_ACTIVE;
            $mobile_verified = User::STATUS_INACTIVE;
        }
        $user = User::create([
            'email' => $data['email'],
            'mobile_number' => $data['mobile_number'],
            'mobile_number_verified'=> $mobile_verified,
            'email_verified'=> $email_verified,
            'type'   => 'partner',
            'status' => $status,
            'password' => Hash::make($data['password']),
        ]);
        return $user;
    }

    // Provider Registration
    public function providerRegister(Request $request)
    {
        $formData  = $request->all();
        if ($formData) {
            //Existing user email and mobile number validate
            $rules = [
                'mobile_number' => 'required|numeric|digits:10|unique:users',
                'email'=> 'required|email|max:255|unique:users',
                'password'=> 'required|min:6',
            ];
            $messages = [
                'mobile_number.unique' => 'Mobile Number already registered with us.',
                'email.unique' => 'Email already registered with us.',
            ];
            $validator = Validator::make($formData, $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => trans('messages.incorrect_form_values'),
                    'errors' => $validator->getMessageBag()->toArray()
                ]);
            } else {
                $providerDetails = [
                    'email' => $request->email, 
                    'mobile_number' => $request->mobile_number,
                    'password' => $request->password,
                    'tries_limit'=> 1,
                ];
                session::put('provider_details', $providerDetails);
                Session::put('mobile_number', $request->mobile_number);
                $phone_verify    = route('phone.verify');
                $messageString   = trans('messages.mobile_verification_otp_msg');
                $enable_otp_verification = env('ENABLE_SIGNUP_OTP_VERIFICATION', true);
                if($enable_otp_verification) {
                    $sendOtpResponse = User::sendOtp($request->mobile_number, $messageString, User::REGISTER_OTP);
                    $sendOtpResponse['redirect_url'] = $phone_verify;
                    return response()->json($sendOtpResponse);
                } else {
                    $email = $request->email;
                    $sendOtpEmail = $this->emailVerificationEmail($email);
                    $sendOtpEmail['redirect_url'] = $phone_verify;
                    return response()->json($sendOtpEmail);
                    /*$providerData = Session::get('provider_details');
                    Session::forget('provider_details');
                    $createdProvider = $this->providerCreate($providerData);
                    return response()->json($createdProvider);*/
                }
            }
        }
        return view('partner');
    }

    // Create Provider
    public function providerCreate(array $provider_data)
    {
        $redirectPartnertype = route('service.provider');
        $returnResponse = array();
        try {
            $loginCredential = ['email'=> $provider_data['email'], 'password'=> $provider_data['password']];
            $partner_data = $this->providerStore($provider_data);
            if ($partner_data) {
                if (Auth::attempt($loginCredential)) {
                    return $returnResponse = [
                        'success' => true,
                        'message' => trans('messages.valid_otp'),
                        'data'    => $partner_data,
                        'redirect_url' => $redirectPartnertype,
                    ];
                }
            } else {
                return $returnResponse = [
                    'success' => false,
                    'message' => trans('messages.create_failed'),
                ];
            }
        } catch (\Exception $e) {
            return $returnResponse = [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    //Verify OTP
    public function otpVerification(Request $request)
    {
        $redirectURL = route('home');
        $enable_otp_verification = env('ENABLE_SIGNUP_OTP_VERIFICATION');
        $authUserMobile = Auth::user()->mobile_number ?? $request->mobile_number;
        $data   = $request->all();
        $getOtpDetail = Sms::where('user_id', null)->where(['verify_status' => 0]);
        if ($enable_otp_verification) {
            $getOtpDetail->where('mobile_number', $authUserMobile);
        } else {
            $getOtpDetail->where('email', $request->mobile_number);
        }
        $getOtpDetail = $getOtpDetail->first();
        $getOtp       = $getOtpDetail->otp_number;
        $providerData = Session::get('provider_details');
        if ($getOtp == $data['otp_number']) {
            if ($providerData) {
                Session::forget('provider_details');
                $createdProvider = $this->providerCreate($providerData);
                $getOtpDetail->verify_status = 1;
                $getOtpDetail->user_id = $createdProvider['data']->id;
                $getOtpDetail->mobile_number = $createdProvider['data']->mobile_number;
                $getOtpDetail->email = $createdProvider['data']->email;
                $getOtpDetail->save();
                return response()->json($createdProvider);
            }
            return response()->json([
                'success' => false,
                'message' => trans('messages.something_wrong'),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => trans('messages.invalid_otp'),
            ]);
        }
    }

    public function emailVerificationEmail($email)
    {
        $returnResponse = array();
        $otp_code = mt_rand(100000,999999);
        try {
            $mailData = ['code'=> $otp_code];
            $mail_class = new EmailVerificationMail($mailData);
            $checkOtp = Sms::where('user_id', null)->where('email', $email)
                        ->where('verify_status', User::STATUS_INACTIVE)->first();
            if ($checkOtp) {
                $checkOtp->otp_number =  $otp_code;
                $sendOtp = $checkOtp->save();
            } else {
                $sendOtp = Sms::create([
                    'email' => $email, 
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
}
