<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\PermissionRequest;
use App\Http\Requests\API\UpdatePermissionRequest;
use App\Http\Resources\API\PermissionResource;
use App\Services\API\PermissionService;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct()
    {
        $this->permissionService = new PermissionService();
    }

    /**
     * Danh sách quyền
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $permissions = $this->permissionService->getList();
        $permissions = PermissionResource::collection($permissions);

        return sendResponse($permissions,'Fetch Data Success');
    }

    /**
     * Thêm quyền
     * @param PermissionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PermissionRequest $request)
    {
        $name = $request->input('name');


        $dataInput = [
            'name' => $name,
            'group_permission_id' => $request->input('group_permission_id')
        ];

        $result = $this->permissionService->savePermission( $dataInput );
        return sendResponse($result, 'Add Permission Success');
    }

    /**
     * Cập nhật quyền
     * @param int $id
     * @param UpdatePermissionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdatePermissionRequest $request)
    {
        $name = $request->input('name');
        $groupPermissionId = $request->input('group_permission_id');

        $this->permissionService->updatePermission($id, $name, $groupPermissionId);
        return sendResponse([],'Update Permission Success');
    }

    /**
     * Xem bản ghi cụ thể quyền
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $permission = $this->permissionService->getId($id);
        $permission = new PermissionResource($permission);
        return sendResponse($permission, 'Fetch Permission Success');
    }

    /**
     * Xóa quyền
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->permissionService->deletePermission($id);
        return sendResponse([], 'Delete Permission Success');
    }
}
