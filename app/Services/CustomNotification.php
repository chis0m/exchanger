<?php

namespace App\Services;

use App\Models\CustomNotification as Notification;
use App\User;

class CustomNotification
{

    public function createNotification($request)
    {

        $notification = Notification::create([
        'user_id' => $request['user_id'],
        'title' => $request['title'],
        'data' => $request['message'],
        ]);

        return $notification;
    }
}
