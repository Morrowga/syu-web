<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\CRUDResponses;
use Illuminate\Support\Facades\DB;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    use CRUDResponses;

    public function index()
    {

        try {

            $users = User::orderBy('created_at', 'DESC')->get();

            return $this->success('Fetched Users', $users);

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }

    }


    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $user = User::create($request->all());

            DB::commit();

            return $this->success('User has been created successfully.');

        } catch (\Exception $e) {

            DB::rollback();

            return $this->error($e->getMessage());

        }
    }

    public function update(Request $request, User $user)
    {
        DB::beginTransaction();

        try {
            if($user)
            {
                $user->update($request->all());

                DB::commit();

                return $this->success('User has been updated successfully.');

            }

            return $this->error('Data not found');

        } catch (\Exception $e) {

            DB::rollback();

            return $this->error($e->getMessage());

        }
    }

    public function delete(User $user)
    {
        try {

            $msisdn = '09795864194';

            if($user && $user->msisdn != $msisdn)
            {
                $user->delete();

                return $this->success('User has been deleted');
            }

            return $this->error('Cannot delete admin account');

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }
    }

    public function setStatus(Request $request, User $user)
    {

        try {

           if($user)
           {

                $status = $request->query('status');

                $user->update(['is_active' => $status]);

                return $this->success('User Status has been changed');

           }

        } catch (\Exception $e) {

            return $this->error($e->getMessage());

        }

    }
}
