<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Passport\Client;
use Auth;

class LoginController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = Client::find(2);
    }


    public function login(Request $request){
        $validate = \Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );

        if($validate->fails())
        {
            return response()->json([
                'errors' => $validate->errors(),
                'error_type' => 'Validation Errors',
                'status' => '400',
                'status_type' => 'Bad Request'
            ]);
        }


        if (Auth::attempt(
            [
                'email' => $request->email,
                'password' => $request->password
            ]
        )) {
            $user = Auth::user();


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

            // return \Route::dispatch($proxy);
            $response = \Route::dispatch($proxy);

            $json = (array) json_decode($response->getContent());
            $json['user'] = $user;
            $response->setContent(json_encode($json));
            return $response;

        }
        else {
            return response()->json([
                'error' => 'Unauthorized',
                'error_details' => 'User not found regarding this email or Password',
                'status' => '401',
                'access_token' => '401'
            ]);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        $validate = \Validator::make($request->all(),
            [
                'refresh_token' => 'required'
            ]
        );

        if($validate->fails())
        {
            return response()->json(['errors' => $validate->errors()]);
        }

        $params = [
            'grant_type' => 'password',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => $request->email,
            'password' => $request->password
        ];

        $request->request->add($params);

        $proxy = Request::create('oauth/token','POST');

        return \Route::dispatch($proxy);
    }


    public function logout(Request $request)
    {
        $accessToken = Auth::user()->token();

        \DB::table('oauth_refresh_tokens')
            ->where('access_token_id',$accessToken->id)
            ->update(['revoked' => true]);

        $accessToken->revoke();

        return response()->json([],204);
    }
}
