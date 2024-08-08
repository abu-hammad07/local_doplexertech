<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Auth\SubscribeController;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    // Handle Sign In
    public function signin(Request $request)
    {
        $credential = $request->only('phone', 'password');
        $rememberMe = $request->input('remember_me', false);

        $rule = [
            'phone' => 'required|regex:/^[0-9]{10,15}$/',
            'password' => 'required',
            'remember_me' => 'boolean',
        ];

        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation Error', 'errors' => $validator->errors(), 'status' => 422]);
        }

        if (!Auth::attempt($credential, $rememberMe)) {
            return response()->json(['message' => 'Invalid Credential', 'status' => 401]);
        }

        $user = Auth::user();
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json(['token' => $token, 'message' => 'Login Successfully!', 'user' => $user, 'status' => 200]);
    }

    // Handle SignUp
    public function signup(Request $request)
    {
        $credential = $request->only('name', 'phone', 'password', 'password_confirmation');

        $rule = array(
            'name' => 'required',
            'phone' => 'required|regex:/^[0-9]{10,15}$/|unique:users',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required'
        );

        $validator = Validator::make($credential, $rule);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation Error!', 'errors' => $validator->errors(), 'status' => 422]);
        }

        $res = SubscribeController::subscribe_send($request['phone'], $request['password']);

        if ($res['status'] === 'fail') {
            return response()->json(['message' => 'Something Went Wrong', 'status' => 401]);
        } else {
            return response()->json(['message' => 'Sent Pincode Correctly!', 'status' => 200]);
        }
    }

    // Register Validated Users
    public function registerValidatedUser(Request $request)
    {
        $user = new User;
        $user->usertype = 'User';
        $user->name = $request['name'];
        $user->phone = $request['phone'];
        $user->password = bcrypt($request['password']);
        $user->subscribe_state = 1;
        $user->save();

        return $this->signin($request);
    }

    // Subscribe User
    public function subscribe(Request $request)
    {
        $pin_code = $request['pincode'];

        $res = SubscribeController::pincode_validation($request['phone'], $pin_code);

        if ($res['status'] === 'success') {
            return $this->registerValidatedUser($request);
        } else {
            return response()->json(['message' => 'Invalid Request!', 'status' => 401]);
        }
    }

    // Resend Pincode
    public function resendCode(Request $request)
    {
        $res = SubscribeController::pincode_resend($request['phone']);

        if ($res['status'] === 'success') {
            return response()->json(['message' => $res['content'], 'status' => 200]);
        } else {
            return response()->json(['message' => $res['content'], 'status' => 401]);
        }
    }

    // Forgot Password
    public function forgotPassword(Request $request)
    {
        $data = $request->only('phone');

        $rule = ['phone' => 'required|regex:/^[0-9]{10,15}$/|exists:users'];

        $validator = Validator::make($data, $rule);

        if ($validator->fails()) {
            return response()->json(['message' => 'PhoneNumber is not valid', 'status' => 422]);
        }

        $res = SubscribeController::password_resend($request->phone);

        if ($res['status'] === 'success') {
            return response()->json(['message' => $res['content'], 'status' => 200]);
        } else {
            return response()->json(['message' => $res['content'], 'status' => 401]);
        }
    }

    // Refresh the token
    public function refreshToken(Request $request)
    {
        try {
            $user = $request->user();
            $user->tokens()->delete();
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['token' => $token, 'message' => 'Refreshed Token Successfully!', 'status' => 200]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Invalid Request!', 'status' => 401]);
        }
    }

    // Handle Logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully', 'status' => 200]);
    }
}