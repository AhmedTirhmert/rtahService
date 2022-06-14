<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\ServiceRequests\ServiceRequestRequest;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;

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
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function recieved()
    {

        $servicRrequests = $this->ServiceRequest->whereHas('service', function ($innerQuery) {
            $innerQuery->where('services.user_id', Auth::user()->id);
        })->where('pending', true)->with('service', 'client', 'service.product', 'service.product.category')->paginate(10);

        return $this->sendResponse($servicRrequests, 'Recieved requests list');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sent()
    {

        $servicRrequests = $this->ServiceRequest->with('service', 'client', 'service.product','service.user', 'service.product.category')->where('user_id', Auth::user()->id)->where('pending', true)->paginate(10);

        return $this->sendResponse($servicRrequests, 'Sent requests list');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function recievedAndApproved()
    {
        $servicRrequests = $this->ServiceRequest->whereHas('service', function ($innerQuery) {
            $innerQuery->where('services.user_id', Auth::user()->id);
        })->where('pending', false)->where('accepted', true)->with('service', 'client', 'service.product', 'service.product.category')->paginate(10);

        return $this->sendResponse($servicRrequests, 'Approved recieved requests list');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function recievedAndRejected()
    {
        $servicRrequests = $this->ServiceRequest->whereHas('service', function ($innerQuery) {
            $innerQuery->where('services.user_id', Auth::user()->id);
        })->where('pending', false)->where('accepted', false)->with('service', 'client', 'service.product', 'service.product.category')->paginate(10);

        return $this->sendResponse($servicRrequests, 'Approved recieved requests list');
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sentAndApproved()
    {
        $servicRrequests = $this->ServiceRequest->with('service', 'client', 'service.product','service.user', 'service.product.category')->where('user_id', Auth::user()->id)->where('pending', false)->where('accepted', true)->paginate(10);

        return $this->sendResponse($servicRrequests, 'Approved sent requests list');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sentAndRejected()
    {
        $servicRrequests = $this->ServiceRequest->with('service', 'client', 'service.product','service.user', 'service.product.category')->where('user_id', Auth::user()->id)->where('pending', false)->where('accepted', false)->paginate(10);

        return $this->sendResponse($servicRrequests, 'Rejected sent requests list');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreServiceRequestRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequestRequest $request)
    {

        $servicRrequest = $this->ServiceRequest->create([
            'service_id' => $request->get('service_id'),
            'user_id' => Auth::user()->id,
            'pending' => true,
            'accepted' => false
        ]);

        return $this->sendResponse($servicRrequest, 'Service Request Sent Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceRequest  $serviceRequest
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceRequestRequest $serviceRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceRequest  $serviceRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceRequestRequest $serviceRequest)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceRequestRequest  $request
     * @param  \App\Models\ServiceRequest  $serviceRequest
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequestRequest $request,$id)
    {
        $serviceRequest = $this->ServiceRequest->findOrFail($id);

        $serviceRequest->update([
            'pending' => $request->get('pending'),
            'accepted' => $request->get('accepted'),
        ]);

        return $this->sendResponse($serviceRequest, '');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceRequest  $serviceRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ServiceRequest = $this->ServiceRequest->findOrFail($id);
        if (Auth::user()->isAdmin() || $ServiceRequest->with('client')->find($id)->client->id == Auth::user()->id) {
            $ServiceRequest->delete();
            return $this->sendResponse($ServiceRequest, 'Request has been Deleted');
        }
        return $this->sendResponse(false, 'Unauthorized');
    }
}
