<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserContactInfoRequest;
use App\Http\Requests\UpdateUserContactInfoRequest;
use App\Models\UserContactInfo;

class UserContactInfoController extends Controller
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
    public function store(StoreUserContactInfoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserContactInfo $userContactInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserContactInfo $userContactInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserContactInfoRequest $request, UserContactInfo $userContactInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserContactInfo $userContactInfo)
    {
        //
    }
}
