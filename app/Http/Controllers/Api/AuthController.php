<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * SIgnup user
     */
    public function signup(SignUpRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            return $this->res(201, true, 'User Created Successfully', new UserResource($user));
        } catch (Exception $e) {
            return $this->res(500, false, $e->getMessage());
        }
    }

    /**
     * Login user and create token
     */
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
            return $this->res(401, false, 'Unauthorized');
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();
        $user->access_token = $tokenResult->accessToken;
        $user->save();
        return $this->res(200, true, 'User Authenticated Successfully', new UserResource($user));
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->res(200, true, 'Logout successful');
    }
}