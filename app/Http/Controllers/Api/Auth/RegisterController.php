<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Passport\Client;
use App\User;
use App\Blogger;
use App\Admin;

class RegisterController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = Client::find(2);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {

        $validate = \Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:admins,email|unique:users,email|unique:bloggers,email',
                'password' => 'required|min:8|confirmed'
            ]
        );

        if($validate->fails())
        {
            return response()->json(['errors' => $validate->errors()]);
        }

//        by default registration is open for Bloggers
        $blogger = Blogger::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $params = [
            'grant_type' => 'password',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '*'
        ];


        $request->request->add($params);

        $proxy = Request::create('oauth/token','POST');

        return \Route::dispatch($proxy);
    }
}
