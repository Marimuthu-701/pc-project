<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\Sms;
use TextLocal;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function forgot(Request $request)
    {
        $input_data = $request->all();
        $validator  = Validator::make($input_data, [
            'mobile_number' => 'required|email',
            //'mobile_number' => 'required|numeric|digits:10'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => trans('auth.mobile_number_formate'),
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }
        $email = $request->mobile_number;

        //Send Email
        $sendOtpResponse = $this->passwordResetOtpEmail($email);
        return response()->json($sendOtpResponse);

        // Send Reset password otp
        /*$mobile_number   = $request->mobile_number;
        $messageString   = trans('messages.reset_otp_message');
        $sendOtpResponse = User::sendOtp($mobile_number, $messageString);
        return response()->json($sendOtpResponse);*/

        /*$response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        $message = trans($response);

        if($response == Password::RESET_LINK_SENT) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => $message,
        ]);*/
    }

    // Send Password Reset OTP Email
    public function passwordResetOtpEmail($email)
    {
        $returnResponse = array();
        $userinfo = User::where('email', $email)->first();
        $randomOtp = mt_rand(100000,999999);
        if ($userinfo) {
            try {
                $mailData = [
                    'code'=> $randomOtp,
                    'name' => $userinfo->first_name,
                ];
                $sendOtpEmail = new ResetPasswordMail($mailData);
                $checkOtp = Sms::where('user_id', $userinfo->id)->where('email', $email)
                            ->where('verify_status', User::STATUS_INACTIVE)->first();
                if ($checkOtp) {
                    $checkOtp->otp_number =  $randomOtp;
                    $sendOtp = $checkOtp->save();
                } else {
                    $sendOtp = Sms::create([
                        'user_id' => $userinfo->id, 
                        'email' => $email, 
                        'otp_number' => $randomOtp
                    ]);
                }
                $sendEmail = User::sendEmail($sendOtpEmail, $email);
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
        } else {
            return $returnResponse =[
                'success' => false,
                'message' => trans('messages.email_not_exist'),
            ];  
        }
    }
}
