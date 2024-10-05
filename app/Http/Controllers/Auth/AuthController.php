<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Interface\Auth\AuthInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthInterface $repository;
    public function __construct(AuthInterface $repository){
        $this->repository = $repository;
    }

    final public function register(RegisterRequest $request){
        return $this->repository->register($request->validated());
    }
    final public function login(LoginRequest $request){
            return $this->repository->login($request->validated());
    }
    final public function logout(){
        return $this->repository->logout();
    }

}
