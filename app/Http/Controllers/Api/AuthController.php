<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\SendOtpRequest;
use App\Http\Requests\Api\VerifyOtpRequest;
use App\Http\Requests\Api\ProfileUpdateRequest;
use App\Interfaces\Api\AuthRepositoryInterface;

class AuthController extends Controller
{
    private AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login(LoginRequest $request)
    {
        return $this->authRepository->login($request);
    }

    public function sendOtp(SendOtpRequest $request)
    {
        return $this->authRepository->sendOtp($request->msisdn);
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
        return $this->authRepository->verifyOtp($request);
    }

    public function logout()
    {
        return $this->authRepository->logout();
    }

    public function setting()
    {
        return $this->authRepository->setting();
    }

    public function updateProfile(ProfileUpdateRequest $request)
    {
        return $this->authRepository->updateProfile($request);
    }

    public function getShippingCities()
    {
        return $this->authRepository->getShippingCities();
    }

    public function getProfile()
    {
        return $this->authRepository->getProfile();
    }

}
