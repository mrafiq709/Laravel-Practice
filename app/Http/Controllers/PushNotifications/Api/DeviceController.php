<?php

namespace App\Http\Controllers\PushNotifications\Api;

use App\Devices\Device;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDevice;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDevice $request)
    {
        try {

            $update = Device::where('device_token', $request->device_token)
                        ->update(['push_token' => $request->push_token]);

            if($update)
            {
                return response()->json([
                    'message' => 'Push Token Updated Successfully !',
                    'data' => Device::where('device_token', $request->device_token)->get()
                ]);
            }
            
            $device = new Device();
            $device->type = $request->type;
            $device->device_token = $request->device_token;
            $device->push_token = $request->push_token;

            $device->save();

            return response()->json([
                'message' => 'Push Token Created Successfully !',
                'data' => $device
                ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => null
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(['Device' => Device::where('id', $id)->get()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $device = Device::find($id);
            $device->push_token = $request->push_token;
            $device->save();
            return response()->json([
                'message' => 'Push Token Updated Successfully !',
                'data' => $device
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'data' => null
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
