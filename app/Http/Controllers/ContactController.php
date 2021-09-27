<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\ValidationException;
use App\Mail\ContactFormMail;
use Session;
use Mail;


class ContactController extends Controller
{
    
    //ContacForm send Email
    public function contactEmail(Request $request)
    {
    	$form_data = $request->all();
    	$validator = $this->contactFormValidation($form_data);
        if ($validator->fails()) {
			return response()->json([
			    'success' => false,
			    'message' => trans('messages.incorrect_form_values'),
			    'errors' => $validator->getMessageBag()->toArray()
			]);
        }

        $mailData = [
           'name'	  => $request->contact_name,
		   'mobile_no'=> $request->contact_mobile,
		   'email'	  => $request->contact_email,
		   'user_message' => $request->message
        ];

        try {

        	$sendEmail = array();
        	$toEmails  = explode(',', env('CONTACT_TO_MAILS'));
        	// send contact email
        	if (count($toEmails) > 0) {
        		foreach ($toEmails as $key => $email ) {
            		$sendEmail[] = Mail::to($email)->send(new ContactFormMail($mailData));
        		}
        	} 
            if ($sendEmail) {
                Session::flash('message', trans('messages.contact_success'));
                return response()->json([
                    'success' => true,
                    'message' => trans('messages.contact_success'),
                    'data'    => '',
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
                'message' => trans('messages.something_wrong'), //$e->getMessage(),
            ]);
        }
    }

    // Contact form input field validation
    public function contactFormValidation(array $data)
    {
    	$rules = [
            'contact_name'=>'required',
            'contact_mobile' =>'numeric|digits:10',
            //'contact_email' => 'required|email',
            'message'=> 'required',
        ];
        return Validator::make($data, $rules);
    }
}
