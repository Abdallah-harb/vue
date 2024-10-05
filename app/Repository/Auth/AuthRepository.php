<?php

namespace App\Repository\Auth;

use App\Http\Resources\User\UserResource;
use App\Interface\Auth\AuthInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthInterface
{
    protected $module;
    public function __construct(User $module){
        $this->module = $module;
    }

    public function register(array $data): JsonResponse
    {
       $user = $this->module->create($data);
        Auth::login($user);
       request()->session()->regenerate();
       return jsonResponse(['user' => new UserResource($user)]);
    }

    public function login(array $data): JsonResponse
    {
       if(!$user = Auth::attempt($data)){
           return errorResponse('Credential Not Match');
       }
        request()->session()->regenerate();
        $user = auth()->user();
        return jsonResponse(["user" => new UserResource($user)]);
    }
    public function logout()
    {
        $user = auth()->user();
        $user->tokens()->delete();
        return jsonResponse([],'Logged out successfully');
    }

}
