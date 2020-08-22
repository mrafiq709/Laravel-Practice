<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
    public function index(Request $request)
    {
        return view('index');
    }
}
