<?php

namespace App\Http\Controllers\PushNotifications;

use App\Devices\PushNotification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class PushNotificationController extends Controller
{
    public function index(Request $request)
    {
        $pushNotification = PushNotification::all();
        return view('push-notification.index', compact('pushNotification'));
    }

    public function create(Request $request)
    {
        return view('push-notification.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'message' => 'required'
        ]);

        $pushNotification = new PushNotification([
            'platform' => 'android',
            'title' => $request->input('title'),
            'message' => $request->input('message')
        ]);
        $pushNotification->save();

        $pushNotification->send();

        return redirect()->route('push-notifications')->with('success', 'Successfull !');
    }
}
