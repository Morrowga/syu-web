<?php

namespace App\Interfaces\Api;

use Illuminate\Http\Request;

interface NotificationRepositoryInterface
{
    public function getNotifications();

    public function deleteNotification($notification);

    public function readNotification($notification);

    public function clearNotification();
}
