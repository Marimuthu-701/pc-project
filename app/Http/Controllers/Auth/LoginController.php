<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $input_data = $request->all();

        $validator = Validator::make($input_data, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => trans('messages.invalid_login'),
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        $user = User::where($this->getLoginField($request), $request->username)->first();
        if ($user && $user->status == User::STATUS_PENDING) {
            return response()->json([
                'success' => false,
                'message' => trans('messages.waiting_for_approval'),
                'redirect_url' => url($this->redirectTo),
            ]);
        } elseif ($user && $user->status == User::STATUS_INACTIVE) {
            return response()->json([
                'success' => false,
                'message' => trans('messages.account_inactive'),
                'redirect_url' => url($this->redirectTo),
            ]);
        }

        $credentials = $this->credentials($request);
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $previousURL = isset($request->previous_url) ? $request->previous_url : null;
            return response()->json([
                'success' => true,
                'message' => trans('messages.login_success'),
                'data'    => [],
                'redirect_url' => $previousURL ? $previousURL :url($this->redirectTo),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => trans('messages.invalid_login'),
            'redirect_url' => url($this->redirectTo),
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    protected function getLoginField(Request $request)
    {
        $field = 'email';
        if (is_numeric($request->get('username'))) {
            $field = 'mobile_number';
        }
        return $field;
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
    */
    protected function credentials(Request $request)
    {
        return [
            $this->getLoginField($request) => $request->get('username'), 
            'password' => $request->get('password'), 
            'status' => User::STATUS_ACTIVE
        ];
    }

    public function logout(Request $request)
    {
        if ($request->session()->has('url.intended')) {
            $request->session()->forget('url.intended');
        }
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/')->with('logout', trans('messages.logut_message'));
    }
}
