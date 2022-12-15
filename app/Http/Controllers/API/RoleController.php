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

    /**
     * Summary of index
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) {

        $search = '';
        if ($request->has('search')) {
            $search = $request->input('search');
        }

        $result = RoleResource::collection($this->roleService->getSearchRole($search));
        return $this->sendSuccess($result);
    }

    /**
     * Summary of store
     * @param RoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RoleRequest $request)
    {
        $name = $request->input('name');
        $description = $request->input('description');
        $permissionId = $request->input('permission_id');

        return $this->roleService->handleSaveRole($name, $description, $permissionId);
    }

    /**
     * Summary of show
     * @param mixed $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($role)
    {
        $role = $this->roleService->getRoleInfo($role);
        $permissionsChecked = $role->permissions;

        $result = [
            'role' => $role,
            'permissionsChecked' => $permissionsChecked
        ];

        return sendResponse($result, 'Show Data Success');
    }

    /**
     * Summary of update
     * @param mixed $role
     * @param UpdateRoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    function update($role, UpdateRoleRequest $request)
    {
        $name = $request->input('name');
        $description = $request->input('description');
        $permissionId = $request->input('permission_id');

        return $this->roleService->handleUpdateRole($role, $name, $description, $permissionId);
    }

    /**
     * Summary of destroy
     * @param mixed $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($role)
    {
        $this->roleService->handleDeleteRole($role);
        return sendResponse([], 'Delete Data Success');
    }
}
