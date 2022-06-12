<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Services\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends BaseController
{

    protected $Service = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Service $Service)
    {
        $this->middleware('auth:api');
        $this->Service = $Service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $Services = $this->Service->with('user', 'product', 'product.category')->latest()->paginate(10);
        } else {
            $Services = $this->Service->with('user', 'product', 'product.category')->where('user_id', '!=', Auth::user()->id)->latest()->paginate(10);
        }
        return $this->sendResponse($Services, 'Service list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        if (Auth::user()->isAdmin()) {
            $Services = $this->Service->with('user', 'product', 'product.category')->latest()->paginate(10);
        } else {
            $Services = $this->Service->with('user', 'product', 'product.category')->where('user_id', Auth::user()->id)->latest()->paginate(10);
        }
        return $this->sendResponse($Services, 'Service list');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Services\ServiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {

        $Service = $this->Service->create([
            'user_id' => Auth::user()->id,
            'product_id' => $request->get('id'),
            'years' => $request->get('experience'),
        ]);


        return $this->sendResponse($Service, 'Service Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Service = $this->Service->with(['category', 'tags'])->findOrFail($id);

        return $this->sendResponse($Service, 'Service Details');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $Service
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request, $id)
    {
        $Service = $this->Service->findOrFail($id);

        $Service->update(['years' => $request->get('experience')]);

        return $this->sendResponse($Service, 'Service Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        $this->authorize('isAdmin');

        $Service = $this->Service->findOrFail($id);

        $Service->delete();

        return $this->sendResponse($Service, 'Service has been Deleted');
    }

    public function upload(Request $request)
    {
        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('upload'), $fileName);

        return response()->json(['success' => true]);
    }
}
