<?php

namespace App\Http\Controllers\API\V1;

use App\Models\feedback;
use App\Http\Requests\Feedbacks\FeedbackRequest;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends BaseController
{

    
    protected $feedback = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(feedback $feedback)
    {
        $this->middleware('auth:api');
        $this->feedback = $feedback;
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
     * @param  \App\Http\Requests\FeedbackRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FeedbackRequest $request)
    {
        $feedback = $this->feedback->where('user_id',Auth::user()->id)->where('service_id' , $request->get('service_id'))->where('service_request_id' , $request->get('id'))->count();
        if(!$feedback){
            $feedback = $this->feedback->create([
                'service_id' => $request->get('service_id'),
                'service_request_id' => $request->get('id'),
                'user_id' => Auth::user()->id,
                'rating' => $request->get('rating'),
                'message' => $request->get('message'),
            ]);
            return $this->sendResponse($feedback, 'FeedBack inserted Successfully');
        }else{
            return $this->sendError('You already sent FeedBack for this Service');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(FeedbackRequest $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatefeedbackRequest  $request
     * @param  \App\Models\feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(FeedbackRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
