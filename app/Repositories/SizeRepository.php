<?php

namespace App\Repositories;

use App\Models\Size;
use Illuminate\Http\Request;
use App\Traits\CRUDResponses;
use Illuminate\Support\Facades\DB;
use App\Interfaces\SizeRepositoryInterface;

class SizeRepository implements SizeRepositoryInterface
{
    use CRUDResponses;

    public function index()
    {
        try {

            $category = request()->query('category');

            $sizes = Size::where('category_id', $category)->with('category')->orderBy('created_at', 'DESC')->get();

            return $this->success('Fetched Sizes', $sizes);

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }

    }


    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $size = Size::create($request->all());

            DB::commit();

            return $this->success('Size has been created successfully.');

        } catch (\Exception $e) {

            DB::rollback();

            return $this->error($e->getMessage());

        }
    }

    public function update(Request $request, Size $size)
    {
        DB::beginTransaction();

        try {
            if($size)
            {
                $size->update($request->all());

                DB::commit();

                return $this->success('Size has been updated successfully.');

            }

            return $this->error('Data not found');

        } catch (\Exception $e) {

            DB::rollback();

            return $this->error($e->getMessage());

        }
    }

    public function delete(Size $size)
    {
        try {
            if($size)
            {
                $size->delete();
            }

            return $this->success('Size has been deleted');

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }
    }

    public function setStatus(Request $request, Size $size)
    {
        try {

           if($size)
           {

                $status = $request->query('status');

                $size->update(['is_active' => $status]);


                return $this->success('Size Status has been changed');

           }

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }

    }

    public function setDefault(Request $request, Size $size)
    {
        try {

           if($size)
           {

                Size::where('category_id', $size->category_id)->where('id', '!=', $size->id)->update(['is_default' => 0]);

                $size->update(['is_default' => 1]);

                return $this->success('Size is set to default.');

           }

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }

    }
}
