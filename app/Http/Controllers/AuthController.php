<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Registration
     *
     * @param RegistrationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registration(RegistrationRequest $request)
    {
        $user = User::query()
            ->create([
                'password' => Hash::make($request->password)
            ] + $request->validated());

        return response()->json([
            'date' => [
                'user_token' => $user->generateToken(),
            ],
        ], 201);
    }

    /**
     * Auth
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if(Auth::attempt($request->validated())) {
            return response()->json([
                'date' => [
                    'user_token' => Auth::user()->generateToken(),
                ],
            ], 201);
        }

        return response()->json([
            'error' => [
                'code' => 401,
                'message' => 'Authentication failed',
            ],
        ], 401);
    }

    /**
     * Logout
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::user()->removeToken();

        return response()->json([
            'data' => [
                'message' => 'logout',
            ],
        ]);
    }
}
