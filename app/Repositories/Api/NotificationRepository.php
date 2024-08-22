<?php

namespace App\Repositories\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Api\NotificationRepositoryInterface;

class NotificationRepository implements NotificationRepositoryInterface
{
    use ApiResponses;

    public function getNotifications()
    {
        try {
            $user = Auth::user();

            $notifications = $user->notifications;

            return $this->success('Notifications fetched successfully.', $notifications);

        } catch (\Exception $e) {

            return $this->error($e->getMessage(),500);

        }
    }

    public function deleteNotification($notification)
    {
        try {
            $user = Auth::user();

            $deleteNotification = $user->notifications()->find($notification);

            if($deleteNotification)
            {
                $deleteNotification->delete();

                return $this->success('Notifications deleted successfully.', []);
            }

            return $this->success('Notifications not found.', []);

        } catch (\Exception $e) {

            return $this->error($e->getMessage(),500);

        }
    }

    public function readNotification($notification)
    {
        try {
            $user = Auth::user();

            $readNotification = $user->notifications()->find($notification);

            if($readNotification)
            {
                $readNotification->read_at =  Carbon::now();
                $readNotification->save();

                return $this->success('Notifications read successfully.', []);
            }

            return $this->success('Notifications not found.', []);

        } catch (\Exception $e) {

            return $this->error($e->getMessage(),500);

        }
    }

    public function clearNotification()
    {
        try {
            $user = Auth::user();

            $readNotification = $user->notifications()->delete();

            return $this->success('Notifications cleared successfully.', []);

        } catch (\Exception $e) {

            return $this->error($e->getMessage(),500);

        }
    }
}
