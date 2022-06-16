<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Complain;
use App\Http\Requests\Complains\ComplainRequest;
use Illuminate\Support\Facades\Auth;

class ComplainController extends BaseController
{

    protected $complain = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Complain $complain)
    {
        $this->middleware('auth:api');
        $this->complain = $complain;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ComplainRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ComplainRequest $request)
    {
        $complain = $this->complain->where('user_id',Auth::user()->id)->where('service_request_id' , $request->get('id'))->count();
        if(!$complain){
            $complain = $this->complain->create([
                'service_request_id' => $request->get('id'),
                'user_id' => Auth::user()->id,
                'message' => $request->get('message'),
            ]);
            return $this->sendResponse($complain, 'Compaint inserted Successfully');
        }else{
            return $this->sendError('You already sent a Complaint for this request');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Complains  $complains
     * @return \Illuminate\Http\Response
     */
    public function show(Complains $complains)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Complains  $complains
     * @return \Illuminate\Http\Response
     */
    public function edit(Complain $complains)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ComplainRequest  $request
     * @param  \App\Models\Complains  $complains
     * @return \Illuminate\Http\Response
     */
    public function update(ComplainRequest $request, Complain $complains)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Complains  $complains
     * @return \Illuminate\Http\Response
     */
    public function destroy(Complain $complains)
    {
        //
    }
}
