<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RefreshClientProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginCompanyController extends Controller
{
    use RefreshClientProfile;
    public function loginCompany(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse([], 400, $validator->errors()->first());
        }

        if (!Auth::guard('web')->attempt($request->only(['email', 'password']))) {
            return $this->apiResponse([], 401, 'Auth Failed');
        }

        $user = User::where('email', $request->email)->first();
        $user['token'] = $user->createToken("API TOKEN")->plainTextToken;

        return $this->apiResponse(['email' => $user->email, 'token' => $user->token], 200, 'Login Successfully');
    }
}
