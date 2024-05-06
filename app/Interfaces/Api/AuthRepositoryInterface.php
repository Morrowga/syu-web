<?php

namespace App\Interfaces\Api;

use Illuminate\Http\Request;

interface AuthRepositoryInterface
{
    public function login(Request $request);

    public function sendOtp($msisdn);

    public function verifyOtp(Request $request);

    public function logout();

    public function setting();

    public function updateProfile(Request $request);
}
