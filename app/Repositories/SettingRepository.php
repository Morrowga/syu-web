<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\CRUDResponses;
use Illuminate\Support\Facades\DB;
use App\Interfaces\SettingRepositoryInterface;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SettingRepository implements SettingRepositoryInterface
{
    use CRUDResponses;

    public function index()
    {
        try {
            $setting = Setting::first();

            return $this->success('Fetched Setting', $setting);

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }

    }


    public function update(Request $request, Setting $setting)
    {
        DB::beginTransaction();

        try {
            if($setting)
            {
                if($request->setting_type == 'general')
                {

                    $setting->update($request->all());

                    $categories = json_decode($request->categories, true);

                    if(count($categories) > 0)
                    {
                        foreach($categories as $category)
                        {
                            $categoriesFromEloquent = Category::where('id', $category['id'])->first();
                            $categoriesFromEloquent->is_active = $category['is_active'];
                            $categoriesFromEloquent->waiting_days = $category['waiting_days'];
                            $categoriesFromEloquent->limitation = $category['limitation'];
                            $categoriesFromEloquent->save();
                        }
                    }

                } else if($request->setting_type == 'banner')
                {
                    $remove_images = json_decode($request->remove_images, true);

                    if(count($remove_images) > 0)
                    {
                    $mediaItems = Media::whereIn('id', $remove_images)->get();

                        foreach ($mediaItems as $media) {

                            $media->delete();

                        }
                    }

                    if ($request->hasFile('images')) {
                        foreach ($request->file('images') as $file) {
                            $setting->addMedia($file)->toMediaCollection('banners', 'banner');
                        }
                    }

                }

                DB::commit();

                return $this->success('Setting has been updated');
            }

            return $this->error('Data not found');

        } catch (\Exception $e) {

            DB::rollback();

            return $this->error($e->getMessage());

        }
    }
}
