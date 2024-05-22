<?php

namespace App\Repositories\Api;

use App\Models\OTP;
use App\Models\User;
use App\Models\Setting;
use App\Models\ShippingCity;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\SettingResource;
use App\Http\Resources\ShippingCityResource;
use App\Interfaces\Api\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    use ApiResponses;

    public function login(Request $request)
    {
        DB::beginTransaction();

        try {

            $user = User::where('msisdn', $request->msisdn)->first();

            if (!$user) {

                $user = User::create([
                    'msisdn' => $request->msisdn,
                    'name' => 'syuuser_' . generateRandomString(10),
                    'password' => Hash::make('syu2024'),
                    'email' => null,
                    'is_active' => 1,
                    'shipping_address' => null,
                    'gender' => 'empty'
                ]);

            }

            $this->generateOtp($user->msisdn, 4);

            DB::commit();

            return $this->success('User fetched successfully.', new UserResource($user));


        } catch (\Exception $e) {

            return $this->error($e->getMessage(), 500);

        }
    }

    public function sendOtp($msisdn)
    {
        DB::beginTransaction();

        try {

            $this->generateOtp($msisdn, 4);

            DB::commit();

            return $this->success('Message sent successfully.');

        } catch (\Exception $e) {

            DB::rollback();

            return $this->error($e->getMessage(), 500);

        }
    }

    public function verifyOtp(Request $request)
    {
        try {

            $otpRecord = OTP::where('msisdn', $request->msisdn)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

            if (!$otpRecord) {

                return $this->error('OTP is Invalid or Expired');

            }

            $user = User::where('msisdn', $request->msisdn)->first();

            if($user)
            {

                auth()->login($user);

                $token = $user->createToken('auth_token')->plainTextToken;

                $otpRecord->delete();

                return $this->success('OTP is verified successfully.', new UserResource($user), $token);

            }

            return $this->error('Phone number does not exist.', 400);

        } catch (\Exception $e) {

            return $this->error($e->getMessage(), 500);

        }
    }

    public function logout()
    {
        try {

            $user = Auth::user();

            $user->currentAccessToken()->delete();

            return $this->success('User logout successfully.');

        } catch (\Exception $e) {

            return $this->error($e->getMessage(), 500);

        }
    }

    public function setting()
    {
        try {

            $setting = Setting::first();

            return $this->success('Setting fetched successfully.', new SettingResource($setting));

        } catch (\Exception $e) {

            return $this->error($e->getMessage(), 500);

        }
    }

    public function updateProfile(Request $request)
    {
        DB::beginTransaction();

        try {

            $user = Auth::user();

            $user->update($request->all());

            DB::commit();

            return $this->success('Profile is updated successfully.', new UserResource($user));

        } catch (\Exception $e) {

            DB::rollback();

            return $this->error($e->getMessage(), 500);
        }
    }

    public function getShippingCities()
    {
        try {

            $shipping_cities = ShippingCity::where('is_active', 1)->orderBy('name_en', 'ASC')->get();

            return $this->success('Shipping Cities fetched successfully.', ShippingCityResource::collection($shipping_cities));

        } catch (\Exception $e) {

            return $this->error($e->getMessage(), 500);
        }
    }

    public function getProfile()
    {
        try {

            $user = Auth::user();

            $user->load('shippingcity');

            return $this->success('User Profile fetched successfully.', new UserResource($user));

        } catch (\Exception $e) {

            return $this->error($e->getMessage(), 500);
        }
    }

    public function generateOtp($msisdn, $length)
    {
        $otp = mt_rand(pow(10, $length - 1), pow(10, $length) - 1);

        $expirationTime = now()->addMinutes(5);

        $existingOtp = OTP::where('msisdn', $msisdn)->first();

        if ($existingOtp) {

            if ($existingOtp->expires_at && $existingOtp->expires_at > now()) {

                $existingOtp->update([
                    'otp' => $otp,
                    'expires_at' => $expirationTime
                ]);

            } else {

                $existingOtp->delete();

                OTP::create([
                    'msisdn' => $msisdn,
                    'otp' => $otp,
                    'expires_at' => $expirationTime
                ]);

            }

        } else {

            OTP::create([
                'msisdn' => $msisdn,
                'otp' => $otp,
                'expires_at' => $expirationTime
            ]);

        }
    }
}
