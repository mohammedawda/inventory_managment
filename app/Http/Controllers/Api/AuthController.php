<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Logic\UserAuthentication;
use Throwable;

class AuthController extends Controller
{
    /**
     * POST /api/register
     * Register new user
     */
    public function register(RegisterRequest $request)
    {
        try {
            $register = UserAuthentication::make($request)->register();
            return response()->json($register, 201);
        } catch(Throwable $e) {
            return Throwable($e);
        }
    }

    /**
     * POST /api/login
     * login to system
     */
    public function login(LoginRequest $request)
    {
        try {
            $login = UserAuthentication::make($request)->login();
            return response()->json($login);
        } catch(Throwable $e) {
            return Throwable($e);
        }
    }

    /**
     * POST /api/login
     * login to system
     */
    public function logout(LoginRequest $request)
    {
        try {
            $logout = UserAuthentication::make($request)->logout();
            return response()->json($logout);
        } catch(Throwable $e) {
            return Throwable($e);
        }
    }
}
