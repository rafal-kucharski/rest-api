<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RoleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     */
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->sendResponse(Role::with('permissions')->get(), 'Roles retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $role = Role::create(['name' => $input['name']]);
        $role->syncPermissions($input['permission']);

        return $this->sendResponse($role->toArray(), 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  Role  $role
     * @return Response
     */
    public function show(Role $role)
    {
        if ($role instanceof ModelNotFoundException) {
            return $this->sendError('Role not found.');
        }

        $result = Role::with('permissions')->where('id', $role->id)->firstOrFail();

        return $this->sendResponse($result, 'Role retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Role  $role
     * @return Response
     */
    public function update(Request $request, Role $role)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|unique:roles,name,'.$role->id.',id',
            'permission' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $role->name = $input['name'];
        $role->save();

        $role->syncPermissions($input['permission']);

        return $this->sendResponse($role->toArray(), 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role  $role
     * @return Response
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return $this->sendResponse($role->toArray(), 'Role deleted successfully.');
    }

}
