<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    /**
     * Method to login user and response access token
     * 
     */
    public function login() {
        if(Auth::attempt(['email' => request()->email, 'password' => request()->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('Api')->plainTextToken; 
            $success['name'] =  $user->name;
   
            return $this->sendResponse('User login successfully.', $success);
        } else {
            return $this->sendError('Unauthorised.', ['email' => 'Credentials does not match.'], 401);
        } 
    }

    /**
     * Method to logout user
     * 
     */
    public function logout() {
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        
        return $this->sendResponse('User has been logged out.', []);
    }
}
