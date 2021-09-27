<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Socialite;
use Auth;
use Exception;
use App\Models\User;

class SocialLoginController extends Controller
{
    /**
     * Declar global variables
     * @var string
     */
    protected $redirectTo = 'home';
    protected $googleProvider   = User::GOOGLE_PROVIDER;
    protected $facebookProvider = User::FACEBOOK_PROVIDER;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
    * Create a new user
    * @return user data
    */
    public function create($data)
    {
        $params = [
            'password' => bcrypt(Str::random(6)),
            'type'     => 'user',
            'status'   => User::STATUS_ACTIVE,
        ];

        $request = array_merge($data, $params);
        $user = User::create($request);
        return $user;
    }

    /**
    * Redirect to google account page
    * @return to account details
    */
    public function redirectToGoogle()
    {
    	return Socialite::driver($this->googleProvider)->stateless()->redirect();
    }

    /**
    * Get Google account details.
    * Check detail in user table if have not stored
    * @return to home page
    */
    public function googleAccountCallback()
    {
    	try {
            $social_user = Socialite::driver($this->googleProvider)->stateless()->user();
            if (!$social_user) {
                return redirect('/login')->with('error', trans('messages.something_wrong'));
            }

            $email = $social_user->email;
            $name = $social_user->name;

            $user = User::where('google_id', $social_user->id)->orWhere('email', $email)->first();
            if ($user) {
                if ($user->google_id == null) {
                    $user->google_id = $social_user->id;
                    $user->save();
                }
            } else {
                $first_name = $name;
                if (isset($social_user->user['given_name']) && $social_user->user['given_name']) {
                    $first_name = $social_user->user['given_name'];
                }
                $last_name = null;
                if (isset($social_user->user['family_name']) && $social_user->user['family_name']) {
                    $last_name = $social_user->user['family_name'];
                }

                $request = [
                    'first_name'  => $first_name,
                    'last_name'   => $last_name,
                    'email'       => $email,
                    'google_id'   => $social_user->id,
                ];
                $user = $this->create($request);
            }
            Auth::login($user);
            return redirect()->route($this->redirectTo);

    	} catch (Exception $e) {
    		return redirect('/login')->with('error', trans('messages.something_wrong'));
    	}
    }

    /**
    * Redirec to facebook login page
    * @return user detail
    */
    public function redirectToFacebook()
    {
      return Socialite::driver($this->facebookProvider)->stateless()->redirect();
    }

    /** 
    *Get user details and Check in user table if have data set login else stored and set login
    *@return to home page
    */
    public function facebookAccountCallback()
    {
        try {
            $social_user = Socialite::driver($this->facebookProvider)->fields(['name', 'first_name', 'last_name', 'email'])->stateless()->user();
            if (!$social_user) {
                return redirect('/login')->with('error', trans('messages.something_wrong'));
            }

            $email = $social_user->email;
            if ($email == null) {
                $email = $social_user->id . '@facebook.com';
            }
            $name = $social_user->name;

            $user = User::where('facebook_id', $social_user->id)->orWhere('email', $email)->first();
            if ($user) {
                if ($user->facebook_id == null) {
                    $user->facebook_id = $social_user->id;
                    $user->save();
                }
            } else {
                $first_name = $name;
                if (isset($social_user->user['first_name']) && $social_user->user['first_name']) {
                    $first_name = $social_user->user['first_name'];
                }
                $last_name = null;
                if (isset($social_user->user['last_name']) && $social_user->user['last_name']) {
                    $last_name = $social_user->user['last_name'];
                }

                $request = [
                    'first_name'  => $first_name,
                    'last_name'   => $last_name,
                    'email'       => $email,
                    'facebook_id' => $social_user->id,
                ];
                $user = $this->create($request);
            }
            Auth::login($user);
            return redirect()->route($this->redirectTo);

        } catch (Exception $e) {
            return redirect('/login')->with('error', trans('messages.something_wrong'));
        }
    }
}
