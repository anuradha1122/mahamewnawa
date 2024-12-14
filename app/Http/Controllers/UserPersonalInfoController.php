<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserPersonalInfoRequest;
use App\Http\Requests\UpdateUserPersonalInfoRequest;
use App\Models\UserPersonalInfo;

class UserPersonalInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserPersonalInfoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserPersonalInfo $userPersonalInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserPersonalInfo $userPersonalInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserPersonalInfoRequest $request, UserPersonalInfo $userPersonalInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserPersonalInfo $userPersonalInfo)
    {
        //
    }
}
