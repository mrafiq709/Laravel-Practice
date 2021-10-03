<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiRequest;
use App\Http\Requests\User\IndexUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\User\IndexUserService;
use App\Services\User\UpdateUserService;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     * 
     * @param IndexUserRequest $request
     * @param IndexUserService $service
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexUserRequest $request, IndexUserService $service)
    {
        $service->index($request);
        return responder()->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        responder()->success($user->toArray());
        return responder()->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user, UpdateUserService $service)
    {
        $service->update($request, $user);
        return responder()->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $ok = $user->delete();
        responder()->success($user->toArray());
        responder()->addData(['deleted' => $ok]);

        return responder()->toJson();
    }

    /**
    * Me
    *
    * @param  ApiRequest $request
    * @return \Illuminate\Http\Response
    */
   public function me(ApiRequest $request)
   {
       responder()->success($request->user()->toArray());
       return responder()->toJson();
   }
}
