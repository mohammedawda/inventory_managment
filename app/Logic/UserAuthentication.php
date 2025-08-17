<?php

namespace App\Logic;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserAuthentication
{
    private $payload;
    private $userRepository;
    
    public function __construct($request)
    {
        $this->payload = $request;
        $this->userRepository = new UserRepository();
    }

    public static function make($request = null)
    {
        return new self($request);
    }

    public function register()
    {
        $user = $this->userRepository->store($this->payload);
        $token = $this->generateToken($user);
        return [
            'status'  => true,
            'message' => 'User registered successfully',
            'user'    => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ],
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => 24 * 60 * 60, // 24 hours in seconds
        ];
    }

    public function login()
    {
        $user = $this->userRepository->findByEmail($this->payload->email);
        if (!$user || !Hash::check($this->payload->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token = $this->generateToken($user);
        return [
            'status'  => true,
            'message' => 'Logged In',
            'user'    => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ],
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => 24 * 60 * 60, // 24 hours in seconds
        ];
    }

    public function logout()
    {
        $this->payload->user()->currentAccessToken()->delete();
        return [
            'status'  => true,
            'message' => 'Logged Out',
        ];
    }

    private function generateToken($user)
    {
        return $user->createToken('auth-token', ['*'], now()->addHours(24))->plainTextToken;
    }
}