<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Requests\SettingRequest;
use App\Interfaces\SettingRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;

class SettingController extends Controller
{
    private SettingRepositoryInterface $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->settingRepository = $settingRepository;
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = $this->settingRepository->index();
        $categories = $this->categoryRepository->index();

        return Inertia::render('Setting/Index', [
            "setting" => $setting['data'],
            "categories" => $categories['data'],
        ]);
    }

    /**
     * Update the specified resource in storage.
    */
    public function update(SettingRequest $request, Setting $setting)
    {
        $updateSetting = $this->settingRepository->update($request,$setting);

        return redirect()->route('settings.index');
    }
}
