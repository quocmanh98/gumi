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
     * Lấy danh sách vai trò
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {

        $search = '';
        if ($request->has('search')) {
            $search = $request->input('search');
        }

        $result = RoleResource::collection($this->roleService->getSearchRole($search));
        return $this->sendSuccess($result);
    }

    /**
     * Thêm vai trò
     * @param RoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RoleRequest $request)
    {
        $name = $request->input('name');
        $description = $request->input('description');
        $permissionId = $request->input('permission_id');

        $result = $this->roleService->handleSaveRole($name, $description, $permissionId);
        return sendResponse($result, 'Add Role Success');
    }

    /**
     * Xem thông tin chi tiết vai trò
     * @param mixed $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($role)
    {
        try {
            $role = $this->roleService->getRoleInfo($role);
            $permissionsChecked = $role->permissions;

            $result = [
                'role' => $role,
                'permissionsChecked' => $permissionsChecked,
            ];
            return sendResponse($result, 'Show Data Role Success');
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Cập nhật thông tin vai trò
     * @param mixed $role
     * @param UpdateRoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($role, UpdateRoleRequest $request)
    {
        $name = $request->input('name');
        $description = $request->input('description');
        $permissionId = $request->input('permission_id');

        try {
            return $this->roleService->handleUpdateRole($role, $name, $description, $permissionId);
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }

    /**
     * Xóa vai trò
     * @param mixed $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($role)
    {
        try {
            $this->roleService->handleDeleteRole($role);
            return sendResponse([], 'Delete Data Success');
        } catch (\Exception$e) {
            return $this->sendError(null, $e->getMessage());
        }
    }
}
