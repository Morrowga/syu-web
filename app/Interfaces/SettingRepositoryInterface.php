<?php

namespace App\Interfaces;

use App\Models\Setting;
use Illuminate\Http\Request;

interface SettingRepositoryInterface
{
    public function index();

    public function update(Request $request, Setting $setting);
}
