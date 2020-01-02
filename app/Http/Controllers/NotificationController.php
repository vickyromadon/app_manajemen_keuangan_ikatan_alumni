<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function show($id)
    {
        if (isset($_GET['id'])) {
            $notification = Notification::find(intval($_GET['id']));
            $notification->status = Notification::STATUS_READ;
            $notification->save();
        }

        return $this->view([
            'data' => Notification::find($id),
        ]);
    }
}
