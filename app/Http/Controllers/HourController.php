<?php

namespace App\Http\Controllers;

use App\Models\Hour;
use App\Http\Requests\StoreHourRequest;
use App\Http\Requests\UpdateHourRequest;
use App\Http\Resources\HourResource;
use Auth;

class HourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return HourResource::collection(Auth::user()->hours()->get());
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
     * @param  \App\Http\Requests\StoreHourRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHourRequest $request)
    {
        $validated = $request->validated();
        $validated['userId'] = Auth::id();
        $hour = Hour::create($validated);
        return new HourResource($hour);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hour  $hour
     * @return \Illuminate\Http\Response
     */
    public function show(Hour $hour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hour  $hour
     * @return \Illuminate\Http\Response
     */
    public function edit(Hour $hour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHourRequest  $request
     * @param  \App\Models\Hour  $hour
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHourRequest $request, Hour $hour)
    {
        $hour->update($request->validated());
        return new HourResource($hour);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hour  $hour
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hour $hour)
    {
        $hour->delete();
    }
}
