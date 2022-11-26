<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Requests\API\RoleRequest;
use App\Http\Requests\API\UpdateRoleRequest;
use App\Http\Resources\API\RoleResource;
use App\Services\API\RoleService;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    protected $roleService;

    public function __construct()
    {
        $this->roleService = new RoleService;
    }
    public function index(Request $request) {

        $search = '';
        if ($request->has('search')) {
            $search = $request->input('search');
        }

        $result = RoleResource::collection($this->roleService->searchRole($search));
        return $this->sendSuccess($result);

    }

    public function store(RoleRequest $request)
    {
        $name = $request->input('name');
        $description = $request->input('description');
        $permission_id = $request->input('permission_id');

        return $this->roleService->handleAdd($name, $description, $permission_id);
    }

    public function show($role)
    {
        $role = $this->roleService->getId($role);
        $permissionsChecked = $role->permissions;

        $result = [
            'role' => $role,
            'permissionsChecked' => $permissionsChecked
        ];

        return sendResponse($result,'Show Data Success');
    }

    function update($role, UpdateRoleRequest $request) {
        
        $name = $request->input('name');
        $description = $request->input('description');
        $permission_id = $request->input('permission_id');

        return $this->roleService->handleUpdate($role,$name, $description, $permission_id);
    }

    public function delete($role){
        $this->roleService->delete($role);
        return sendResponse([],'Delete Data Success');
    }
}
