<?php

namespace App\Http\Controllers\API\V1;

use App\Models\ServiceRequest;
use App\Http\Requests\StoreServiceRequestRequest;
use App\Http\Requests\UpdateServiceRequestRequest;

class ServiceRequestController extends BaseController
{


    protected $ServiceRequest = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ServiceRequest $ServiceRequest)
    {
        $this->middleware('auth:api');
        $this->ServiceRequest = $ServiceRequest;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('dd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreServiceRequestRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceRequestRequest $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceRequest  $serviceRequest
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceRequest $serviceRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceRequest  $serviceRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceRequest $serviceRequest)
    {
        dd('dd');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceRequestRequest  $request
     * @param  \App\Models\ServiceRequest  $serviceRequest
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequestRequest $request, ServiceRequest $serviceRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceRequest  $serviceRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceRequest $serviceRequest)
    {
        //
    }
}
