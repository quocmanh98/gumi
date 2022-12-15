<?php

namespace App\Http\Controllers\Admin;

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
     * Summary of index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $permissions = PermissionResource::collection($this->permissionService->getList());
        return sendResponse($permissions,'Fetch Data Success');
    }

    /**
     * Summary of store
     * @param PermissionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PermissionRequest $request)
    {
        $name = $request->input('name');
        $title = $request->input('title');

        $dataInput = [
            'name' => $name,
            'title' => $title,
            'group_permission_id' =>  $request->input('group_permission_id')
        ];

        $this->permissionService->savePermission( $dataInput );
        return sendResponse('','Add Permission Success');
    }

    /**
     * Summary of update
     * @param int $id
     * @param UpdatePermissionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $id,UpdatePermissionRequest $request)
    {
        $name = $request->input('name');
        $title = $request->input('title');
        $groupPermissionId = $request->input('group_permission_id');

        $this->permissionService->updatePermission($id, $name, $title, $groupPermissionId);
        return sendResponse([],'Update Permission Success');
    }

    /**
     * Summary of show
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $result = new PermissionResource($this->permissionService->getId($id));
        return sendResponse($result, 'Fetch Permission Success');
    }

    /**
     * Summary of destroy
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $this->permissionService->deletePermission($id);
        return sendResponse([], 'Delete Permission Success');
    }
}
