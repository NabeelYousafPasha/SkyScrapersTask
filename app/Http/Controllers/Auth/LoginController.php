<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:user')->except('logout');
        $this->middleware('guest:blogger')->except('logout');
    }


    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        if (\Auth::guard('admin')->attempt([
                'email' => $request->email, 'password' => $request->password
            ], $request->get('remember')))
        {
//            dd('admin');
            $details = \Auth::guard('admin')->user();
            \Auth::guard('admin')->login($details);
            $user = $details['original'];
            session()->put(['user_guard' => 'admin']);
            return $user;
        }
        else if (\Auth::guard('user')->attempt([
                'email' => $request->email, 'password' => $request->password
            ], $request->get('remember')))
        {
//            dd('user');
            $details = \Auth::guard('user')->user();
            \Auth::guard('user')->login($details);
            $user = $details['original'];
            session()->put(['user_guard' => 'user']);
            return $user;
        }
        else if (\Auth::guard('blogger')->attempt([
                'email' => $request->email, 'password' => $request->password
            ], $request->get('remember')))
        {
//            dd('blogger');
            $details = \Auth::guard('blogger')->user();
            \Auth::guard('blogger')->login($details);
            $user = $details['original'];
            session()->put(['user_guard' => 'blogger']);
            return $user;
        }
        else
        {
//            return back()->withInput($request->only('email', 'remember'));
            dd('authentication failed: User email and password doest match.');
        }
    }


    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
//        dd($request->all());
        return $request->only($this->username(), 'password');
    }


    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }
}
