<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $loggedInUserGuard;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
//        $this->middleware('auth:admin');
//        $this->middleware('auth:user');
//        $this->middleware('auth:blogger');

//        $this->middleware(function ($request, $next) {
////            dd(session()->get('user_guard'));
//            switch (session()->get('user_guard'))
//            {
//                case 'admin':
//                    $this->middleware('auth:admin');
//                    break;
//                case 'user':
//                    $this->middleware('auth:user');
//                    break;
//                case 'blogger':
//                    $this->middleware('auth:blogger');
//                    break;
//                default:
//                    dd('Sorry! User can not proceed');
//            }
//            return $next($request);
//        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        dd(auth()->guard('blogger')->check());
        return view('home');
    }
}
