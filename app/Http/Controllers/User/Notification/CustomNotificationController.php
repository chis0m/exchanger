<?php

namespace App\Http\Controllers\User\Notification;

use App\Services\CustomNotification as NotificationService;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomNotification;
use Carbon\Carbon;
use App\User;

class CustomNotificationController extends Controller
{

    public function getNotification($id)
    {
        $data = CustomNotification::find($id)->toArray();
        return $this->success('Notification successful', $data, Response::HTTP_OK);
    }


    public function getUserNotification()
    {
        $data = CustomNotification::whereUserId(auth()->id())->orderBy('created_at', 'desc')->get()->toArray();
        return $this->success('Notification successful', $data, Response::HTTP_OK);
    }

    public function create(Request $request)
    {
        $data = (new NotificationService())->createNotification($request);
        return $this->success('User Notification successful', $data, Response::HTTP_OK);
    }


    public function markAsRead($id)
    {

        $notification = CustomNotification::find($id);
        $notification->update(['read_at' => Carbon::now()]);
        return $this->success('User Notification mark as read', $notification, Response::HTTP_OK);
    }


    public function getReadNotification()
    {
        $data = CustomNotification::whereUserId(auth()->id())->whereNotNull('read_at')->get();
        return $this->success('User Read Notification successful', $data, Response::HTTP_OK);
    }


    public function getUnReadNotification()
    {
        $data = CustomNotification::whereUserId(auth()->id())->whereNull('read_at')->get();
        return $this->success('User Unread notification successful', $data, Response::HTTP_OK);
    }
}
