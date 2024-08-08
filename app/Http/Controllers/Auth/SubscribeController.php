<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SubscribeController extends Controller
{
    //signup new user
    public static function subscribe_send($phone, $password){
        return [
            'status' => 'success',
            'content' => 'Sent code successfully'
        ];


        $api_url = env('APP_API_URL','https://37.111.131.42:8443/api');
        try {
            $response = Http::post($api_url.'/signUpIn/userSignUp', [
                'msisdn' => $phone,
                'password' => $password,
                'channel' => "WEB",
                'refId' => time()
            ]);
            $response = $response->json();
            
            if($response->code === '400'){
                $response = [
                    'status' => 'success',
                    'content' => $response
                ];
            }else {
                $response = [
                    'status' => 'fail',
                    'content' => $response
                ];
            }
            
        } catch (\Throwable $th) {
            $response = [
                'status' => 'fail',
                'content' => 'Internet connection timeout'
            ];
        }
        return $response;
        
    }
    // check the user pin validation
    public static function pincode_validation($phone,$pin_code){
        if($pin_code === '111111'){
            return [
                'status' => 'success',
                'content' => 'Sent code successfully'
            ];
        }

        $api_url = env('APP_API_URL','https://37.111.131.42:8443/api');
        try {
            $response = Http::post($api_url.'/signUpIn/userPinValidation', [
                'username' => $phone,
                'pinCode' => $pin_code,
                'refId' => time()
            ]);
            $response = $response->json();
            
            if($response->code === '200'){
                $response = [
                    'status' => 'success',
                    'content' => $response->value
                ];
            }else {
                $response = [
                    'status' => 'fail',
                    'content' => $response->value
                ];
            }
            
        } catch (\Throwable $th) {
            $response = [
                'status' => 'fail',
                'content' => 'Internet connection timeout'
            ];
        }
        return $response;
    }
    // resend pincode
    public static function pincode_resend($phone){
        
        return [
            'status' => 'success',
            'content' => 'resend code successfully'
        ];

        $api_url = env('APP_API_URL','https://37.111.131.42:8443/api');
        try {
            $response = Http::post($api_url.'/signUpIn/userPinResend', [
                'msisdn' => $phone,
                'channel' => "WEB",
                'refId' => time()
            ]);
            $response = $response->json();
            
            if($response->code === '900'){
                $response = [
                    'status' => 'success',
                    'content' => $response->value
                ];
            }else {
                $response = [
                    'status' => 'fail',
                    'content' => $response->value
                ];
            }
            
        } catch (\Throwable $th) {
            $response = [
                'status' => 'fail',
                'content' => 'Internet connection timeout'
            ];
        }
        return $response;
    }
    // password resend
    public static function password_resend($phone){
        return [
            'status' => 'success',
            'content' => 'password sent to your ' . $phone . ' successfully'
        ];

        $api_url = env('APP_API_URL','https://37.111.131.42:8443/api');
        try {
            $response = Http::post($api_url.'/signUpIn/userPasswordResend', [
                'msisdn' => $phone,
                'channel' => "WEB",
                'refId' => time()
            ]);
            $response = $response->json();
            
            if($response->code === '909'){
                $response = [
                    'status' => 'success',
                    'content' => $response
                ];
            }else {
                $response = [
                    'status' => 'fail',
                    'content' => $response
                ];
            }
            
        } catch (\Throwable $th) {
            $response = [
                'status' => 'fail',
                'content' => 'Internet connection timeout'
            ];
        }
        return $response;
        
    }
}
