<?php

namespace App\Modules\Incidents\Controllers;

use App\Modules\Incidents\Models\User;
use \Firebase\JWT\JWT;

class AuthController
{
	/**
     * Get the jwt token for further work
     * 
     * @author spattanayak4you@gmail.com
     * @date 13 Sept
     * @return json
     */
    public function login($request, $response)
    {
        $serverStatusCode = OPERATION_OKAY;
        $jsonResponse = [
            'status' => 0,
            'message' => 'Invalid login',
        ];
        $allPostPutVars = $request->getParsedBody();
        if (!empty($allPostPutVars)
            && !empty($allPostPutVars['email']) && !empty($allPostPutVars['password'])
        ) {
            $userData = [
                'email' => $allPostPutVars['email'],
                'password' => $allPostPutVars['password'],
            ];
            $userObj = new User();
            $getUserDetails = $userObj->where('email', $userData['email']);
            if ($getUserDetails->count() > 0) {
            	$userDetails = $getUserDetails->first()->toArray();
            	if (password_verify($userData['password'], $userDetails['password'])) {
            		$token = array(
                        "iss" => isset($userDetails['email'])
                        ? $userDetails['email'] : "ISSUER", // Issuer
                        "aud" => "audience", // Audience
                        "iat" => date_time(
                            'today', [], 'timestamp'
                        ), // Issued-at time
                        "exp" => date_time('add', ['days' => 3], 'timestamp'),
                    );
                    $getJWTSecret = get_app_settings('jwt_secret');
                    $jwtObj = new JWT();
                    $jwt = $jwtObj->encode($token, $getJWTSecret);

                    $jsonResponse = [
                        'status' => 1,
                        'message' => "Token Created Successfully",
                        'jwt_token' => $jwt,
                        'expired_at' => $token['exp'],
                    ];
            	}
            }
        }

        return response(
            $response, ['data' => $jsonResponse, 'status' => $serverStatusCode]
        );
    }
}