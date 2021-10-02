<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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
        return $service->index($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user->toArray());
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
        return $service->update($request, $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json($user->toArray());
    }
}
