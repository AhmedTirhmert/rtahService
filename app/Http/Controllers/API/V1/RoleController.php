<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    protected $role = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Role $role)
    {
        $this->middleware('auth:api');
        $this->role = $role;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->role->all();

        return $this->sendResponse($categories, 'Role list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $categories = $this->role->pluck('name', 'id');

        return $this->sendResponse($categories, 'Role list');
    }


    /**
     * Store a newly created resource in storage.
     *
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $tag = $this->role->create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        ]);

        return $this->sendResponse($tag, 'Role Created Successfully');
    }

    /**
     * Update the resource in storage
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $tag = $this->role->findOrFail($id);

        $tag->update($request->all());

        return $this->sendResponse($tag, 'Role Information has been updated');
    }
}
