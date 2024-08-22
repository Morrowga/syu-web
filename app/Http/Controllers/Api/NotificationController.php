<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\Api\NotificationRepositoryInterface;

class NotificationController extends Controller
{
    private NotificationRepositoryInterface $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function index()
    {
        return $this->notificationRepository->getNotifications();
    }

    public function delete($notification)
    {
        return $this->notificationRepository->deleteNotification($notification);
    }

    public function read($notification)
    {
        return $this->notificationRepository->readNotification($notification);
    }

    public function clear()
    {
        return $this->notificationRepository->clearNotification();
    }
}
