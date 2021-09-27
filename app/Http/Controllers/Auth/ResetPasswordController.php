<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\ValidationException;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\Sms;
use App\Models\User;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected function validator(array $data)
    {
        $rules = [
            //'token' => 'required',
            //'mobile_number'=> 'required|numeric|digits:10',
            'mobile_number'=> 'required|email',
            'password'  => 'required|min:6',
            'password_confirmation' => 'required_with:password|same:password'
        ];

        return Validator::make($data, $rules);
    }
    
    public function reset(Request $request) {
        $input_data = $request->all();
        $validator = $this->validator($input_data);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => trans('messages.incorrect_form_values'),
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        //$user = User::where('mobile_number', $input_data['mobile_number'])->first();
        $user = User::where('email', $input_data['mobile_number'])->first();
        // Custom Reset password
        if (!is_null($user)) {
            try {
                $user->password = Hash::make($input_data['password']);
                if ($user->save()) {
                    return response()->json([
                        'success' => true,
                        'message' => trans('passwords.reset'),
                        'redirect_url' => url('login')
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'failed',
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => trans('messages.something_wrong'),
                ]);
            }
        }
        /*$response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        $message = trans($response);

        if($response == Password::PASSWORD_RESET) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'redirect_url' => url('login')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $message,
        ]);*/
    }

    //Verify OTP
    public function verifyOtp(Request $request)
    {
        $data   = $request->all();
        //$getOtpDetail = Sms::where('mobile_number', $data['mobile_number'])->where(['verify_status' => 0])->first();
        $getOtpDetail = Sms::where('email', $data['mobile_number'])->where(['verify_status' => 0])->first();
        $userData     = User::find($getOtpDetail->user_id);
        $getOtp       = $getOtpDetail->otp_number;
        if ($getOtp == $data['otp_number']) {
            $getOtpDetail->verify_status = 1;
            $getOtpDetail->mobile_number = $userData->mobile_number;
            $getOtpDetail->save();
            return response()->json([
                'success' => true,
                'message' => trans('messages.valid_otp'),
                'data' => $userData,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => trans('messages.invalid_otp'),
            ]);
        }
    }
}
