<?php

namespace App\Repositories;

use App\Models\Quality;
use Illuminate\Http\Request;
use App\Traits\CRUDResponses;
use Illuminate\Support\Facades\DB;
use App\Interfaces\QualityRepositoryInterface;

class QualityRepository implements QualityRepositoryInterface
{
    use CRUDResponses;

    public function index()
    {
        try {
            $category = request()->query('category');

            $qualities = Quality::where('category_id', $category)->with('category')->orderBy('created_at', 'DESC')->get();

            return $this->success('Fetched Qualities', $qualities);

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }

    }


    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $quality = Quality::create($request->all());

            DB::commit();

            return $this->success('Quality has been created successfully.');

        } catch (\Exception $e) {

            DB::rollback();

            return $this->error($e->getMessage());

        }
    }

    public function update(Request $request, Quality $quality)
    {
        DB::beginTransaction();

        try {
            if($quality)
            {
                $quality->update($request->all());

                DB::commit();

                return $this->success('Quality has been updated successfully.');

            }

            return $this->error('Data not found');

        } catch (\Exception $e) {

            DB::rollback();

            return $this->error($e->getMessage());

        }
    }

    public function delete(Quality $quality)
    {
        try {
            if($quality)
            {
                $quality->delete();
            }

            return $this->success('Quality has been deleted');

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }
    }

    public function setStatus(Request $request, Quality $quality)
    {
        try {

           if($quality)
           {

                $status = $request->query('status');

                $quality->update(['is_active' => $status]);


                return $this->success('Quality Status has been changed');

           }

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }

    }

    public function setDefault(Request $request, Quality $quality)
    {
        try {

           if($quality)
           {

                Quality::where('category_id', $quality->category_id)->where('id', '!=', $quality->id)->update(['is_default' => 0]);

                $quality->update(['is_default' => 1]);

                return $this->success('Quality is set to default.');

           }

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }

    }
}
